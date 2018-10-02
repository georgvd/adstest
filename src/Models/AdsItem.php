<?php

namespace AdsTest\Models;

use AdsTest\Application;

/**
 * Модель данных объявления
 */
class AdsItem
{
  /** @var int ID объявления */
  public $id;

  /** @var string */
  public $name;

  /** @var string */
  public $text;

  /** @var string Ключевые слова */
  public $keywords;

  /** @var float Цена в USD */
  public $price;

  /** @var int ID кампании */
  public $idCampaign;

  /** @var int ID пользователя */
  public $idUser;

  /**
   * Возвращает поле $this->price в валюте $idCurrency
   * @param int $idCurrency ID валюты
   * @return float
   */
  public function getPrice($idCurrency)
  {
    $app = Application::getInstance();
    $currencies = $app->getDictCurrency();

    $priceConverted = $currencies->getRecordById($currencies::CURRENCY_USD)->cource * $this->price;
    if ($idCurrency != $currencies::CURRENCY_RUB){
      $priceConverted /= $currencies->getRecordById($idCurrency)->cource;
    }

    return $priceConverted;
  }
}