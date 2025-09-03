<?php

namespace Sprint\Migration;

class Version20250901000009 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для FAQ секции главной страницы";

    protected $moduleVersion = "5.4.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        // Получаем ID инфоблока главной страницы
        $iblockId = $helper->Iblock()->getIblockIdIfExists('main_page', 'iblocks_for_main');

        if (!$iblockId) {
            throw new \Exception('Инфоблок main_page не найден. Сначала выполните миграцию Version20250901000001');
        }

        // Создаем свойства для FAQ секции
        $this->createFAQProperties($helper, $iblockId);

        // Обновляем элемент значениями FAQ секции
        $this->updateElementWithFAQData($helper, $iblockId);
    }

    private function createFAQProperties($helper, $iblockId)
    {
        // Заголовок секции FAQ
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'FAQ: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '900',
            'CODE' => 'FAQ_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        // Вопросы FAQ (10 вопросов)
        for ($i = 1; $i <= 10; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "FAQ: Вопрос {$i}",
                'ACTIVE' => 'Y',
                'SORT' => 905 + ($i * 10),
                'CODE' => "FAQ_QUESTION_{$i}",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '3',
                'COL_COUNT' => '60',
                'HINT' => "Заголовок {$i}-го вопроса в FAQ",
            ));

            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "FAQ: Ответ {$i}",
                'ACTIVE' => 'Y',
                'SORT' => 910 + ($i * 10),
                'CODE' => "FAQ_ANSWER_{$i}",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '10',
                'COL_COUNT' => '75',
                'HINT' => "Ответ на {$i}-й вопрос. Поддерживает <br/> для переносов. Каждый <br/> станет отдельным пунктом списка",
            ));
        }

        // Кнопка "Посмотреть больше"
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'FAQ: Текст кнопки "Посмотреть больше"',
            'ACTIVE' => 'Y',
            'SORT' => '1000',
            'CODE' => 'FAQ_MORE_BUTTON_TEXT',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));
    }

    private function updateElementWithFAQData($helper, $iblockId)
    {
        // Находим элемент для обновления
        $res = \CIBlockElement::GetList(
            ["SORT" => "ASC"],
            [
                "IBLOCK_ID" => $iblockId,
                "CODE" => "main_page_content"
            ]
        );

        if ($element = $res->GetNext()) {
            $elementId = $element['ID'];

            // Получаем существующие значения свойств
            $currentValues = [];
            $props = \CIBlockElement::GetProperty($iblockId, $elementId);
            while ($prop = $props->Fetch()) {
                if (!empty($prop['VALUE'])) {
                    $currentValues[$prop['CODE']] = $prop['VALUE'];
                }
            }

            // Новые значения для FAQ секции (тексты из статичного HTML)
            $newValues = [
                'FAQ_TITLE' => 'Частые вопросы',

                'FAQ_QUESTION_1' => 'Сколько времени нужно, чтобы увидеть результат?',
                'FAQ_ANSWER_1' => 'SEO: Первые сдвиги – через 3–6 месяцев (зависит от конкурентности ниши).<br/>Контекстная реклама: Трафик – с первого дня, но настройка и оптимизация занимают 1–3 месяца.<br/><br/>Что влияет на сроки: Возраст сайта, уровень конкуренции, бюджет, качество оптимизации.<br/><br/>Мы дадим реалистичные прогнозы и объясним этапы работы.',

                'FAQ_QUESTION_2' => 'Почему в топе конкуренты с худшим контентом/сайтом?',
                'FAQ_ANSWER_2' => 'Возможные причины:<br/>У них старые, «авторитетные» домены.<br/>Сильная бэклинк-история, даже если контент слабее, ссылки помогают занимать ТОП.<br/>Лучшая техническая оптимизация: скорость, микроразметка.<br/>Использование «серых» методов например, PBN-сети.',

                'FAQ_QUESTION_3' => 'Какой бюджет нужен для продвижения?',
                'FAQ_ANSWER_3' => 'SEO: От 30–60 тыс. руб./мес. для локального бизнеса и до 200–500 тыс. руб./мес. для высококонкурентных тематик/<br/>Контекст: Зависит от стоимости клика (СРС). Старт – от 20–50 тыс. руб./мес.<br/><br/>Что учесть: Аудит перед стартом, сезонность, тестирование гипотез.',

                'FAQ_QUESTION_4' => 'Какие гарантии вы даете?',
                'FAQ_ANSWER_4' => 'Проблема: Честные подрядчики не дают 100% гарантий вывода в ТОП так как алгоритмы поисковых систем постоянно меняются, совершенствуются.<br/><br/>Что можно гарантировать:<br/>Рост трафика (на X% за N месяцев)<br/>Увеличение конверсий (если работают CRO-м)',

                'FAQ_QUESTION_5' => 'Как вы отчитываетесь о работе?',
                'FAQ_ANSWER_5' => 'Примеры метрик:<br/>SEO: Позиции, трафик, динамика по согласованным KPI. Задачи ведутся в CRM с общим доступом всех участников проекта - полная прозрачность.<br/>Контекст: CTR, CPC, конверсии, ROI.<br/><br/>Формы отчетности:<br/>Google Data Studio, скриншоты из Google Analytics, таблицы с динамикой.<br/>Разбор изменений и планы на следующий месяц.',

                'FAQ_QUESTION_6' => 'Не навредите ли вы сайту?',
                'FAQ_ANSWER_6' => 'Риски:<br/>Некорректные правки (потеря трафика при редизайне).<br/>Переоптимизация (санкции за спам).<br/>Покупка «плохих» ссылок (пессимизация).<br/><br/>Как защититься:<br/>Проверить репутацию агентства (отзывы, кейсы).<br/>Резервные копии сайта перед изменениями.',

                'FAQ_QUESTION_7' => '«Почему упал трафик/позиции?» (если уже работают с подрядчиком)',
                'FAQ_ANSWER_7' => 'Возможные причины:<br/>Алгоритмные обновления (Google Core Update).<br/>Технические сбои (404 ошибки после обновления).<br/>Действия конкурентов.<br/><br/>Что требовать от подрядчика:<br/>Анализ причин (через Google Search Console, логи сервера).<br/>План восстановления.',

                'FAQ_QUESTION_8' => 'SEO или контекст – что лучше?',
                'FAQ_ANSWER_8' => 'Контекст:<br/>Быстрый трафик, но дорого в конкурентных нишах.<br/>Подходит для тестов и сезонных кампаний.<br/><br/>SEO:<br/>Долгий результат, но «бесплатный» трафик в перспективе.<br/>Лучше для масштабирования.<br/><br/>Комбинация (контекст – для быстрых продаж, SEO – для долгосрочного роста)',

                'FAQ_QUESTION_9' => 'Как вы выбираете ключевые слова?',
                'FAQ_ANSWER_9' => 'Критерии:<br/>Частотность (высоко-, средне-, низкочастотники).<br/>Конкурентность.<br/>Коммерческий потенциал («купить» vs «как выбрать»).<br/><br/>Инструменты: Key Collector, SEMrush, Google Keyword Planner.<br/><br/>Запросы должны соответствовать этапу воронки.',

                'FAQ_QUESTION_10' => 'Можно ли сэкономить на продвижении?',
                'FAQ_ANSWER_10' => 'Риски «дешевого» SEO:<br/>Низкокачественные ссылки.<br/>Шаблонные тексты.<br/>Отсутствие аналитики.<br/><br/>Как оптимизировать бюджет<br/>Фокус на низкочастотных запросах.<br/>Упор на контент-маркетинг (блог, гайды).<br/>Постепенное масштабирование.',

                'FAQ_MORE_BUTTON_TEXT' => 'Посмотреть больше',
            ];

            // Мерджим существующие значения с новыми
            $propertyValues = array_merge($currentValues, $newValues);

            \CIBlockElement::SetPropertyValues($elementId, $iblockId, $propertyValues);
        }
    }

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function down()
    {
        $helper = $this->getHelperManager();

        // Получаем ID инфоблока
        $iblockId = $helper->Iblock()->getIblockIdIfExists('main_page', 'iblocks_for_main');

        if (!$iblockId) {
            return;
        }

        // Список кодов свойств для удаления
        $propertiesToDelete = [
            'FAQ_TITLE',
            'FAQ_QUESTION_1', 'FAQ_ANSWER_1', 'FAQ_QUESTION_2', 'FAQ_ANSWER_2',
            'FAQ_QUESTION_3', 'FAQ_ANSWER_3', 'FAQ_QUESTION_4', 'FAQ_ANSWER_4',
            'FAQ_QUESTION_5', 'FAQ_ANSWER_5', 'FAQ_QUESTION_6', 'FAQ_ANSWER_6',
            'FAQ_QUESTION_7', 'FAQ_ANSWER_7', 'FAQ_QUESTION_8', 'FAQ_ANSWER_8',
            'FAQ_QUESTION_9', 'FAQ_ANSWER_9', 'FAQ_QUESTION_10', 'FAQ_ANSWER_10',
            'FAQ_MORE_BUTTON_TEXT',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}