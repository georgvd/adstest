<?php

namespace AdsTest\Providers;

use AdsTest\Interfaces\ILogger;

class FileLogger implements ILogger
{
  protected $isEnabled = false;

  protected $fileName;

  public function __construct($fileName)
  {
    if (!$fileName){
      throw new \InvalidArgumentException();
    }

    $this->fileName = $fileName;
  }

  public function setEnabled($isEnabled)
  {
    $this->isEnabled = !!$isEnabled;
  }

  public function log($eventData)
  {
    if ($this->isEnabled){
      $dirname = dirname($this->fileName);
      if (!file_exists($dirname)){
        if (!mkdir($dirname, 0777, true)){
          throw new \RuntimeException();
        }
      }

      $record = '['.date('c').'] '.$eventData."\n";

      if (false === file_put_contents($this->fileName, $record, FILE_APPEND | LOCK_EX)){
        throw new \RuntimeException();
      }
    }
  }

}