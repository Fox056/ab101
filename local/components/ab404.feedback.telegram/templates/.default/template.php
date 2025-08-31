<?
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
?>
<div class="form-block__body">
    <div class="form-block__box" data-request-form-base="active">
        <div class="form-block__form-title"><?php echo $arParams['FORM_TITLE'] ?></div>
        <form action="<?=POST_FORM_ACTION_URI?>" method="POST" class="form-block__form" data-request-form>
			<?=bitrix_sessid_post()?>
            <input class="input" type="text" name="name" id="name" autocomplete="name" placeholder="Ваше имя" required>
            <input class="input" type="text" name="link" id="link" placeholder="Ссылка на сайт" required>
            <input class="input" type="text" name="connect" id="connect" autocomplete="off"
                   placeholder="Ваш Telegram-ник, номер WhatsApp, Email или телефон для связи" required>
            <label class="checkbox">
                <input class="checkbox__input" name="agreement" id="agreement" type="checkbox" required>
                <span class="checkbox__fake-input"></span>
                <span class="checkbox__title">Я согласен на обработку персональных данных в соответствии с 
                        <a href="<?php echo $arParams['LINK_POLICY'] ?>">политикой конфиденциальности</a>
                    </span>
            </label>
            <label class="checkbox">
                <input class="checkbox__input" name="personal" id="personal" type="checkbox" required>
                <span class="checkbox__fake-input"></span>
                <span class="checkbox__title">Да, я добровольно даю своё согласие на 
                    <a href="<?php echo $arParams['LINK_PERSONAL_DATA'] ?>">обработку персональных данных</a></span>
            </label>
            <button type="submit" class="button button--primary form-block__button" data-request-form-submit disabled>
                Отправить
            </button>
        </form>
    </div>
    <div class="form-block__box" data-request-form-success>
        <div class="form-block__form-title">Благодарим вас за заполнение формы</div>
        <div class="form-block__side">
            <div class="form-block__message">Наш специалист свяжется с вами в ближайшее время</div>
            <button class="button button--primary form-block__button" data-request-form-reset>Отправить повторный
                запрос
            </button>
        </div>
    </div>
</div>