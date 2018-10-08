<?php

namespace AdsTest\Providers;

use AdsTest\Interfaces\IAdsProvider;
use AdsTest\Models\AdsItem;

class AdsProviderMysql implements IAdsProvider
{
  public function getLegacyFuncName()
  {
    return '\\getAdRecord';
  }

  public function getItem($id)
  {
    $func = $this->getLegacyFuncName();

    $row = $func($id);
    if (!$row){
      return false;
    }

    $item = new AdsItem();

    foreach ($row as $key => $val){
      $item->$key = $val;
    }
    $item->id = (int)$item->id;
    $item->price = floatval($item->price);

    return $item;
  }
}