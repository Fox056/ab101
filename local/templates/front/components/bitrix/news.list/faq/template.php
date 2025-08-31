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
            <h2 class="section-new__title"><?php
                if(!empty($arParams['FAQ_TITLE'])):
                    echo $arParams['FAQ_TITLE'];
                else:
                    echo $arResult['NAME'];
                endif;
                ?></h2>
        </div>
        <div class="section-new__body">
            <div class="faq-slider">
                <div class="swiper" data-faq-slider>
                    <div class="swiper-wrapper">
                        <?php foreach($arResult['ITEMS'] as $key => $arItem):?>
                        <div class="swiper-slide">
                            <div class="faq-tile">
                                <div class="faq-tile__badge">№<?php echo $key+1?></div>
                                <div class="faq-tile__title"><?php echo $arItem['NAME']?></div>
                                <div class="faq-tile__subtitle">Ответ:</div>
                                <?php echo $arItem['PREVIEW_TEXT']?>
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
