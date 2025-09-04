<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "FORM_TYPE" => Array(
            "NAME" => "Тип формы",
            "TYPE" => "LIST",
            "VALUES" => array(
                "default" => "Обычная форма",
                "contacts" => "Расширенная форма контактов"
            ),
            "DEFAULT" => "default",
            "PARENT" => "BASE",
        ),
        "FORM_TITLE" => Array(
            "NAME" => "Заголовок формы",
            "TYPE" => "STRING",
            "DEFAULT" => "Заполните форму обратной связи",
            "PARENT" => "BASE",
        ),
        "LINK_POLICY" => Array(
            "NAME" => "Ссылка на политику конфиденциальности",
            "TYPE" => "STRING",
            "DEFAULT" => "#",
            "PARENT" => "BASE",
        ),
        "LINK_PERSONAL_DATA" => Array(
            "NAME" => "Ссылка на обработку персональных данных",
            "TYPE" => "STRING",
            "DEFAULT" => "#",
            "PARENT" => "BASE",
        ),
        "CHAT_ID" => Array(
            "NAME" => "ID чата Telegram",
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "PARENT" => "BASE",
        ),
        "OK_TEXT" => Array(
            "NAME" => "Текст успешной отправки",
            "TYPE" => "STRING",
            "DEFAULT" => "Наш специалист свяжется с вами в ближайшее время",
            "PARENT" => "BASE",
        ),
    )
);
?>