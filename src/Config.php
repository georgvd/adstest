<?php

namespace AdsTest;

use AdsTest\Interfaces\IDictionary;
use AdsTest\Interfaces\ILogger;
use AdsTest\Providers\DictCurrency;
use AdsTest\Providers\FileLogger;

class Config
{
  /** @var ILogger */
  protected $logger;

  /** @var IDictionary */
  protected $dictCurrency;

  public function __construct()
  {
    $path = dirname(dirname(__FILE__)) . '/logs/fileLogger.log';
    $this->logger = new FileLogger($path);
    $this->logger->setEnabled(true);

    $this->dictCurrency = new DictCurrency();
  }

  public function getLogger()
  {
    return $this->logger;
  }

  public function setLogger(ILogger $logger)
  {
    $this->logger = $logger;
  }

  public function getDictCurrency()
  {
    return $this->dictCurrency;
  }

  public function setDictCurrency(IDictionary $dictionary)
  {
    $this->dictCurrency = $dictionary;
  }
}
