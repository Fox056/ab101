<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Посмотрите на историю развития интернет-проектов. Высокие показатели роста и продаж за счёт инструментов SEO.");
$APPLICATION->SetPageProperty("keywords", "кейсы seo");
$APPLICATION->SetPageProperty("title", "Кейсы и истории успеха проектов в SEO");
$APPLICATION->SetTitle("Кейсы и истории успеха");
?>
<main class="case-page">
<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "cases",
    array(
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BANNER_LIST_SECTION_ID" => "",
        "BROWSER_TITLE" => "NAME",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COMPONENT_TEMPLATE" => "cases",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_FIELD_CODE" => array(
            0 => "DETAIL_PICTURE",
            1 => "",
        ),
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PROPERTY_CODE" => array(
            0 => "ACTIVE_IMG",
            1 => "",
        ),
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "2",
        "IBLOCK_TYPE" => "iblocks_for_main",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array(
            0 => "PREVIEW_PICTURE",
            1 => "DETAIL_PICTURE",
            2 => "",
        ),
        "LIST_PROPERTY_CODE" => array(
            0 => "PERIOD",
            1 => "CONVERSION",
            2 => "TRAFFIC",
            3 => "PREVIEW_PICTURE",
            4 => "DETAIL_PICTURE",
            5 => "",
        ),
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "NEWS_COUNT" => "20",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Кейсы",
        "PREVIEW_TRUNCATE_LEN" => "",
        "SECTION_ID" => "",
        "SET_LAST_MODIFIED" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "N",
        "SHOW_404" => "Y",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "USE_CATEGORIES" => "N",
        "USE_FILTER" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_RATING" => "N",
        "USE_REVIEW" => "N",
        "USE_RSS" => "N",
        "USE_SEARCH" => "Y",
        "USE_SHARE" => "N",
        "ENABLE_BANNER" => "N",
        "FILE_404" => "",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/cases/",
        "SEF_URL_TEMPLATES" => Array(
            "detail" => "#ELEMENT_CODE#/",
            "news" => "",
            "section" => "",
        ),
    ),
    false
);?>
</main>

</div>
<?php $page = explode('/',$APPLICATION->sDirPath);
if ($page[2] == ''): ?>
<section id="section-message" class="message">
    <div class="container">
        <div class="message__wrapper">
            <div class="message__left">
                <p class="message__left-text">Напишите, если остались вопросы</p>
            </div>
            <div class="message__right">
                <p class="message__right-text">
                    Если у вас остались вопросы по SEO, или у вашего проекта есть задача, которая не подходит под вышесказанное, напишите мне в мессенджер.
                </p>
                <div class="message__links">
                    <a href="https://t.me/AndreyBaklenev" class="message__link">Telegram</a>
                    <a href="https://skype:seo-baklenev?call" class="message__link">Skype</a>
                    <a href="https://api.whatsapp.com/send?phone=79055097875" target="_blank" class="message__link">WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<div class="modal">
        <div class="modal__body">
            <div class="modal__content">
                <p class="modal__text">
                    Выберите удобный для вас чат, чтобы написать:
                </p>
                <div class="modal__links">
                    <a href="tg://resolve?domain=AndreyBaklenev" class="modal__link">Telegram</a>
                    <a href="https://api.whatsapp.com/send?phone=79055097875" target="_blank" class="modal__link">WhatsApp</a>
                    <a href="skype:nikname?seo-baklenev" class="modal__link">Skype</a>
                </div>
            </div>
        </div>
    </div>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
