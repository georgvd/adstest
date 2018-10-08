<?php

namespace AdsTest\Models;

use AdsTest\Providers\DictCurrency;
use PHPUnit\Framework\TestCase;

class AdsItemTest extends TestCase
{

  public function testGetPrice1()
  {
    $mockCurrency = $this->createMock(DictCurrency::class);
    $mockCurrency
      ->expects($this->never())
      ->method('convertPrice');

    $item = new AdsItem();
    $item->price = 100;

    $this->assertEquals(100, $item->getPrice($mockCurrency));
  }

  public function testGetPrice2()
  {
    $mockCurrency = $this->createMock(DictCurrency::class);
    $mockCurrency
      ->expects($this->once())
      ->method('convertPrice')
      ->with(
        10,
        DictCurrency::CURRENCY_USD,
        DictCurrency::CURRENCY_RUB
      )
      ->willReturn(999);

    $item = new AdsItem();
    $item->price = 10;

    $this->assertEquals(999, $item->getPrice($mockCurrency, DictCurrency::CURRENCY_RUB));
  }

}