<?php

namespace AdsTest\Models;

use AdsTest\Providers\DictCurrency;

/**
 * Модель данных объявления
 */
class AdsItem
{
  const PRICE_CURRENCY = DictCurrency::CURRENCY_USD;

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
   * Возвращает поле $this->price в валюте $idCurrencyTo
   * @param DictCurrency $dictCurrency
   * @param int|null $idCurrencyTo ID валюты. По умолчанию USD
   * @return float
   */
  public function getPrice(DictCurrency $dictCurrency, $idCurrencyTo = null)
  {
    $price = $this->price;

    if ($idCurrencyTo !== null){
      $price = $dictCurrency->convertPrice($price, $this::PRICE_CURRENCY, $idCurrencyTo);
    }

    return $price;
  }
}