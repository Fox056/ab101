<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="cases__body">
	<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="case">
		<div class="case__wrapper">
			<div class="case__body">
				<p class="case__top"><?=$arItem['DISPLAY_PROPERTIES']['PERIOD']['VALUE']?></p>
				<div class="case__description">
					<h2 class="case__title"><?=$arItem['NAME']?></h2>
					<p class="case__text"><?=$arItem['PREVIEW_TEXT']?></p>
					<div class="case__statistic statistic">
						<div class="statistic__item">
							<span class="statistic__percent">+<?=$arItem['DISPLAY_PROPERTIES']['TRAFFIC']['VALUE']?>%</span>
							<span class="statistic__text">увеличил<br>трафик</span>
						</div>
						<div class="statistic__item">
							<span class="statistic__percent">+<?=$arItem['DISPLAY_PROPERTIES']['CONVERSION']['VALUE']?>%</span>
							<span class="statistic__text">увеличил<br>конверсию</span>
						</div>
					</div>
				</div>
				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="case__link link">
					<span class="link__text">подробнее</span>
				</a>
			</div>
			<div class="case__image">
				<div
					class="hover-block"
					data-image1="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"
					data-image2="<?=$arItem['DETAIL_PICTURE']['SRC']?>"
				></div>
				<div class="case__slider slider swiper">
					<div class="slider__wrapper swiper-wrapper">
						<div class="slider__slide swiper-slide">
                            <a href="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" class="slider__image-link" data-fancybox="gallery">
                                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
                            </a>
						</div>
						<div class="slider__slide swiper-slide">
                            <a href="<?=$arItem['DETAIL_PICTURE']['SRC']?>" class="slider__image-link" data-fancybox="gallery">
                                <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="">
                            </a>
						</div>
					</div>
					<div class="slider__pagination"></div>
				</div>
			</div>
		</div>
	</div>

<?endforeach;?>

</div>
