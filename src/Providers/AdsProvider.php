<?php

namespace AdsTest\Providers;

use AdsTest\Application;
use AdsTest\Exceptions\ObjectNotFoundException;
use AdsTest\Models\AdsItem;

/**
 * Поставщик информации об объявлениях
 */
class AdsProvider
{
  const SOURCE_DAEMON = 'Daemon';
  const SOURCE_DATABASE = 'Mysql';

  public function isValidSource($source)
  {
    return in_array($source, [static::SOURCE_DATABASE, static::SOURCE_DAEMON], true);
  }

  /**
   * Получить объект объявления из источника $source
   * @param string $source См. константы static::SOURCE_*
   * @param int $id ID объявления
   * @return AdsItem
   */
  public function getItem($source, $id)
  {
    if (false === filter_var($id, FILTER_VALIDATE_INT)){
      throw new \InvalidArgumentException();
    }

    switch ($source){
      case static::SOURCE_DAEMON:
        return $this->getItemFromDaemon($id);
      case static::SOURCE_DATABASE:
        return $this->getItemFromDatabase($id);
    }
    throw new \InvalidArgumentException();
  }

  protected function getItemFromDaemon($id)
  {
    $row = $this->legacyLoggedCall('\get_deamon_ad_info', $id);
    if (!$row){
      throw new ObjectNotFoundException();
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

  protected function getItemFromDatabase($id)
  {
    $row = $this->legacyLoggedCall('\getAdRecord', $id);
    if (!$row){
      throw new ObjectNotFoundException();
    }

    $item = new AdsItem();

    foreach ($row as $key => $val){
      $item->$key = $val;
    }
    $item->id = (int)$item->id;
    $item->price = floatval($item->price);

    return $item;
  }

  /**
   * Вызвать легаси-функцию getAdRecord / get_deamon_ad_info и залогировать вызов
   * @param string $func Имя функции
   * @param int $id ID объявления
   * @return mixed
   */
  protected function legacyLoggedCall($func, $id)
  {
    $row = $func($id);

    //We do not check that $row is returned - log all calls
    $message = str_replace('\\', '', $func).'(ID='.$id.')';
    $this->getLogger()->log($message);

    return $row;
  }

  protected function getLogger()
  {
    return Application::getInstance()->getLogger();
  }

}