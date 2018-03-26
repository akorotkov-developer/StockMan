<?php
$arUrlRewrite=array (
  1 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 10,
  ),
4 =>
    array (
        'CONDITION' => '#^/faq/#',
        'RULE' => '',
        'ID' => 'bitrix:news',
        'PATH' => '/faq/index.php',
        'SORT' => 20,
    ),
    3 =>
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
  2 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/index.php',
    'SORT' => 50,
  ),
  0 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
);
