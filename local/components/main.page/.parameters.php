<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    return;
}

// Получаем список инфоблоков типа "iblocks_for_main"
$arIBlocks = [];
$rsIBlock = CIBlock::GetList(
    ["SORT" => "ASC"],
    ["TYPE" => "iblocks_for_main", "ACTIVE" => "Y"]
);
while ($arr = $rsIBlock->Fetch()) {
    $arIBlocks[$arr["ID"]] = "[" . $arr["ID"] . "] " . $arr["NAME"];
}

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока",
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => MAIN_PAGE,
            "REFRESH" => "Y",
        ],
        "ELEMENT_CODE" => [
            "PARENT" => "BASE",
            "NAME" => "Символьный код элемента",
            "TYPE" => "STRING",
            "DEFAULT" => "main_page_content",
        ],
        "CACHE_TYPE" => [
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => "Тип кеширования",
            "TYPE" => "LIST",
            "DEFAULT" => "A",
            "VALUES" => [
                "A" => "Автокеширование",
                "Y" => "Кешировать",
                "N" => "Не кешировать"
            ],
        ],
        "CACHE_TIME" => [
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => "Время кеширования (сек.)",
            "TYPE" => "STRING",
            "DEFAULT" => "3600",
        ],
    ],
];