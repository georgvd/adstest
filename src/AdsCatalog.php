<?php

namespace AdsTest;

use AdsTest\Exceptions\ObjectNotFoundException;
use AdsTest\Interfaces\IAdsProvider;
use AdsTest\Interfaces\ILogger;
use AdsTest\Models\AdsItem;

/**
 * Поставщик информации об объявлениях
 */
class AdsCatalog
{

  /**
   * @var IAdsProvider
   */
  protected $provider;

  /**
   * @var ILogger
   */
  protected $logger;

  public function __construct(IAdsProvider $provider, ILogger $logger)
  {
    $this->provider = $provider;
    $this->logger = $logger;
  }

  /**
   * Получить объект объявления из источника $source
   * @param int $id ID объявления
   * @return AdsItem
   * @throws ObjectNotFoundException
   */
  public function getItemWithLogging($id)
  {
    $item = $this->provider->getItem($id);

    //логируем факт обращения в любом случае, даже если объявление не найдено
    $this->log($id);

    if (!$item){
      throw new ObjectNotFoundException();
    }

    return $item;
  }

  protected function log($id)
  {
    $logMessage = str_replace('\\', '', $this->provider->getLegacyFuncName()).'(ID='.$id.')';
    $this->logger->log($logMessage);
  }

}