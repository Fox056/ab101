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
function safeHtmlOutput($content)
{
    if (empty($content)) {
        return '';
    }

    // Декодируем HTML сущности (&lt;br/&gt; -> <br/>)
    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
    $content = trim($content);

    // Если контент содержит <br/> или <br> теги, преобразуем в список
    if (strpos($content, '<br/>') !== false || strpos($content, '<br>') !== false) {
        // Разбиваем по <br/> или <br>
        $items = preg_split('/<br\s*\/?>/i', $content);
        $items = array_filter(array_map('trim', $items)); // Убираем пустые элементы

        // Если элементов больше 1, делаем список
        if (count($items) > 1) {
            $html = '<ul>';
            foreach ($items as $item) {
                if (!empty($item)) {
                    $html .= '<li>' . htmlspecialchars($item) . '</li>';
                }
            }
            $html .= '</ul>';
            return $html;
        } else {
            // Если один элемент, возвращаем как абзац
            return '<p>' . htmlspecialchars($items[0]) . '</p>';
        }
    } else {
        // Если нет <br/> тегов, возвращаем как обычный текст в абзаце
        return '<p>' . htmlspecialchars($content) . '</p>';
    }
}

// Для заголовков, где нужны только <br> теги
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

// Функция для FAQ и аккордеонов - смешанный контент (списки + параграфы)
function safeMixedContentOutput($content)
{
    if (empty($content)) {
        return '';
    }

    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
    $content = str_replace('&quot;', '"', $content);
    $content = trim($content);

    if (strpos($content, '<br/>') !== false || strpos($content, '<br>') !== false) {
        $items = preg_split('/<br\s*\/?>/i', $content);
        $items = array_filter(array_map('trim', $items));

        if (count($items) <= 1) {
            return '<p>' . htmlspecialchars($items[0] ?? '', ENT_QUOTES, 'UTF-8') . '</p>';
        }

        $html = '';
        $currentListItems = [];

        foreach ($items as $item) {
            if (!empty($item)) {
                // Элементы списка - строки, которые содержат детальную информацию
                $isListItem = preg_match('/^(SEO:\s+.+|Контекстная\s+реклама:\s+.+|Техническое\s+.+|Ускорение\s+.+|Корректная\s+.+|Адаптивность\s+.+|Исправление\s+.+|У\s+них\s+.+|Сильная\s+.+|Лучшая\s+.+|Использование\s+.+|Некорректные\s+.+|Переоптимизация\s+.+|Покупка\s+.+|Проверить\s+.+|Резервные\s+.+|Алгоритмные\s+.+|Технические\s+.+|Действия\s+.+|Анализ\s+.+|План\s+.+|Быстрый\s+.+|Подходит\s+.+|Долгий\s+.+|Лучше\s+.+|Частотность\s+.+|Конкурентность\s*\.?\s*$|Коммерческий\s+.+|Низкокачественные\s+.+|Шаблонные\s+.+|Отсутствие\s+.+|Фокус\s+.+|Упор\s+.+|Постепенное\s+.+|Рост\s+.+|Увеличение\s+.+|От\s+\d.+|Старт\s+–\s+.+|Контекст:\s+.+|Google\s+Data\s+Studio.+|Разбор\s+изменений.+)/ui', $item);

                // Заголовки секций - короткие фразы с двоеточием без деталей
                $isSectionHeader = preg_match('/^(Критерии|Инструменты|Формы\s+отчетности|Риски|Что\s+(влияет\s+на\s+сроки|можно\s+гарантировать|требовать\s+от\s+подрядчика|учесть)|Примеры\s+метрик|Возможные\s+причины|Проблема|Как\s+(защититься|оптимизировать\s+бюджет)|Контекст|SEO):\s*$|^(Мы\s+дадим|Запросы\s+должны|Комбинация)/ui', $item);

                if ($isListItem && !$isSectionHeader) {
                    $currentListItems[] = $item;
                } else {
                    // Выводим накопленные элементы списка
                    if (!empty($currentListItems)) {
                        $html .= '<ul>';
                        foreach ($currentListItems as $listItem) {
                            $html .= '<li>' . htmlspecialchars($listItem, ENT_QUOTES, 'UTF-8') . '</li>';
                        }
                        $html .= '</ul>';
                        $currentListItems = [];
                    }

                    // Добавляем как параграф
                    $html .= '<p>' . htmlspecialchars($item, ENT_QUOTES, 'UTF-8') . '</p>';
                }
            }
        }

        // Выводим оставшиеся элементы списка
        if (!empty($currentListItems)) {
            $html .= '<ul>';
            foreach ($currentListItems as $listItem) {
                $html .= '<li>' . htmlspecialchars($listItem, ENT_QUOTES, 'UTF-8') . '</li>';
            }
            $html .= '</ul>';
        }

        return html_entity_decode($html, ENT_QUOTES, 'UTF-8');
    } else {
        $result = '<p>' . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . '</p>';
        return html_entity_decode($result, ENT_QUOTES, 'UTF-8');
    }
}
?>

