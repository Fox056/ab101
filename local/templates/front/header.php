<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @global CMain $APPLICATION */ ?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="shortcut icon" type="image/png" href="/favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="/logoab404.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0e0e0e">
    <meta name="apple-mobile-web-app-title" content="SEO">
    <meta name="application-name" content="SEO">
    <meta name="msapplication-TileColor" content="#0e0e0e">
    <meta name="theme-color" content="#ffffff">
    <title><?php $APPLICATION->ShowTitle(); ?></title>
    <?php $APPLICATION->ShowHead(); ?>
    <?php $APPLICATION->ShowPanel(); ?>
    <?php $APPLICATION->SetAdditionalCSS("/local/templates/front/frontend/dist/assets/css/app.css"); ?>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(88405539, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/88405539" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

</head>

<body>
<div class="main-container">

    <header class="header">
        <div class="container-new">
            <div class="header__inner">
                <a href="/" class="header__logo">
              <span class="logo">
                  <img src="/local/templates/front/frontend/dist/assets/img/logo-white.svg"
                       alt="SEO продвижение – частный специалист." class="logo__image">
                  <img src="/local/templates/front/frontend/dist/assets/img/type-white.svg"
                       alt="SEO продвижение – частный специалист." class="logo__text">
              </span>
                </a>
                <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "menu_header",
                        array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "top",
                                "COMPONENT_TEMPLATE" => "menu_header",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "top",
                                "USE_EXT" => "N"
                        )
                ); ?>

                <?php if ($APPLICATION->sDirPath == '/reklama/'): ?>
                    <a href="https://t.me/Ivanova_IM" class="header__btn button button--secondary" target="_blank">
                        Предложить проект
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 1L11 6M11 6L6 11M11 6L1 6" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <a href="https://t.me/AndreyBaklenev" class="header__btn button button--secondary" target="_blank">
                        Предложить проект
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 1L11 6M11 6L6 11M11 6L1 6" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <button class="header__burger burger">
                    <span class="burger__line"></span>
                </button>
            </div>
            <div class="header__menu menu">
                <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "menu_burger",
                        array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "left",
                                "USE_EXT" => "Y"
                        )
                ); ?>
            </div>
        </div>
    </header>