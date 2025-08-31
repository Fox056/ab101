<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<div class="menu__wrapper">
    <ul class="menu__list">
        <?php foreach ($arResult as $arItem): ?>
            <li class="menu__item"><a href="<?= $arItem["LINK"] ?>" class="menu__link"><?= $arItem["TEXT"] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
