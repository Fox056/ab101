<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetPageProperty("description", "Baklenev SEO оптимизация сайтов любой сложности и на любом этапе развития. Продвигаю в Яндекс и Google. Построю стратегию развития на год. Успешные кейсы! Мгновенная обратная связь по любым вопросам. Звоните!");
$APPLICATION->SetPageProperty("keywords", "раскрутка сайта, сео продвижение");
$APPLICATION->SetPageProperty("title", "Baklenev SEO: Premium продвижение сайтов по SEO");
$APPLICATION->SetTitle("Главная");
?>

<?php
$APPLICATION->IncludeComponent(
        "main.page",
        "",
        array(
                "IBLOCK_ID" => MAIN_PAGE,
                "ELEMENT_CODE" => "main_page_content",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
        ),
        false
);
?>


<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>