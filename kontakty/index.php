<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetPageProperty("description", "Контакты для продвижения сайтов. Связаться по SEO и Яндекс.Директ услугам. Оставьте заявку для консультации и разработки стратегии продвижения.");
$APPLICATION->SetPageProperty("keywords", "контакты seo, связаться seo специалист, яндекс директ контакты");
$APPLICATION->SetPageProperty("title", "Контакты - SEO продвижение и Яндекс.Директ");
$APPLICATION->SetTitle("Контакты");
?>

<?php
$APPLICATION->IncludeComponent(
        "contacts.page",
        "",
        array(
                "IBLOCK_ID" => CONTACTS_PAGE,
                "ELEMENT_CODE" => "contacts_page_content",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
        ),
        false
);
?>

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php'); ?>