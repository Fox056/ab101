<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$formType = $arParams['FORM_TYPE'] ?? 'default';
$formTitle = $arParams['FORM_TITLE'] ?? 'Заполните форму обратной связи';
$linkPolicy = $arParams['LINK_POLICY'] ?? '#';
$linkPersonalData = $arParams['LINK_PERSONAL_DATA'] ?? '#';
$okText = $arParams['OK_TEXT'] ?? 'Наш специалист свяжется с вами в ближайшее время';
?>
<div class="form-block__body">
    <div class="form-block__box" data-request-form-base="active">
        <div class="form-block__form-title"><?= htmlspecialchars($formTitle) ?></div>
        <form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="form-block__form" data-request-form>
            <?=bitrix_sessid_post()?>

            <?php if ($formType === 'contacts'): ?>
                <!-- Расширенная форма для страницы контактов -->
                <input class="input" type="text" name="address" id="address"
                       autocomplete="address" placeholder="Адрес сайта для продвижения"
                       title="Адрес сайта для продвижения" required>
                <input class="input" type="text" name="description" id="description"
                       autocomplete="description"
                       placeholder="Опишите задачи, боли проекта, KPI... "
                       title="Опишите задачи, боли проекта, KPI... " required>
                <input class="input" type="text" name="expectation" id="expectation"
                       autocomplete="expectation"
                       placeholder="Какие ваши ожидания от работы в первый год?"
                       title="Какие ваши ожидания от работы в первый год?" required>
                <input class="input" type="text" name="connect" id="connect"
                       autocomplete="off"
                       placeholder="Укажите удобный для вас способ связи и контакт для связи (e-mail, мессенджеры), для обмена информацией"
                       title="Укажите удобный для вас способ связи и контакт для связи (e-mail, мессенджеры), для обмена информацией" required>
                <input class="input" type="text" name="name" id="name"
                       autocomplete="name" placeholder="Как к вам обращаться"
                       title="Как к вам обращаться" required>
            <?php else: ?>
                <!-- Обычная форма (совместимость) -->
                <input class="input" type="text" name="name" id="name"
                       autocomplete="name" placeholder="Ваше имя" required>
                <input class="input" type="text" name="link" id="link"
                       placeholder="Ссылка на сайт" required>
                <input class="input" type="text" name="connect" id="connect"
                       autocomplete="off"
                       placeholder="Ваш Telegram-ник, номер WhatsApp, Email или телефон для связи" required>
            <?php endif; ?>

            <label class="checkbox">
                <input class="checkbox__input" name="agreement" id="agreement" type="checkbox" required>
                <span class="checkbox__fake-input"></span>
                <span class="checkbox__title">Я согласен на
                    <a href="<?= htmlspecialchars($linkPersonalData) ?>">обработку персональных данных</a>
                    в соответствии с
                    <a href="<?= htmlspecialchars($linkPolicy) ?>">политикой конфиденциальности</a>
                </span>
            </label>
            <label class="checkbox">
                <input class="checkbox__input" name="personal" id="personal" type="checkbox" required>
                <span class="checkbox__fake-input"></span>
                <span class="checkbox__title">Да, я добровольно даю своё согласие на
                    <a href="<?= htmlspecialchars($linkPersonalData) ?>">обработку персональных данных</a>
                </span>
            </label>
            <button type="submit" class="button button--primary form-block__button"
                    data-request-form-submit disabled>
                Отправить
            </button>
        </form>
    </div>
    <div class="form-block__box" data-request-form-success>
        <div class="form-block__form-title">Благодарим вас за заполнение формы</div>
        <div class="form-block__side">
            <div class="form-block__message"><?= htmlspecialchars($okText) ?></div>
            <button class="button button--primary form-block__button" data-request-form-reset>
                Отправить повторный запрос
            </button>
        </div>
    </div>
</div>