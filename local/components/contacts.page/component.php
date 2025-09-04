<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    ShowError('Модуль "Информационные блоки" не установлен');
    return;
}

// Параметры по умолчанию
$iblockId = intval($arParams["IBLOCK_ID"] ?? CONTACTS_PAGE);
$elementCode = trim($arParams["ELEMENT_CODE"] ?? "contacts_page_content");

// Получаем элемент
$res = CIBlockElement::GetList(
    ["SORT" => "ASC"],
    [
        "IBLOCK_ID" => $iblockId,
        "CODE" => $elementCode,
        "ACTIVE" => "Y"
    ],
    false,
    false,
    ["ID", "NAME"]
);

if ($element = $res->GetNext()) {
    $elementId = $element["ID"];

    // Получаем все свойства
    $properties = CIBlockElement::GetProperty($iblockId, $elementId);
    $props = [];
    while ($prop = $properties->GetNext()) {
        if (!empty($prop["VALUE"])) {
            $props[$prop["CODE"]] = $prop["VALUE"];
        }
    }

    // Формируем arResult
    $arResult = [
        "CONTACTS_WELCOME" => [
            "TITLE" => $props["CONTACTS_WELCOME_TITLE"] ?? ""
        ],
        "SEO" => [
            "SECTION_TITLE" => $props["SEO_SECTION_TITLE"] ?? "",
            "PHONE" => $props["SEO_PHONE"] ?? "",
            "PHONE_LINK" => $props["SEO_PHONE_LINK"] ?? "",
            "TELEGRAM" => $props["SEO_TELEGRAM"] ?? "",
            "TELEGRAM_LINK" => $props["SEO_TELEGRAM_LINK"] ?? ""
        ],
        "DIRECT" => [
            "SECTION_TITLE" => $props["DIRECT_SECTION_TITLE"] ?? "",
            "PHONE" => $props["DIRECT_PHONE"] ?? "",
            "PHONE_LINK" => $props["DIRECT_PHONE_LINK"] ?? "",
            "TELEGRAM" => $props["DIRECT_TELEGRAM"] ?? "",
            "TELEGRAM_LINK" => $props["DIRECT_TELEGRAM_LINK"] ?? ""
        ],
        "FORM" => [
            "SECTION_TITLE" => $props["FORM_SECTION_TITLE"] ?? "",
            "PROCESS_DESCRIPTION" => $props["FORM_PROCESS_DESCRIPTION"] ?? "",
            "STEPS" => [
                1 => $props["FORM_STEP_1"] ?? "",
                2 => $props["FORM_STEP_2"] ?? "",
                3 => $props["FORM_STEP_3"] ?? "",
                4 => $props["FORM_STEP_4"] ?? "",
                5 => $props["FORM_STEP_5"] ?? "",
                6 => $props["FORM_STEP_6"] ?? ""
            ],
            "TITLE" => $props["FORM_TITLE"] ?? ""
        ]
    ];
} else {
    ShowError("Элемент страницы контактов не найден");
    return;
}

$this->IncludeComponentTemplate();