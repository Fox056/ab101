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
$iblockId = intval($arParams["IBLOCK_ID"] ?? MAIN_PAGE);
$elementCode = trim($arParams["ELEMENT_CODE"] ?? "main_page_content");

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
        "WELCOME" => [
            "TITLE" => $props["WELCOME_TITLE"] ?? "",
            "SUBTITLE" => $props["WELCOME_SUBTITLE"] ?? "",
            "TELEGRAM_URL" => $props["WELCOME_TELEGRAM_URL"] ?? "",
            "ADVANTAGES" => [
                1 => [
                    "TITLE" => $props["WELCOME_ADVANTAGE_1_TITLE"] ?? "",
                    "TEXT" => $props["WELCOME_ADVANTAGE_1_TEXT"] ?? ""
                ],
                2 => [
                    "TITLE" => $props["WELCOME_ADVANTAGE_2_TITLE"] ?? "",
                    "TEXT" => $props["WELCOME_ADVANTAGE_2_TEXT"] ?? ""
                ],
                3 => [
                    "TITLE" => $props["WELCOME_ADVANTAGE_3_TITLE"] ?? "",
                    "TEXT" => $props["WELCOME_ADVANTAGE_3_TEXT"] ?? ""
                ]
            ]
        ],
        "COMPLEX" => [
            "TITLE" => $props["COMPLEX_TITLE"] ?? "",
            "INTRO" => $props["COMPLEX_INTRO"] ?? "",
            "LIST_ITEMS" => [
                1 => $props["COMPLEX_LIST_ITEM_1"] ?? "",
                2 => $props["COMPLEX_LIST_ITEM_2"] ?? "",
                3 => $props["COMPLEX_LIST_ITEM_3"] ?? "",
                4 => $props["COMPLEX_LIST_ITEM_4"] ?? ""
            ],
            "SUBTITLE" => $props["COMPLEX_SUBTITLE"] ?? ""
        ],
        "ATTRACT" => [
            "TITLE" => $props["ATTRACT_TITLE"] ?? "",
            "SUBTITLE" => $props["ATTRACT_SUBTITLE"] ?? ""
        ],
        "CASES" => [
            "TITLE" => $props["CASES_TITLE"] ?? "",
            "DESCRIPTION" => $props["CASES_DESCRIPTION"] ?? ""
        ],
        "EXPERTISE" => [
            "TITLE" => $props["EXPERTISE_TITLE"] ?? "",
            "SEO" => [
                "NAME" => $props["EXPERTISE_SEO_NAME"] ?? "",
                "DESC" => $props["EXPERTISE_SEO_DESC"] ?? "",
                "LINK" => $props["EXPERTISE_SEO_LINK"] ?? "#"
            ],
            "PPC" => [
                "NAME" => $props["EXPERTISE_PPC_NAME"] ?? "",
                "DESC" => $props["EXPERTISE_PPC_DESC"] ?? "",
                "LINK" => $props["EXPERTISE_PPC_LINK"] ?? "#"
            ],
            "DEV" => [
                "NAME" => $props["EXPERTISE_DEV_NAME"] ?? "",
                "DESC" => $props["EXPERTISE_DEV_DESC"] ?? ""
            ],
            "STACK" => [
                "FRONTEND" => $props["EXPERTISE_STACK_FRONTEND"] ?? "",
                "BACKEND" => $props["EXPERTISE_STACK_BACKEND"] ?? "",
                "QA" => $props["EXPERTISE_STACK_QA"] ?? ""
            ]
        ],
        "METHODOLOGY" => [
            "TITLE" => $props["METHODOLOGY_TITLE"] ?? "",
            "SEO" => [
                "TITLE" => $props["METHODOLOGY_SEO_TITLE"] ?? "",
                "SUBTITLE" => $props["METHODOLOGY_SEO_SUBTITLE"] ?? "",
                "ACCORDIONS" => [
                    1 => [
                        "TITLE" => $props["METHODOLOGY_SEO_ACCORDION_1_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_SEO_ACCORDION_1_CONTENT"] ?? ""
                    ],
                    2 => [
                        "TITLE" => $props["METHODOLOGY_SEO_ACCORDION_2_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_SEO_ACCORDION_2_CONTENT"] ?? ""
                    ],
                    3 => [
                        "TITLE" => $props["METHODOLOGY_SEO_ACCORDION_3_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_SEO_ACCORDION_3_CONTENT"] ?? ""
                    ],
                    4 => [
                        "TITLE" => $props["METHODOLOGY_SEO_ACCORDION_4_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_SEO_ACCORDION_4_CONTENT"] ?? ""
                    ]
                ]
            ],
            "PPC" => [
                "TITLE" => $props["METHODOLOGY_PPC_TITLE"] ?? "",
                "SUBTITLE" => $props["METHODOLOGY_PPC_SUBTITLE"] ?? "",
                "ACCORDIONS" => [
                    1 => [
                        "TITLE" => $props["METHODOLOGY_PPC_ACCORDION_1_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_PPC_ACCORDION_1_CONTENT"] ?? ""
                    ],
                    2 => [
                        "TITLE" => $props["METHODOLOGY_PPC_ACCORDION_2_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_PPC_ACCORDION_2_CONTENT"] ?? ""
                    ],
                    3 => [
                        "TITLE" => $props["METHODOLOGY_PPC_ACCORDION_3_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_PPC_ACCORDION_3_CONTENT"] ?? ""
                    ],
                    4 => [
                        "TITLE" => $props["METHODOLOGY_PPC_ACCORDION_4_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_PPC_ACCORDION_4_CONTENT"] ?? ""
                    ]
                ]
            ],
            "COMBINED" => [
                "TITLE" => $props["METHODOLOGY_COMBINED_TITLE"] ?? "",
                "ACCORDIONS" => [
                    1 => [
                        "TITLE" => $props["METHODOLOGY_COMBINED_ACCORDION_1_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_COMBINED_ACCORDION_1_CONTENT"] ?? ""
                    ],
                    2 => [
                        "TITLE" => $props["METHODOLOGY_COMBINED_ACCORDION_2_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_COMBINED_ACCORDION_2_CONTENT"] ?? ""
                    ],
                    3 => [
                        "TITLE" => $props["METHODOLOGY_COMBINED_ACCORDION_3_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_COMBINED_ACCORDION_3_CONTENT"] ?? ""
                    ],
                    4 => [
                        "TITLE" => $props["METHODOLOGY_COMBINED_ACCORDION_4_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_COMBINED_ACCORDION_4_CONTENT"] ?? ""
                    ]
                ]
            ],
            "ADDITIONAL" => [
                "TITLE" => $props["METHODOLOGY_ADDITIONAL_TITLE"] ?? "",
                "ACCORDIONS" => [
                    1 => [
                        "TITLE" => $props["METHODOLOGY_ADDITIONAL_ACCORDION_1_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_ADDITIONAL_ACCORDION_1_CONTENT"] ?? ""
                    ],
                    2 => [
                        "TITLE" => $props["METHODOLOGY_ADDITIONAL_ACCORDION_2_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_ADDITIONAL_ACCORDION_2_CONTENT"] ?? ""
                    ],
                    3 => [
                        "TITLE" => $props["METHODOLOGY_ADDITIONAL_ACCORDION_3_TITLE"] ?? "",
                        "CONTENT" => $props["METHODOLOGY_ADDITIONAL_ACCORDION_3_CONTENT"] ?? ""
                    ]
                ]
            ]
        ],
        "STARTING" => [
            "TITLE" => $props["STARTING_TITLE"] ?? "",
            "DESCRIPTION" => $props["STARTING_DESCRIPTION"] ?? "",
            "FORM_TITLE" => $props["STARTING_FORM_TITLE"] ?? "",
            "STEPS" => [
                1 => [
                    "NUMBER" => $props["STARTING_STEP_1_NUMBER"] ?? "",
                    "TEXT" => $props["STARTING_STEP_1_TEXT"] ?? ""
                ],
                2 => [
                    "NUMBER" => $props["STARTING_STEP_2_NUMBER"] ?? "",
                    "TEXT" => $props["STARTING_STEP_2_TEXT"] ?? ""
                ],
                3 => [
                    "NUMBER" => $props["STARTING_STEP_3_NUMBER"] ?? "",
                    "TEXT" => $props["STARTING_STEP_3_TEXT"] ?? ""
                ],
                4 => [
                    "NUMBER" => $props["STARTING_STEP_4_NUMBER"] ?? "",
                    "TEXT" => $props["STARTING_STEP_4_TEXT"] ?? ""
                ],
                5 => [
                    "NUMBER" => $props["STARTING_STEP_5_NUMBER"] ?? "",
                    "TEXT" => $props["STARTING_STEP_5_TEXT"] ?? ""
                ],
                6 => [
                    "NUMBER" => $props["STARTING_STEP_6_NUMBER"] ?? "",
                    "TEXT" => $props["STARTING_STEP_6_TEXT"] ?? ""
                ]
            ]
        ],
        "FAQ" => [
            "TITLE" => $props["FAQ_TITLE"] ?? "",
            "MORE_BUTTON_TEXT" => $props["FAQ_MORE_BUTTON_TEXT"] ?? "",
            "ITEMS" => [
                1 => [
                    "TITLE" => $props["FAQ_QUESTION_1"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_1"] ?? ""
                ],
                2 => [
                    "TITLE" => $props["FAQ_QUESTION_2"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_2"] ?? ""
                ],
                3 => [
                    "TITLE" => $props["FAQ_QUESTION_3"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_3"] ?? ""
                ],
                4 => [
                    "TITLE" => $props["FAQ_QUESTION_4"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_4"] ?? ""
                ],
                5 => [
                    "TITLE" => $props["FAQ_QUESTION_5"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_5"] ?? ""
                ],
                6 => [
                    "TITLE" => $props["FAQ_QUESTION_6"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_6"] ?? ""
                ],
                7 => [
                    "TITLE" => $props["FAQ_QUESTION_7"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_7"] ?? ""
                ],
                8 => [
                    "TITLE" => $props["FAQ_QUESTION_8"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_8"] ?? ""
                ],
                9 => [
                    "TITLE" => $props["FAQ_QUESTION_9"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_9"] ?? ""
                ],
                10 => [
                    "TITLE" => $props["FAQ_QUESTION_10"] ?? "",
                    "CONTENT" => $props["FAQ_ANSWER_10"] ?? ""
                ]
            ]
        ],
        "SLOGAN" => [
            "TITLE" => $props["SLOGAN_TITLE"] ?? ""
        ]
    ];
} else {
    ShowError("Элемент главной страницы не найден");
    return;
}

$this->IncludeComponentTemplate();
?>