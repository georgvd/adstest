<?php

require_once '../vendor/autoload.php';

$app = \AdsTest\Application::getInstance();

$id = $_GET['id'] ?? null;
if ($id === null || false === filter_var($id, FILTER_VALIDATE_INT)){
  die('Please specify correct parameter "id"');
}

$from = $_GET['from'] ?? null;
if ($from === null || !$app->getAdsCatalog()->isValidSource($from)){
  die('Please specify correct parameter "from"');
}

try {
  $item = $app->getAdsCatalog()->getItem($from, $id);
} catch (\AdsTest\Exceptions\ObjectNotFoundException $ex){
  die('Item not found!');
}

echo '<h1>'.htmlspecialchars($item->name).'</h1>';
echo '<p>'.nl2br(htmlspecialchars($item->text)).'</p>';
echo '<p>стоимость: '.$item->getPrice($app->getDictCurrency()::CURRENCY_RUB).' руб.</p>';