<main class="main">
    <!-- Welcome секция -->
    <?php if (!empty($arResult["WELCOME"]["TITLE"]) || !empty($arResult["WELCOME"]["SUBTITLE"]) || !empty($arResult["WELCOME"]["TELEGRAM_URL"]) || array_filter($arResult["WELCOME"]["ADVANTAGES"] ?? [])): ?>
    <section id="welcome" class="welcome">
        <div class="welcome__container container-new">
            <div class="welcome__main">
                <div class="welcome__main-col welcome__main-col--pic">
                    <img
                            class="welcome__pic"
                            src="/local/templates/front/frontend/dist/assets/img/analytics.svg"
                            alt="Аналитика"
                            loading="lazy"
                    />
                </div>

                <div class="welcome__main-col welcome__main-col--text">
                    <?php if (!empty($arResult["WELCOME"]["TITLE"])): ?>
                    <h1 class="welcome__title">
                        <?= safeHtmlOutputTitle($arResult["WELCOME"]["TITLE"]) ?>
                    </h1>
                    <?php endif; ?>

                    <?php if (!empty($arResult["WELCOME"]["SUBTITLE"])): ?>
                    <p class="welcome__subtitle">
                        <?= htmlspecialchars($arResult["WELCOME"]["SUBTITLE"]) ?>
                    </p>
                    <?php endif; ?>

                    <?php if (!empty($arResult["WELCOME"]["TELEGRAM_URL"])): ?>
                    <a
                            class="welcome__btn button button--secondary"
                            href="<?= htmlspecialchars($arResult["WELCOME"]["TELEGRAM_URL"]) ?>"
                    >
                        Написать в Телеграм
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 1L11 6M11 6L6 11M11 6L1 6" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            // Проверяем наличие данных в преимуществах
            $hasAdvantages = false;
            for ($i = 1; $i <= 3; $i++) {
                $advantage = $arResult["WELCOME"]["ADVANTAGES"][$i] ?? [];
                if (!empty($advantage["TITLE"]) || !empty($advantage["TEXT"])) {
                    $hasAdvantages = true;
                    break;
                }
            }
            ?>

            <?php if ($hasAdvantages): ?>
            <div class="welcome__footer">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <?php
                    $advantage = $arResult["WELCOME"]["ADVANTAGES"][$i] ?? [];
                    if (!empty($advantage["TITLE"]) || !empty($advantage["TEXT"])):
                    ?>
                    <div class="welcome__footer-col">
                        <div class="welcome__footer-content">
                            <?php if (!empty($advantage["TITLE"])): ?>
                            <p class="welcome__footer-title">
                                <?= htmlspecialchars($advantage["TITLE"]) ?>
                            </p>
                            <?php endif; ?>

                            <?php if (!empty($advantage["TEXT"])): ?>
                            <p class="welcome__footer-text">
                                <?= htmlspecialchars($advantage["TEXT"]) ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <div class="stack">
        <!-- Complex секция -->
        <?php if (!empty($arResult["COMPLEX"]["TITLE"]) || !empty($arResult["COMPLEX"]["INTRO"]) || !empty($arResult["COMPLEX"]["SUBTITLE"]) || array_filter($arResult["COMPLEX"]["LIST_ITEMS"] ?? [])): ?>
            <section id="complex" class="section-new complex">
                <div class="complex__container container-new">
                    <?php if (!empty($arResult["COMPLEX"]["TITLE"])): ?>
                        <div class="section-new__header">
                            <h2 class="section-new__title complex__title">
                                <?= safeHtmlOutputTitle($arResult["COMPLEX"]["TITLE"]) ?>
                            </h2>
                        </div>
                    <?php endif; ?>

                    <div class="section-new__body">
                        <div class="complex__table">
                            <?php if (!empty($arResult["COMPLEX"]["INTRO"])): ?>
                                <div class="complex__table-row">
                                    <div class="complex__table-col"></div>
                                    <div class="complex__table-col">
                                        <p class="complex__intro">
                                            <?= htmlspecialchars($arResult["COMPLEX"]["INTRO"]) ?>
                                        </p>
                                    </div>
                                    <div class="complex__table-col"></div>
                                </div>
                            <?php endif; ?>

                            <?php if (array_filter($arResult["COMPLEX"]["LIST_ITEMS"] ?? [])): ?>
                                <div class="complex__table-row">
                                    <div class="complex__table-col">
                                        <p class="complex__table-label">Вы получаете:</p>
                                    </div>

                                    <div class="complex__table-col">
                                        <div class="complex__list">
                                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                                <?php if (!empty($arResult["COMPLEX"]["LIST_ITEMS"][$i])): ?>
                                                    <div class="complex__list-item">
                                                        <?= htmlspecialchars($arResult["COMPLEX"]["LIST_ITEMS"][$i]) ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <div class="complex__table-col"></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($arResult["COMPLEX"]["SUBTITLE"])): ?>
                                <div class="complex__table-row">
                                    <div class="complex__table-col"></div>
                                    <div class="complex__table-col">
                                        <p class="complex__subtitle">
                                            <?= htmlspecialchars($arResult["COMPLEX"]["SUBTITLE"]) ?>
                                        </p>
                                    </div>
                                    <div class="complex__table-col"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Attract секция -->
        <?php if (!empty($arResult["ATTRACT"]["TITLE"]) || !empty($arResult["ATTRACT"]["SUBTITLE"])): ?>
        <section id="attract" class="section-new attract">
            <div class="attract__container container-new">
                <div class="attract__header">
                    <?php if (!empty($arResult["ATTRACT"]["TITLE"])): ?>
                    <h2 class="attract__title">
                        <?= safeHtmlOutputTitle($arResult["ATTRACT"]["TITLE"]) ?>
                    </h2>
                    <?php endif; ?>

                    <?php if (!empty($arResult["ATTRACT"]["SUBTITLE"])): ?>
                    <p class="attract__subtitle">
                        <?= htmlspecialchars($arResult["ATTRACT"]["SUBTITLE"]) ?>
                    </p>
                    <?php endif; ?>
                </div>

                <div class="attract__main"></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Cases секция -->
        <?php if (!empty($arResult["CASES"]["TITLE"]) || !empty($arResult["CASES"]["DESCRIPTION"])): ?>
            <section id="cases-slider" class="section-new">
                <div class="container-new">
                    <div class="section-new__header">
                        <?php if (!empty($arResult["CASES"]["TITLE"])): ?>
                            <h2 class="section-new__title">
                                <?= htmlspecialchars($arResult["CASES"]["TITLE"]) ?>
                            </h2>
                        <?php endif; ?>

                        <?php if (!empty($arResult["CASES"]["DESCRIPTION"])): ?>
                            <p class="section-new__descr">
                                <?= safeHtmlOutputTitle($arResult["CASES"]["DESCRIPTION"]) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="section-new__body">
                        <!-- Статичное содержимое кейсов остается без изменений -->
                        <div class="case-slider">
                            <div class="swiper" data-case-slider>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="case-tile">
                                            <div class="case-tile__main">
                                                <div class="case-tile__title">
                                                    <span class="case-tile__badge">№1</span>
                                                    Привлечение покупателей для ресейл — платформы брендов класса LUX.
                                                </div>

                                                <div class="case-tile__panel">
                                                    <div class="case-tile__crumbs">
                                                        <span class="case-tile__crumbs-item">SEO</span>
                                                        <span class="case-tile__crumbs-item">SMM</span>
                                                        <span class="case-tile__crumbs-item">Контекстная реклама</span>
                                                    </div>

                                                    <a class="case-tile__link" href="#">
                                                        Посмотреть результат
                                                    </a>
                                                </div>

                                                <div class="case-tile__target">
                                                    <div class="case-tile__target-item">
                                                        <div class="case-tile__subtitle">CLF (Customer Lifecycle):</div>
                                                        <div class="case-tile__descr">2,5 года</div>
                                                    </div>

                                                    <div class="case-tile__target-item">
                                                        <div class="case-tile__subtitle">Цель:</div>
                                                        <div class="case-tile__descr">
                                                            Увеличение количества покупок, посетителей,
                                                            глубины и времени, проведенном на сайте.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="case-tile__cols">
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Рост покупок вырос на 600%</div>
                                                    <div class="case-tile__bar case-tile__bar--4">
                                                        <span>600%</span>
                                                    </div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Снизила процент отказов с 30 до 25%,
                                                        оптимизировав бюджет и сократив расходы на нецелевые визиты
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--3">
                                                        <span>25%</span>
                                                    </div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Повышение глубины и времени
                                                        проведенном на сайте
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="case-tile">
                                            <div class="case-tile__main">
                                                <div class="case-tile__title">
                                                    <span class="case-tile__badge">№2</span>
                                                    Ежемесячный рост числа заявок при снижении стоимости лида в ниже
                                                    строительства зданий площадью от 1500 кв.м.
                                                </div>
                                                <a class="case-tile__link" href="#">Посмотреть результат</a>
                                                <div class="case-tile__target">
                                                    <div class="case-tile__subtitle">Цель</div>
                                                    <div class="case-tile__descr">Удерживать позиции в рекламной выдаче и
                                                        увеличить количество квалифицированных лидов как минимум на 15%.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="case-tile__cols">
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Снизила процент отказов с 35 до 28%,
                                                        оптимизировав бюджет и сократив расходы на нецелевые визиты
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--4">
                                                        <span>28%</span>
                                                    </div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">В сентябре 2024 года помогла внедрить
                                                        систему сквозной аналитики для повышения прозрачности и контроля над
                                                        процессами
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--3"></div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Увеличила количество квалифицированных
                                                        лидов
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--2"></div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Полностью пересобрала рекламные
                                                        кампании
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="case-tile">
                                            <div class="case-tile__main">
                                                <div class="case-tile__title">
                                                    <span class="case-tile__badge">№3</span>
                                                    Реклама для DIMoutlet интернет-магазин нижнего белья DIM
                                                </div>
                                                <a class="case-tile__link" href="#">Посмотреть результат</a>
                                                <div class="case-tile__target">
                                                    <div class="case-tile__subtitle">Цель</div>
                                                    <div class="case-tile__descr">Увеличение количества покупок,
                                                        посетителей, глубины и времени, проведенном на сайте.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="case-tile__cols">
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Положительная динамика доходов от
                                                        рекламного трафика
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--4">
                                                        <span>&gt; <div>600<small>тыс.руб/мес</small></div></span>
                                                    </div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Конверсия в продажу от общего трафика
                                                        с рекламы
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--3">
                                                        <span>~1,5%</span>
                                                    </div>
                                                </div>
                                                <div class="case-tile__col">
                                                    <div class="case-tile__col-descr">Интенсивный рост рекламного трафика за
                                                        счет единовременного использования различных форматов рекламы в
                                                        Яндекс и Google
                                                    </div>
                                                    <div class="case-tile__bar case-tile__bar--2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="case-slider__footer">
                                <div class="swiper-button-prev" data-case-prev>
                                    <img src="/local/templates/front/frontend/dist/assets/img/prev.svg" alt="prev">
                                </div>

                                <div class="swiper-pagination" data-case-pagination></div>

                                <div class="swiper-button-next" data-case-next>
                                    <img src="/local/templates/front/frontend/dist/assets/img/next.svg" alt="next">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Expertise секция -->
        <?php if (!empty($arResult["EXPERTISE"]["TITLE"]) || !empty($arResult["EXPERTISE"]["SEO"]["NAME"]) || !empty($arResult["EXPERTISE"]["PPC"]["NAME"]) || !empty($arResult["EXPERTISE"]["DEV"]["NAME"])): ?>
            <section id="expertise" class="section-new expertise">
                <div class="expertise__container container-new">
                    <?php if (!empty($arResult["EXPERTISE"]["TITLE"])): ?>
                        <div class="section-new__header">
                            <h2 class="section-new__title">
                                <?= htmlspecialchars($arResult["EXPERTISE"]["TITLE"]) ?>
                            </h2>
                        </div>
                    <?php endif; ?>

                    <div class="section-new__body">
                        <div class="expertise__row">
                            <!-- SEO блок -->
                            <?php if (!empty($arResult["EXPERTISE"]["SEO"]["NAME"]) || !empty($arResult["EXPERTISE"]["SEO"]["DESC"])): ?>
                                <div class="expertise__col expertise__col--primary">
                                    <div class="expertise__col-item">
                                        <?php if (!empty($arResult["EXPERTISE"]["SEO"]["NAME"])): ?>
                                            <p class="expertise__col-name">
                                                <?= htmlspecialchars($arResult["EXPERTISE"]["SEO"]["NAME"]) ?>
                                            </p>
                                        <?php endif; ?>

                                        <span class="expertise__col-icon">
                                    <img src="/local/templates/front/frontend/dist/assets/img/icons/icon-search.svg"
                                         loading="lazy">
                                </span>
                                    </div>

                                    <?php if (!empty($arResult["EXPERTISE"]["SEO"]["DESC"]) || !empty($arResult["EXPERTISE"]["SEO"]["LINK"])): ?>
                                        <div class="expertise__col-item">
                                            <?php if (!empty($arResult["EXPERTISE"]["SEO"]["DESC"])): ?>
                                                <p class="expertise__col-desc">
                                                    <?= htmlspecialchars($arResult["EXPERTISE"]["SEO"]["DESC"]) ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (!empty($arResult["EXPERTISE"]["SEO"]["LINK"])): ?>
                                                <a href="<?= htmlspecialchars($arResult["EXPERTISE"]["SEO"]["LINK"]) ?>" class="expertise__col-more">
                                                    Подробнее об услуге SEO
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- PPC блок -->
                            <?php if (!empty($arResult["EXPERTISE"]["PPC"]["NAME"]) || !empty($arResult["EXPERTISE"]["PPC"]["DESC"])): ?>
                                <div class="expertise__col expertise__col--secondary">
                                    <div class="expertise__col-item">
                                        <?php if (!empty($arResult["EXPERTISE"]["PPC"]["NAME"])): ?>
                                            <p class="expertise__col-name">
                                                <?= htmlspecialchars($arResult["EXPERTISE"]["PPC"]["NAME"]) ?>
                                            </p>
                                        <?php endif; ?>

                                        <span class="expertise__col-icon">
                                    <img src="/local/templates/front/frontend/dist/assets/img/icons/icon-ad.svg"
                                         loading="lazy">
                                </span>
                                    </div>

                                    <?php if (!empty($arResult["EXPERTISE"]["PPC"]["DESC"]) || !empty($arResult["EXPERTISE"]["PPC"]["LINK"])): ?>
                                        <div class="expertise__col-item">
                                            <?php if (!empty($arResult["EXPERTISE"]["PPC"]["DESC"])): ?>
                                                <p class="expertise__col-desc">
                                                    <?= htmlspecialchars($arResult["EXPERTISE"]["PPC"]["DESC"]) ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (!empty($arResult["EXPERTISE"]["PPC"]["LINK"])): ?>
                                                <a href="<?= htmlspecialchars($arResult["EXPERTISE"]["PPC"]["LINK"]) ?>" class="expertise__col-more">
                                                    Подробнее об услуге Я.Директ
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- DEV блок -->
                            <?php if (!empty($arResult["EXPERTISE"]["DEV"]["NAME"]) || !empty($arResult["EXPERTISE"]["DEV"]["DESC"]) || !empty($arResult["EXPERTISE"]["STACK"]["FRONTEND"]) || !empty($arResult["EXPERTISE"]["STACK"]["BACKEND"]) || !empty($arResult["EXPERTISE"]["STACK"]["QA"])): ?>
                                <div class="expertise__col expertise__col--tertiary">
                                    <div class="expertise__col-item">
                                        <?php if (!empty($arResult["EXPERTISE"]["DEV"]["NAME"])): ?>
                                            <p class="expertise__col-name">
                                                <?= safeHtmlOutputTitle($arResult["EXPERTISE"]["DEV"]["NAME"]) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($arResult["EXPERTISE"]["DEV"]["DESC"])): ?>
                                        <div class="expertise__col-item">
                                            <p class="expertise__col-desc">
                                                <?= htmlspecialchars($arResult["EXPERTISE"]["DEV"]["DESC"]) ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="expertise__col-item expertise__col-item--tag">
                                <span class="expertise__col-tag">
                                    Дополнительно
                                </span>
                                    </div>

                                    <?php if (!empty($arResult["EXPERTISE"]["STACK"]["FRONTEND"]) || !empty($arResult["EXPERTISE"]["STACK"]["BACKEND"]) || !empty($arResult["EXPERTISE"]["STACK"]["QA"])): ?>
                                        <div class="expertise__col-item expertise__col-item--stack">
                                            <div class="expertise__stack">
                                                <?php if (!empty($arResult["EXPERTISE"]["STACK"]["FRONTEND"])): ?>
                                                    <div class="expertise__stack-col expertise__stack-col--frontend">
                                                        <div class="expertise__stack-header">
                                                            <p class="expertise__stack-name">Frontend:</p>
                                                            <p class="expertise__stack-list">
                                                                <?= htmlspecialchars($arResult["EXPERTISE"]["STACK"]["FRONTEND"]) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($arResult["EXPERTISE"]["STACK"]["BACKEND"])): ?>
                                                    <div class="expertise__stack-col expertise__stack-col--backend">
                                                        <div class="expertise__stack-header">
                                                            <p class="expertise__stack-name">Backend:</p>
                                                            <p class="expertise__stack-list">
                                                                <?= htmlspecialchars($arResult["EXPERTISE"]["STACK"]["BACKEND"]) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($arResult["EXPERTISE"]["STACK"]["QA"])): ?>
                                                    <div class="expertise__stack-col expertise__stack-col--qa">
                                                        <div class="expertise__stack-header">
                                                            <p class="expertise__stack-name">QA:</p>
                                                            <p class="expertise__stack-list">
                                                                <?= htmlspecialchars($arResult["EXPERTISE"]["STACK"]["QA"]) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Methodology секция -->
        <?php if (!empty($arResult["METHODOLOGY"]["TITLE"]) || !empty($arResult["METHODOLOGY"]["SEO"]["TITLE"]) || !empty($arResult["METHODOLOGY"]["PPC"]["TITLE"]) || !empty($arResult["METHODOLOGY"]["COMBINED"]["TITLE"]) || !empty($arResult["METHODOLOGY"]["ADDITIONAL"]["TITLE"])): ?>
            <section id="methodology" class="section-new methodology">
                <div class="methodology__container">
                    <div class="section-new__header container-new">
                        <?php if (!empty($arResult["METHODOLOGY"]["TITLE"])): ?>
                            <h2 class="section-new__title">
                                <?= htmlspecialchars($arResult["METHODOLOGY"]["TITLE"]) ?>
                            </h2>
                        <?php endif; ?>
                    </div>

                    <div class="section-new__body">
                        <div class="methodology__tabs">
                            <ul
                                    id="methodology-tabs-header"
                                    class="methodology__tabs-header container-new"
                                    data-tabs="methodology-tabs"
                                    role="tablist"
                            >
                                <?php if (!empty($arResult["METHODOLOGY"]["SEO"]["TITLE"])): ?>
                                    <li class="methodology__tabs-title tabs-title is-active" role="presentation">
                                        <a
                                                href="#methodology-tabs-panel-1"
                                                aria-selected="true"
                                                data-tabs-target="methodology-tabs-panel-1"
                                                role="tab"
                                                aria-controls="methodology-tabs-panel-1"
                                                id="methodology-tabs-panel-1-label"
                                                tabindex="0"
                                        >
                                            SEO
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($arResult["METHODOLOGY"]["PPC"]["TITLE"])): ?>
                                    <li class="methodology__tabs-title tabs-title" role="presentation">
                                        <a
                                                href="#methodology-tabs-panel-2"
                                                data-tabs-target="methodology-tabs-panel-2"
                                                role="tab"
                                                aria-controls="methodology-tabs-panel-2"
                                                aria-selected="false"
                                                id="methodology-tabs-panel-2-label"
                                                tabindex="-1"
                                        >
                                            Контекстная реклама
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($arResult["METHODOLOGY"]["COMBINED"]["TITLE"])): ?>
                                    <li class="methodology__tabs-title tabs-title" role="presentation">
                                        <a
                                                href="#methodology-tabs-panel-3"
                                                data-tabs-target="methodology-tabs-panel-3"
                                                role="tab"
                                                aria-controls="methodology-tabs-panel-3"
                                                aria-selected="false"
                                                id="methodology-tabs-panel-3-label"
                                                tabindex="-1"
                                        >
                                            SEO + Контекст
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($arResult["METHODOLOGY"]["ADDITIONAL"]["TITLE"])): ?>
                                    <li class="methodology__tabs-title tabs-title" role="presentation">
                                        <a
                                                href="#methodology-tabs-panel-4"
                                                data-tabs-target="methodology-tabs-panel-4"
                                                role="tab"
                                                aria-controls="methodology-tabs-panel-4"
                                                aria-selected="false"
                                                id="methodology-tabs-panel-4-label"
                                                tabindex="-1"
                                        >
                                            Дополнительные инструменты
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <div
                                    class="methodology__tabs-main tabs-content"
                                    data-tabs-content="methodology-tabs-header"
                            >
                                <!-- SEO таб -->
                                <?php if (!empty($arResult["METHODOLOGY"]["SEO"]["TITLE"])): ?>
                                    <div
                                            id="methodology-tabs-panel-1"
                                            class="methodology__tabs-panel container-new tabs-panel is-active"
                                            role="tabpanel"
                                            aria-labelledby="methodology-tabs-panel-1-label"
                                    >
                                        <div class="methodology__tabs-row">
                                            <div class="methodology__tabs-col methodology__tabs-col--title">
                                                <h2 class="methodology__tabs-name">
                                                    <?= safeHtmlOutputTitle($arResult["METHODOLOGY"]["SEO"]["TITLE"]) ?>
                                                </h2>

                                                <?php if (!empty($arResult["METHODOLOGY"]["SEO"]["SUBTITLE"])): ?>
                                                    <p class="methodology__tabs-subtitle">
                                                        <?= htmlspecialchars($arResult["METHODOLOGY"]["SEO"]["SUBTITLE"]) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="methodology__tabs-col">
                                                <div class="methodology__tabs-text">
                                                    <ul
                                                            class="methodology__accordion accordion"
                                                            data-accordion
                                                            data-allow-all-closed="true"
                                                    >
                                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                                            <?php
                                                            $accordion = $arResult["METHODOLOGY"]["SEO"]["ACCORDIONS"][$i] ?? [];
                                                            if (!empty($accordion["TITLE"])):
                                                                ?>
                                                                <li
                                                                        class="methodology__accordion-item accordion-item"
                                                                        data-accordion-item
                                                                >
                                                                    <a
                                                                            class="methodology__accordion-title accordion-title"
                                                                            href="#"
                                                                            aria-expanded="false"
                                                                    >
                                                                        <?= htmlspecialchars($accordion["TITLE"]) ?>
                                                                    </a>

                                                                    <?php if (!empty($accordion["CONTENT"])): ?>
                                                                        <div
                                                                                class="methodology__accordion-content accordion-content"
                                                                                data-tab-content
                                                                                style="display: none;"
                                                                                role="region"
                                                                                aria-hidden="true"
                                                                        >
                                                                            <?= safeMixedContentOutput($accordion["CONTENT"]) ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- PPC таб -->
                                <?php if (!empty($arResult["METHODOLOGY"]["PPC"]["TITLE"])): ?>
                                    <div
                                            id="methodology-tabs-panel-2"
                                            class="methodology__tabs-panel container-new tabs-panel"
                                            role="tabpanel"
                                            aria-labelledby="methodology-tabs-panel-2-label"
                                            aria-hidden="true"
                                    >
                                        <div class="methodology__tabs-row">
                                            <div class="methodology__tabs-col methodology__tabs-col--title">
                                                <h2 class="methodology__tabs-name">
                                                    <?= safeHtmlOutputTitle($arResult["METHODOLOGY"]["PPC"]["TITLE"]) ?>
                                                </h2>

                                                <?php if (!empty($arResult["METHODOLOGY"]["PPC"]["SUBTITLE"])): ?>
                                                    <p class="methodology__tabs-subtitle">
                                                        <?= htmlspecialchars($arResult["METHODOLOGY"]["PPC"]["SUBTITLE"]) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="methodology__tabs-col">
                                                <div class="methodology__tabs-text">
                                                    <ul
                                                            class="methodology__accordion accordion"
                                                            data-accordion
                                                            data-allow-all-closed="true"
                                                    >
                                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                                            <?php
                                                            $accordion = $arResult["METHODOLOGY"]["PPC"]["ACCORDIONS"][$i] ?? [];
                                                            if (!empty($accordion["TITLE"])):
                                                                ?>
                                                                <li
                                                                        class="methodology__accordion-item accordion-item"
                                                                        data-accordion-item
                                                                >
                                                                    <a
                                                                            class="methodology__accordion-title accordion-title"
                                                                            href="#"
                                                                            aria-expanded="false"
                                                                    >
                                                                        <?= htmlspecialchars($accordion["TITLE"]) ?>
                                                                    </a>

                                                                    <?php if (!empty($accordion["CONTENT"])): ?>
                                                                        <div
                                                                                class="methodology__accordion-content accordion-content"
                                                                                data-tab-content
                                                                                style="display: none;"
                                                                                role="region"
                                                                                aria-hidden="true"
                                                                        >
                                                                            <?= safeMixedContentOutput($accordion["CONTENT"]) ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Combined таб -->
                                <?php if (!empty($arResult["METHODOLOGY"]["COMBINED"]["TITLE"])): ?>
                                    <div
                                            id="methodology-tabs-panel-3"
                                            class="methodology__tabs-panel container-new tabs-panel"
                                            role="tabpanel"
                                            aria-labelledby="methodology-tabs-panel-3-label"
                                            aria-hidden="true"
                                    >
                                        <div class="methodology__tabs-row">
                                            <div class="methodology__tabs-col methodology__tabs-col--title">
                                                <h2 class="methodology__tabs-name">
                                                    <?= safeHtmlOutputTitle($arResult["METHODOLOGY"]["COMBINED"]["TITLE"]) ?>
                                                </h2>
                                            </div>

                                            <div class="methodology__tabs-col">
                                                <div class="methodology__tabs-text">
                                                    <ul
                                                            class="methodology__accordion accordion"
                                                            data-accordion
                                                            data-allow-all-closed="true"
                                                    >
                                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                                            <?php
                                                            $accordion = $arResult["METHODOLOGY"]["COMBINED"]["ACCORDIONS"][$i] ?? [];
                                                            if (!empty($accordion["TITLE"])):
                                                                ?>
                                                                <li
                                                                        class="methodology__accordion-item accordion-item"
                                                                        data-accordion-item
                                                                >
                                                                    <a
                                                                            class="methodology__accordion-title accordion-title"
                                                                            href="#"
                                                                            aria-expanded="false"
                                                                    >
                                                                        <?= htmlspecialchars($accordion["TITLE"]) ?>
                                                                    </a>

                                                                    <?php if (!empty($accordion["CONTENT"])): ?>
                                                                        <div
                                                                                class="methodology__accordion-content accordion-content"
                                                                                data-tab-content
                                                                                style="display: none;"
                                                                                role="region"
                                                                                aria-hidden="true"
                                                                        >
                                                                            <?= safeMixedContentOutput($accordion["CONTENT"]) ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Additional таб -->
                                <?php if (!empty($arResult["METHODOLOGY"]["ADDITIONAL"]["TITLE"])): ?>
                                    <div
                                            id="methodology-tabs-panel-4"
                                            class="methodology__tabs-panel container-new tabs-panel"
                                            role="tabpanel"
                                            aria-labelledby="methodology-tabs-panel-4-label"
                                            aria-hidden="true"
                                    >
                                        <div class="methodology__tabs-row">
                                            <div class="methodology__tabs-col methodology__tabs-col--title">
                                                <h2 class="methodology__tabs-name">
                                                    <?= safeHtmlOutputTitle($arResult["METHODOLOGY"]["ADDITIONAL"]["TITLE"]) ?>
                                                </h2>
                                            </div>

                                            <div class="methodology__tabs-col">
                                                <div class="methodology__tabs-text">
                                                    <ul
                                                            class="methodology__accordion accordion"
                                                            data-accordion
                                                            data-allow-all-closed="true"
                                                    >
                                                        <?php for ($i = 1; $i <= 3; $i++): ?>
                                                            <?php
                                                            $accordion = $arResult["METHODOLOGY"]["ADDITIONAL"]["ACCORDIONS"][$i] ?? [];
                                                            if (!empty($accordion["TITLE"])):
                                                                ?>
                                                                <li
                                                                        class="methodology__accordion-item accordion-item"
                                                                        data-accordion-item
                                                                >
                                                                    <a
                                                                            class="methodology__accordion-title accordion-title"
                                                                            href="#"
                                                                            aria-expanded="false"
                                                                    >
                                                                        <?= htmlspecialchars($accordion["TITLE"]) ?>
                                                                    </a>

                                                                    <?php if (!empty($accordion["CONTENT"])): ?>
                                                                        <div
                                                                                class="methodology__accordion-content accordion-content"
                                                                                data-tab-content
                                                                                style="display: none;"
                                                                                role="region"
                                                                                aria-hidden="true"
                                                                        >
                                                                            <?= safeMixedContentOutput($accordion["CONTENT"]) ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Starting секция -->
        <?php if (!empty($arResult["STARTING"]["TITLE"]) || !empty($arResult["STARTING"]["DESCRIPTION"]) || !empty($arResult["STARTING"]["FORM_TITLE"]) || array_filter($arResult["STARTING"]["STEPS"] ?? [])): ?>
        <section id="starting-new" class="section-new starting-new">
            <div class="starting-new__container container-new">
                <?php if (!empty($arResult["STARTING"]["TITLE"])): ?>
                <div class="section-new__header">
                    <h2 class="section-new__title">
                        <?= htmlspecialchars($arResult["STARTING"]["TITLE"]) ?>
                    </h2>
                </div>
                <?php endif; ?>

                <div class="section-new__body">
                    <div class="starting-new__list">
                        <?php if (!empty($arResult["STARTING"]["DESCRIPTION"])): ?>
                        <div class="starting-new__list-head">
                            <div class="starting-new__list-col">
                                <h2 class="starting-new__desc">
                                    <?= safeHtmlOutputTitle($arResult["STARTING"]["DESCRIPTION"]) ?>
                                </h2>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (array_filter($arResult["STARTING"]["STEPS"] ?? [])): ?>
                        <div class="starting-new__list-main">
                            <div class="starting-steps">
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <?php
                                    $step = $arResult["STARTING"]["STEPS"][$i] ?? [];
                                    if (!empty($step["NUMBER"]) || !empty($step["TEXT"])):
                                    ?>
                                    <div class="starting-steps__row">
                                        <div class="starting-steps__col"></div>
                                        <div class="starting-steps__col">
                                    <?php if (!empty($step["NUMBER"])): ?>
                                    <span class="starting-steps__number">
                                        <?= htmlspecialchars($step["NUMBER"]) ?>
                                    </span>
                                    <?php endif; ?>

                                    <?php if (!empty($step["TEXT"])): ?>
                                        <p class="starting-steps__text">
                                            <?= html_entity_decode($step["TEXT"], ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                    <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($arResult["STARTING"]["FORM_TITLE"])): ?>
                    <div class="starting-new__form">
                        <div class="form-block">
                            <div class="form-block__body">
                                <div class="form-block__box" data-request-form-base="active">
                                    <div class="form-block__form-title">
                                        <?= htmlspecialchars($arResult["STARTING"]["FORM_TITLE"]) ?>
                                    </div>
                                    <form action="#" class="form-block__form" data-request-form novalidate>
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
                                        <input class="input" type="text" name="connect" id="connect" autocomplete="off"
                                               placeholder="Укажите удобный для вас способ связи и контакт для связи (e-mail, мессенджеры), для обмена информацией"
                                               title="Укажите удобный для вас способ связи и контакт для связи (e-mail, мессенджеры), для обмена информацией"
                                               required>
                                        <input class="input" type="text" name="name" id="name" autocomplete="name"
                                               placeholder="Как к вам обращаться" title="Как к вам обращаться" required>
                                        <label class="checkbox">
                                            <input class="checkbox__input" name="agreement" id="agreement"
                                                   type="checkbox" required>
                                            <span class="checkbox__fake-input"></span>
                                            <span class="checkbox__title">Я согласен на <a href="#">обработку персональных данных</a> в соответствии с <a
                                                        href="#">политикой конфиденциальности</a></span>
                                        </label>
                                        <label class="checkbox">
                                            <input class="checkbox__input" name="personal" id="personal" type="checkbox"
                                                   required>
                                            <span class="checkbox__fake-input"></span>
                                            <span class="checkbox__title">Да, я добровольно даю своё согласие на <a
                                                        href="#">обработку персональных данных</a></span>
                                        </label>
                                        <button
                                                class="button button--primary form-block__button"
                                                type="submit"
                                                data-request-form-submit
                                                disabled
                                        >
                                            Отправить
                                        </button>
                                    </form>
                                </div>

                                <div class="form-block__box" data-request-form-success>
                                    <div class="form-block__form-title">Благодарим вас за заполнение формы</div>
                                    <div class="form-block__side">
                                        <div class="form-block__message">Наш специалист свяжется с вами в ближайшее
                                            время
                                        </div>
                                        <button class="button button--primary form-block__button"
                                                data-request-form-reset>Отправить повторный запрос
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- FAQ секция -->
        <?php if (!empty($arResult["FAQ"]["TITLE"]) || !empty($arResult["FAQ"]["MORE_BUTTON_TEXT"]) || array_filter($arResult["FAQ"]["ITEMS"] ?? [])): ?>
            <section id="faq" class="section-new">
                <div class="container-new">
                    <?php if (!empty($arResult["FAQ"]["TITLE"])): ?>
                        <div class="section-new__header">
                            <h2 class="section-new__title">
                                <?= htmlspecialchars($arResult["FAQ"]["TITLE"]) ?>
                            </h2>
                        </div>
                    <?php endif; ?>

                    <div class="section-new__body">
                        <?php if (array_filter($arResult["FAQ"]["ITEMS"] ?? [])): ?>
                            <div class="faq-slider">
                                <div class="swiper" data-faq-slider>
                                    <div class="swiper-wrapper">
                                        <?php
                                        $faqCount = 0;
                                        for ($i = 1; $i <= 10; $i++):
                                            $faq = $arResult["FAQ"]["ITEMS"][$i] ?? [];
                                            if (!empty($faq["TITLE"]) && !empty($faq["CONTENT"])):
                                                $faqCount++;
                                                // Определяем CSS класс для скрытых слайдов (начиная с 4-го)
                                                $hiddenClass = $faqCount > 3 ? ' swiper-slide--hidden' : '';
                                                ?>
                                                <div class="swiper-slide<?= $hiddenClass ?>">
                                                    <div class="faq-tile">
                                                        <div class="faq-tile__badge">№<?= $faqCount ?></div>
                                                        <div class="faq-tile__title"><?= htmlspecialchars($faq["TITLE"]) ?></div>
                                                        <div class="faq-tile__subtitle">Ответ:</div>
                                                        <div class="faq-tile__descr">
                                                            <?= safeMixedContentOutput($faq["CONTENT"]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;
                                        endfor;
                                        ?>
                                    </div>
                                </div>

                                <div class="faq-slider__bottom">
                                    <div class="swiper-button-prev" data-faq-prev>
                                        <img src="/local/templates/front/frontend/dist/assets/img/prev.svg" alt="prev">
                                    </div>

                                    <div class="swiper-pagination" data-faq-pagination></div>

                                    <div class="swiper-button-next" data-faq-next>
                                        <img src="/local/templates/front/frontend/dist/assets/img/next.svg" alt="next">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($arResult["FAQ"]["MORE_BUTTON_TEXT"])): ?>
                            <button class="faq-more" type="button">
                                <?= htmlspecialchars($arResult["FAQ"]["MORE_BUTTON_TEXT"]) ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Slogan секция -->
        <?php if (!empty($arResult["SLOGAN"]["TITLE"])): ?>
            <section id="slogan" class="section-new">
                <div class="container-new">
                    <h2 class="slogan__title">
                        <?= safeHtmlOutputTitle($arResult["SLOGAN"]["TITLE"]) ?>
                    </h2>
                </div>
            </section>
        <?php endif; ?>

    </div>
</main>
