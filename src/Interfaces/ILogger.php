<?php

namespace AdsTest\Interfaces;

interface ILogger
{
  /**
   * @param string $eventData
   * @return void
   */
  public function log($eventData);

  /**
   * @param boolean $isEnabled
   * @return void
   */
  public function setEnabled($isEnabled);

  /**
   * @return boolean
   */
  public function isEnabled();
}

