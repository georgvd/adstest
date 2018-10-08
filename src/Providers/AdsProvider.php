<?php

namespace AdsTest\Providers;

use AdsTest\Interfaces\IAdsProvider;

abstract class AdsProvider implements IAdsProvider
{

  protected function legacyCall($id)
  {
    $func = $this->getLegacyFuncName();
    return $func($id);
  }

}