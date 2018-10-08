<?php

namespace AdsTest\Providers;

class AdsProviderDaemonTestWrapper extends AdsProviderDaemon
{

  protected function legacyCall($id)
  {
    switch ($id){
      case 101:
        return "101\t235678\t12348\tAdName_FromDaemon-101\tAdText_FromDaemon-101\t1101";
      case 102:
        return "102\t235678\t12348\tAdName_FromDaemon-102\tAdText_FromDaemon-102\t1102";
    }
    return false;
  }

}