<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

// Функция для безопасного вывода HTML контента
function safeHtmlOutputTitle($content)
{
    if (empty($content)) {
        return '';
    }

    // Декодируем HTML сущности
    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
    // Преобразуем <br/> в <br> и оставляем как есть
    $content = str_replace('<br/>', '<br>', $content);
    return strip_tags($content, '<br>');
}
?>

<main class="contacts-page">
    <?php if (!empty($arResult["CONTACTS_WELCOME"]["TITLE"])): ?>
        <section id="contacts-welcome" class="contacts-welcome">
            <div class="contacts-welcome__container container-new">
                <h1 class="contacts-welcome__title">
                    <?= safeHtmlOutputTitle($arResult["CONTACTS_WELCOME"]["TITLE"]) ?>
                </h1>
            </div>
        </section>
    <?php endif; ?>

    <div class="stack">
        <?php if (!empty($arResult["SEO"]["SECTION_TITLE"])): ?>
            <section class="contacts section-new">
                <div class="contacts__container container-new">
                    <div class="section-new__header">
                        <h2 class="section-new__title">
                            <?= safeHtmlOutputTitle($arResult["SEO"]["SECTION_TITLE"]) ?>
                        </h2>
                    </div>

                    <div class="section-new__body">
                        <div class="contacts__table">
                            <?php if (!empty($arResult["SEO"]["PHONE"])): ?>
                                <div class="contacts__table-row">
                                    <div class="contacts__table-col">
                                        <p class="contacts__table-label">Номер телефона</p>
                                    </div>
                                    <div class="contacts__table-col">
                                        <a class="contacts__table-value"
                                           href="<?= htmlspecialchars($arResult["SEO"]["PHONE_LINK"]) ?>"
                                           target="_blank">
                                            <?= htmlspecialchars($arResult["SEO"]["PHONE"]) ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($arResult["SEO"]["TELEGRAM"])): ?>
                                <div class="contacts__table-row">
                                    <div class="contacts__table-col">
                                        <p class="contacts__table-label">Telegram</p>
                                    </div>
                                    <div class="contacts__table-col">
                                        <a class="contacts__table-value"
                                           href="<?= htmlspecialchars($arResult["SEO"]["TELEGRAM_LINK"]) ?>"
                                           target="_blank">
                                            <?= htmlspecialchars($arResult["SEO"]["TELEGRAM"]) ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($arResult["DIRECT"]["SECTION_TITLE"])): ?>
            <section class="contacts section-new">
                <div class="contacts__container container-new">
                    <div class="section-new__header">
                        <h2 class="section-new__title">
                            <?= safeHtmlOutputTitle($arResult["DIRECT"]["SECTION_TITLE"]) ?>
                        </h2>
                    </div>

                    <div class="section-new__body">
                        <div class="contacts__table">
                            <?php if (!empty($arResult["DIRECT"]["PHONE"])): ?>
                                <div class="contacts__table-row">
                                    <div class="contacts__table-col">
                                        <p class="contacts__table-label">Номер телефона</p>
                                    </div>
                                    <div class="contacts__table-col">
                                        <a class="contacts__table-value"
                                           href="<?= htmlspecialchars($arResult["DIRECT"]["PHONE_LINK"]) ?>"
                                           target="_blank">
                                            <?= htmlspecialchars($arResult["DIRECT"]["PHONE"]) ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($arResult["DIRECT"]["TELEGRAM"])): ?>
                                <div class="contacts__table-row">
                                    <div class="contacts__table-col">
                                        <p class="contacts__table-label">Telegram</p>
                                    </div>
                                    <div class="contacts__table-col">
                                        <a class="contacts__table-value"
                                           href="<?= htmlspecialchars($arResult["DIRECT"]["TELEGRAM_LINK"]) ?>"
                                           target="_blank">
                                            <?= htmlspecialchars($arResult["DIRECT"]["TELEGRAM"]) ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($arResult["FORM"]["SECTION_TITLE"])): ?>
            <section id="starting-new" class="section-new starting-new">
                <div class="starting-new__container container-new">
                    <div class="section-new__header">
                        <h2 class="section-new__title">
                            <?= safeHtmlOutputTitle($arResult["FORM"]["SECTION_TITLE"]) ?>
                        </h2>
                    </div>

                    <div class="section-new__body">
                        <div class="starting-new__list">
                            <?php if (!empty($arResult["FORM"]["PROCESS_DESCRIPTION"])): ?>
                                <div class="starting-new__list-head">
                                    <div class="starting-new__list-col">
                                        <h2 class="starting-new__desc">
                                            <?= htmlspecialchars($arResult["FORM"]["PROCESS_DESCRIPTION"]) ?>
                                        </h2>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (array_filter($arResult["FORM"]["STEPS"] ?? [])): ?>
                                <div class="starting-new__list-main">
                                    <div class="starting-steps">
                                        <?php for ($i = 1; $i <= 6; $i++): ?>
                                            <?php if (!empty($arResult["FORM"]["STEPS"][$i])): ?>
                                                <div class="starting-steps__row">
                                                    <div class="starting-steps__col"></div>
                                                    <div class="starting-steps__col">
                                                        <span class="starting-steps__number"><?= $i ?> шаг</span>
                                                        <p class="starting-steps__text">
                                                            <?= htmlspecialchars($arResult["FORM"]["STEPS"][$i]) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($arResult["FORM"]["TITLE"])): ?>
                            <div class="starting-new__form">
                                <div class="form-block">
                                    <?php
                                    $APPLICATION->IncludeComponent(
                                            "ab404.feedback.telegram",
                                            "",
                                            array(
                                                    "FORM_TYPE" => "contacts",
                                                    "FORM_TITLE" => $arResult["FORM"]["TITLE"],
                                                    "LINK_POLICY" => "/info/politika-konfidentsialnosti/",
                                                    "LINK_PERSONAL_DATA" => "/info/politika-v-otnoshenii-obrabotki-i-zashchity-personalnykh-dannykh-ip-baklenev-andrey-alekseevich/",
                                                    "CHAT_ID" => "-4948437006",
                                                    "OK_TEXT" => "Наш специалист свяжется с вами в ближайшее время"
                                            ),
                                            false
                                    );
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>