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

<section class="section-new">
    <div class="container-new">
        <div class="section-new__header">
            <h2 class="section-new__title">
				<?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/includes/reklama/cases-title.php"), false);?>
            </h2>
            <p class="section-new__descr">
				<?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/includes/reklama/cases-text.php"), false);?>
            </p>
        </div>
        <div class="section-new__body">
            <div class="case-slider">
                <div class="swiper" data-case-slider>
                    <div class="swiper-wrapper">
                        <?php foreach($arResult['ITEMS'] as $key => $arItem):?>
                        <div class="swiper-slide">
                            <div class="case-tile">
                                <div class="case-tile__main">
                                    <div class="case-tile__title">
                                        <span class="case-tile__badge">№<?php echo $key+1?></span>
                                        <?php echo $arItem['NAME']?>
                                    </div>
                                    <a class="case-tile__link" href="<?php echo $arItem['DETAIL_PAGE_URL']?>">Посмотреть результат</a>
                                    <div class="case-tile__target">
                                        <div class="case-tile__subtitle"><?php echo $arItem['PROPERTIES']['TARGET']['NAME']?></div>
                                        <div class="case-tile__descr"><?php echo $arItem['PROPERTIES']['TARGET']['VALUE']?></div>
                                    </div>
                                </div>
                                <div class="case-tile__cols">
									<?php echo htmlspecialcharsBack($arItem['PROPERTIES']['COLUMNS_GRAPH']['VALUE'])?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="swiper-button-prev" data-faq-prev>
                    <img src="/local/templates/front/frontend/dist/assets/img/prev.svg" alt="prev">
                </div>
                <div class="swiper-button-next" data-faq-next>
                    <img src="/local/templates/front/frontend/dist/assets/img/next.svg" alt="next">
                </div>
            </div>
        </div>
    </div>
</section>
