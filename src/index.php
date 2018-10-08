<?php

require_once '../vendor/autoload.php';

$config = new \AdsTest\Config();
$config->getLogger()->setEnabled(true);

$id = $_GET['id'] ?? null;
if ($id === null || false === filter_var($id, FILTER_VALIDATE_INT)){
  die('Please specify correct parameter "id"');
}

$from = $_GET['from'] ?? null;
switch ($from){
  case 'Daemon':
    $provider = new \AdsTest\Providers\AdsProviderDaemon();
    break;
  case 'Mysql':
    $provider = new \AdsTest\Providers\AdsProviderMysql();
    break;
  default:
    die('Please specify correct parameter "from"');
}

$catalog = new \AdsTest\AdsCatalog($provider, $config->getLogger());

try {
  $item = $catalog->getItemWithLogging($id);
} catch (\AdsTest\Exceptions\ObjectNotFoundException $ex){
  die('Item not found!');
}

$currencies = $config->getDictCurrency();

echo '<h1>'.htmlspecialchars($item->name).'</h1>';
echo '<p>'.nl2br(htmlspecialchars($item->text)).'</p>';
echo '<p>стоимость: '.$item->getPrice($currencies, $currencies::CURRENCY_RUB).' руб.</p>';
