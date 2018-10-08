<?php

namespace AdsTest\Providers;

use AdsTest\Models\AdsItem;

class AdsProviderMysql extends AdsProvider
{
  public function getLegacyFuncName()
  {
    return '\\getAdRecord';
  }

  public function getItem($id)
  {
    $row = $this->legacyCall($id);
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