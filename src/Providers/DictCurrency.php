<?php

namespace AdsTest\Providers;

use AdsTest\Exceptions\ObjectNotFoundException;
use AdsTest\Interfaces\IDictionary;

/**
 * Справочник курсов валют
 */
class DictCurrency implements IDictionary
{
  const CURRENCY_RUB = 643;
  const CURRENCY_USD = 840;

  protected $table;

  public function isLoaded()
  {
    return !!$this->table;
  }

  public function load()
  {
    //TODO здесь мы могли бы загружать справочник валют из БД
    //Это хардкод, только для тестовых целей:

    $tbl = [
      ['id' => static::CURRENCY_RUB, 'name' => 'RUB', 'cource' => 1.0],
      ['id' => static::CURRENCY_USD, 'name' => 'USD', 'cource' => 65.39],
      //TODO other currencies
    ];
    //Поле cource - курс валюты в рублях

    $this->table = [];
    foreach ($tbl as $row){
      $obj = json_decode(json_encode($row));
      $this->table[$obj->id] = $obj;
    }
  }

  public function isRecordExists($id)
  {
    if (false === filter_var($id, FILTER_VALIDATE_INT)){
      throw new \InvalidArgumentException();
    }

    if (!$this->isLoaded()){
      $this->load();
    }

    return isset($this->table[(int)$id]);
  }

  public function getRecordById($id)
  {
    if (false === filter_var($id, FILTER_VALIDATE_INT)){
      throw new \InvalidArgumentException();
    }

    if (!$this->isLoaded()){
      $this->load();
    }

    $id = (int)$id;

    $record = $this->table[$id] ?? null;

    if ($record === null){
      throw new ObjectNotFoundException();
    }

    return $record;
  }

  /**
   * @param float $price
   * @param int $idCurrencyFrom
   * @param int $idCurrencyTo
   * @return float
   */
  public function convertPrice($price, $idCurrencyFrom, $idCurrencyTo)
  {
    return $price * $this->getRecordById($idCurrencyFrom)->cource / $this->getRecordById($idCurrencyTo)->cource;
  }
}