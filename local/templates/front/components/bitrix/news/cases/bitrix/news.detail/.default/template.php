<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<section class="top-block">
    <div class="top-block__wrapper">
        <div class="container top-block__wrapper_padding">
            <div class="top-block__black"></div>
            <div class="top-block__content">
                <img class="top-block__img" src="<?= $arResult['ACTIVE_IMG'] ?>" alt="">
                <div class="top-block__body">
                    <p class="top-block__name"><span class="top-block__name-span"><?= $arResult['ELEMENT_SECTION'] ?></span> <?= $arResult['NAME'] ?></p>
                    <h1 class="top-block__title">
                        <?= $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] ?>
                    </h1>
                    <button class="hero__btn top-block__btn btn btn--light">НАПИСАТЬ В Мессенджер</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $arResult['DETAIL_TEXT'] ?>
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

<div class="next-case">
    <div class="container">
        <div class="next-case-wrap">
            <?php
            if ($arResult['NEAR_ELEMENTS']['LEFT']): ?>
                <a class="next-case__left" href="<?= $arResult['NEAR_ELEMENTS']['LEFT'][0]['DETAIL_PAGE_URL'] ?>">
                    <div class="next-case__left-title explanatory-title">Предыдущий кейс</div>
                    <p class="next-case__left-text"><?= $arResult['NEAR_ELEMENTS']['LEFT'][0]['PREVIEW_TEXT'] ?></p>
                    <img class="next-case__left-arrow" src="/local/templates/front/frontend/dist/assets/img/icons/arrow.svg" alt="">
                    <img class="next-case__left-right-mobile" src="/local/templates/front/frontend/dist/assets/img/icons/arrow-white.svg" alt="">
                </a>
            <?php
            endif;
            if ($arResult['NEAR_ELEMENTS']['RIGHT']): ?>
                <a class="next-case__left" href="<?= $arResult['NEAR_ELEMENTS']['RIGHT'][0]['DETAIL_PAGE_URL'] ?>">
                    <div class="next-case__left-title explanatory-title">Следующий кейс</div>
                    <p class="next-case__left-text"><?= $arResult['NEAR_ELEMENTS']['RIGHT'][0]['PREVIEW_TEXT'] ?></p>
                    <img class="next-case__left-arrow-mobile" src="/local/templates/front/frontend/dist/assets/img/icons/arrow.svg" alt="">
                    <img class="next-case__left-right" src="/local/templates/front/frontend/dist/assets/img/icons/arrow-white.svg" alt="">
                </a>
            <?php
            endif; ?>
        </div>
    </div>
</div>
