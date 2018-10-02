<?php

namespace AdsTest;

use AdsTest\Interfaces\IDictionary;
use AdsTest\Interfaces\ILogger;
use AdsTest\Providers\AdsProvider;
use AdsTest\Providers\DictCurrency;
use AdsTest\Providers\FileLogger;

class Application
{

  protected static $instance;

  /** @var array */
  protected $config;

  /** @var ILogger */
  protected $logger;

  /** @var IDictionary */
  protected $dictCurrency;

  /** @var AdsProvider */
  protected $adsCatalog;

  /**
   * @return Application
   */
  public static function getInstance(){
    if (!static::$instance){
      static::$instance = new static();
    }
    return static::$instance;
  }

  protected function __construct()
  {
    $this->loadConfig();

    $this->logger = new FileLogger($this->config['fileLogger_file']);
    $this->logger->setEnabled(!!$this->config['fileLogger_enabled']);

    $this->dictCurrency = new DictCurrency();

    $this->adsCatalog = new AdsProvider();
  }

  protected function loadConfig()
  {
    $configPath = dirname(__FILE__).'/config.php';
    $this->config = include($configPath);
  }

  public function getConfig(){
    return $this->config;
  }

  public function getLogger()
  {
    return $this->logger;
  }

  public function getDictCurrency()
  {
    return $this->dictCurrency;
  }

  public function getAdsCatalog()
  {
    return $this->adsCatalog;
  }

}