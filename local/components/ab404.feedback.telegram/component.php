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

$token = "8029976131:AAEfzLQ9TsvwDF9e4-h1u1o-4gbE95ToYhw";
$user_id = $arParams['CHAT_ID'];

$data = file_get_contents('php://input');
// Декодируем данные, если они закодированы в JSON
$data = json_decode($data, true);

if(!empty($data)){

    // Определяем тип формы и формируем соответствующее сообщение
    $formType = $arParams['FORM_TYPE'] ?? 'default';

    if ($formType === 'contacts') {
        // Расширенная форма контактов
        $arr = [
            'Имя:' => $data['name'] ?? "name_empty",
            'Адрес сайта:' => $data['address'] ?? "address_empty",
            'Описание задач:' => $data['description'] ?? "description_empty",
            'Ожидания от работы:' => $data['expectation'] ?? "expectation_empty",
            'Способ связи:' => $data['connect'] ?? "connect_empty",
            'Страница, откуда отправлена форма:' => $_SERVER['HTTP_REFERER'] ?? 'https://ab404.ru/'
        ];

        $txt = 'Заявка с формы контактов ab404.ru:%0A';
    } else {
        // Обычная форма (совместимость с существующим функционалом)
        $arr = [
            'Имя:' => $data['name'] ?? "name_empty",
            'Телеграмм:' => $data['connect'] ?? "telegram_connects_empty",
            'Ссылка на сайт' => $data['link'] ?? "link_empty",
            'Страница, откуда отправлена форма:' => $_SERVER['HTTP_REFERER'] ?? 'https://ab404.ru/'
        ];

        $txt = 'Заявка с сайта ab404.ru:%0A';
    }

    foreach($arr as $key => $value){
        $txt .= "<b>".$key."</b> ".$value."%0A";
    };

    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$user_id}&parse_mode=html&text={$txt}", "r");
}

$this->IncludeComponentTemplate();