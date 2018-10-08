<?php

namespace AdsTest\Providers;

use AdsTest\Models\AdsItem;

class AdsProviderDaemon extends AdsProvider
{
  public function getLegacyFuncName()
  {
    return '\\get_deamon_ad_info';
  }

  public function getItem($id)
  {
    $row = $this->legacyCall($id);
    if (!$row){
      return false;
    }

    $data = explode("\t", $row);

    $item = new AdsItem();

    $item->id = (int)$data[0];
    $item->idCampaign = (int)$data[1];
    $item->idUser = (int)$data[2];
    $item->name = $data[3];
    $item->text = $data[4];
    $item->price = floatval($data[5]);

    return $item;
  }
}