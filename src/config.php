<?php

return (function(){
  return [
    'fileLogger_enabled' => true,
    'fileLogger_file' => dirname(dirname(__FILE__)).'/logs/fileLogger.log',

    //TODO other config options
  ];
})();
