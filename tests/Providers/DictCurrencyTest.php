<?php

namespace AdsTest\Providers;

use PHPUnit\Framework\TestCase;

class DictCurrencyTest extends TestCase
{

  /** @var DictCurrency */
  protected $dict;
  
  public function setUp()
  {
    $this->dict = new DictCurrency();
  }
  
  public function testLoading()
  {
    $this->assertFalse($this->dict->isLoaded());
    $this->dict->load();
    $this->assertTrue($this->dict->isLoaded());
  }

  /**
   * @dataProvider providerGetRecordByIdReturnsSuccess
   */
  public function testGetRecordByIdReturnsSuccess($idCurrency, $currencyName)
  {
    $currency = $this->dict->getRecordById($idCurrency);

    $this->assertInstanceOf(\stdClass::class, $currency);
    $this->assertEquals($idCurrency, $currency->id);
    $this->assertEquals($currencyName, $currency->name);
    $this->assertGreaterThan(0.0, $currency->cource);
  }

  public function providerGetRecordByIdReturnsSuccess()
  {
    return [
      [DictCurrency::CURRENCY_RUB, 'RUB'],
      [DictCurrency::CURRENCY_USD, 'USD'],
    ];
  }

  /**
   * @expectedException \AdsTest\Exceptions\ObjectNotFoundException
   */
  public function testGetRecordByIdThrowsObjectNotFoundException()
  {
    $this->dict->getRecordById(9999);
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  public function testGetRecordByIdThrowsInvalidArgumentException()
  {
    $this->dict->getRecordById('123string');
  }

  /**
   * @dataProvider providerConvertPrice
   */
  public function testConvertPrice($priceTo, $priceFrom, $idCurrencyFrom, $idCurrencyTo)
  {
    $this->assertEquals(
      $priceTo,
      $this->dict->convertPrice($priceFrom, $idCurrencyFrom, $idCurrencyTo),
      '',
      0.001
    );
  }

  public function providerConvertPrice()
  {
    return [
      [100, 100, DictCurrency::CURRENCY_RUB, DictCurrency::CURRENCY_RUB],
      [1.5292, 100, DictCurrency::CURRENCY_RUB, DictCurrency::CURRENCY_USD],
    ];
  }
}