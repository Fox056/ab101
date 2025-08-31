<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Реклама");
use Bitrix\Main\Context;
$request = Context::getCurrent()->getRequest();
?>

<main class="new-page">
	<?php $APPLICATION->IncludeComponent("bitrix:news.detail","reklama",Array(
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"USE_SHARE" => "N",
			"AJAX_MODE" => "N",
			"IBLOCK_TYPE" => "",
			"IBLOCK_ID" => "11",
			"ELEMENT_CODE" => $request->get('ELEMENT_CODE'),
			"FIELD_CODE" => Array("*"),
			"PROPERTY_CODE" => Array("*"),
			"DETAIL_URL" => "",
			"SET_TITLE" => "Y",
			"SET_CANONICAL_URL" => "Y",
			"SET_BROWSER_TITLE" => "N",
			"BROWSER_TITLE" => "-",
			"SET_META_KEYWORDS" => "Y",
			"META_KEYWORDS" => "-",
			"SET_META_DESCRIPTION" => "Y",
			"META_DESCRIPTION" => "-",
			"SET_STATUS_404" => "Y",
			"SET_LAST_MODIFIED" => "Y",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
			"ADD_SECTIONS_CHAIN" => "Y",
			"ADD_ELEMENT_CHAIN" => "N",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"USE_PERMISSIONS" => "N",
			"CACHE_TYPE" => "N",
			"CACHE_TIME" => "3600",
			"CACHE_GROUPS" => "Y",
			"DISPLAY_TOP_PAGER" => "Y",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Страница",
			"PAGER_TEMPLATE" => "",
			"PAGER_SHOW_ALL" => "Y",
			"PAGER_BASE_LINK_ENABLE" => "Y",
			"SHOW_404" => "Y",
			"MESSAGE_404" => "",
			"STRICT_SECTION_CHECK" => "Y",
			"PAGER_BASE_LINK" => "",
			"PAGER_PARAMS_NAME" => "arrPager",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N"
		)
	);?>

</main>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
