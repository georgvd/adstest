<?php

namespace AdsTest\Providers;

use AdsTest\Models\AdsItem;
use PHPUnit\Framework\TestCase;

class AdsProviderDaemonTest extends TestCase
{
  /** @var AdsProviderDaemon */
  protected $fixture;

  public function setUp()
  {
    $this->fixture = new AdsProviderDaemonTestWrapper();
  }

  public function testGetLegacyFuncName()
  {
    $funcName = $this->fixture->getLegacyFuncName();
    $this->assertTrue(function_exists($funcName));
  }

  /**
   * @dataProvider providerGetItem
   */
  public function testGetItem($id, $expectedResult)
  {
    $this->assertEquals($expectedResult, $this->fixture->getItem($id));
  }

  public function providerGetItem()
  {
    $item101 = new AdsItem();
    $item101->id = 101;
    $item101->idCampaign = 235678;
    $item101->idUser = 12348;
    $item101->name = 'AdName_FromDaemon-101';
    $item101->text = 'AdText_FromDaemon-101';
    $item101->price = 1101.0;

    $item102 = new AdsItem();
    $item102->id = 102;
    $item102->idCampaign = 235678;
    $item102->idUser = 12348;
    $item102->name = 'AdName_FromDaemon-102';
    $item102->text = 'AdText_FromDaemon-102';
    $item102->price = 1102.0;

    return [
      [101, $item101],
      [102, $item102],
      [99999, false],
    ];
  }

}