<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  1 =>
  array (
    'CONDITION' => '#^/cases/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/cases/index.php',
    'SORT' => 100,
  ),
  2 =>
  array (
	'CONDITION' => '#^/info/#',
	'RULE' => '',
	'ID' => 'bitrix:news',
	'PATH' => '/info/index.php',
	'SORT' => 100,
  ),
  3 =>
  array (
	'CONDITION' => '#^/(.*)/#',
	'RULE' => "ELEMENT_CODE=$1",
	'ID' => 'bitrix:news',
	'PATH' => '/reklama-pages/index.php',
	'SORT' => 100,
  ),

);
