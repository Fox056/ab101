<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<nav class="header__nav">
    <ul class="nav__list">

        <?php foreach ($arResult as $arItem): ?>
            <li class="nav__item">
                <a href="<?= $arItem["LINK"] ?>" class="nav__link"><?= $arItem["TEXT"] ?></a>
            </li>
        <?php endforeach ?>
    </ul>
</nav>