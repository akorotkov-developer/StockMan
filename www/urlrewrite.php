<?php
$arUrlRewrite=array (
    0 => array(
        "CONDITION" => "#^/brands/([a-z0-9\\-]+)/?([a-z0-9\\-\\/\\=\\?\\&\\_]+)$#",
        "RULE" => "ROW_ID=$1",
        "ID" => "",
        "PATH" => "/brands/detail.php",
        'SORT' => 4,
    ),
   1 => array(
        "CONDITION" => "#^/brands/([a-z0-9\\-]+)/([a-z0-9\\-\\/\\=\\?\\&\\_]+)#",
        "RULE" => "ROW_ID=\$1",
        "ID" => "",
        "PATH" => "/brands/detail.php",
        'SORT' => 5,
    ),
  2 =>
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 10,
  ),
  3 =>
  array (
    'CONDITION' => '#^/faq/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/faq/index.php',
    'SORT' => 20,
  ),
  4 =>
  array (
    'CONDITION' => '#^/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/store/index.php',
    'SORT' => 30,
  ),
  5 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 40,
  ),
 6 =>
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/index.php',
    'SORT' => 50,
  ),
  7 =>
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
);
