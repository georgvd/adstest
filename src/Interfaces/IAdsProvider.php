<?php

namespace AdsTest\Interfaces;

interface IAdsProvider
{
  public function getLegacyFuncName();

  public function getItem($id);
}