<?php

//Файл для легаси-функций

function getAdRecord($id)
{
  $id = (int)$id;
  if ($id < 1 || $id > 10){
    return false;
  }

  return [
    'id'       => $id,
    'name'     => 'AdName_FromMySQL-'.$id,
    'text'     => 'AdText_FromMySQL-'.$id,
    'keywords' => 'Some Keywords ('.$id.')',
    'price'    => 10 * $id, //$
  ];
}

function get_deamon_ad_info($id)
{
  $id = (int)$id;
  if ($id < 1 || $id > 10){
    return false;
  }

  return "{$id}\t235678\t12348\tAdName_FromDaemon-{$id}\tAdText_FromDaemon-{$id}\t".(11*$id);
}

