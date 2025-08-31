<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$casesIds = [];
$resCases = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], ["sort" => "asc"], array("CODE" => "CASES"));
while ($obCases = $resCases->GetNext()) {
	$casesIds[] = $obCases['VALUE'];
}

$FAQIds = [];
$resFAQ = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], ["sort" => "asc"], array("CODE" => "FAQ"));
while ($obFAQ = $resFAQ->GetNext()) {
	$FAQIds[] = $obFAQ['VALUE'];
}

?>
<div class="hero-new">
    <div class="container-new">
        <div class="hero-new__inner">
			<?php echo $arResult['DETAIL_TEXT']?>
        </div>
    </div>
</div>
<div class="stack">
    <section class="section-new">
        <div class="container-new">
			<?php echo htmlspecialcharsBack($arResult['PROPERTIES']['WHY_BEST_CHOICE']['VALUE'])?>
        </div>
    </section>
    <section class="section-new">
        <div class="container-new">
			<?php echo htmlspecialcharsBack($arResult['PROPERTIES']['HOW_I_WORK']['VALUE'])?>
        </div>
    </section>


<?php $GLOBALS['casesFilter'] = ['ID' => $casesIds];?>
<?php $APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"cases_new_design",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"FILTER_NAME" => "casesFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "iblocks_for_main",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "100",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "TARGET",
			1 => "COLUMNS_GRAPH",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ID",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>


<section class="section-new">
    <div class="container-new">
        <div class="section-new__header">
            <h2 class="section-new__title"><?php echo $arResult['PROPERTIES']['FORM_SECTION_TITLE']['VALUE']?></h2>
        </div>
        <div class="section-new__body">
            <div class="form-block">
                <div class="form-block__header">
                    <div class="form-block__title"><?php echo $arResult['PROPERTIES']['FORM_HEADER_TITLE']['VALUE']?></div>
                    <div class="form-block__descr"><?php echo $arResult['PROPERTIES']['FORM_HEADER_TEXT']['VALUE']?></div>
                </div>

				<?php $APPLICATION->IncludeComponent(
					"ab404.feedback.telegram", "",
					[
                       'FORM_TITLE' =>  $arResult['PROPERTIES']['FORM_TITLE']['VALUE'],
                       'LINK_POLICY' => $arResult['PROPERTIES']['LINK_POLICY']['VALUE'],
                       'LINK_PERSONAL_DATA' => $arResult['PROPERTIES']['LINK_PERSONAL_DATA']['VALUE'],
                       'CHAT_ID' => $arResult['PROPERTIES']['TELEGRAM_CHAT_ID']['VALUE'],
                    ],
					false
				);?>
                <div class="form-block__footer">
					<?php echo htmlspecialcharsBack($arResult['PROPERTIES']['FORM_FOOTER']['VALUE']);?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $GLOBALS['FAQFilter'] = ['ID' => $FAQIds];?>
<?php $APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"faq",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"FILTER_NAME" => "FAQFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "12",
		"IBLOCK_TYPE" => "reklama",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "100",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ID",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
        "FAQ_TITLE" => $arResult['PROPERTIES']['FAQ_TITLE']['VALUE'],
	),
	false
);?>

</div>
