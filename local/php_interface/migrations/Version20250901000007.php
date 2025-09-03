<?php

namespace Sprint\Migration;

class Version20250901000007 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Methodology секции главной страницы";

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

        // Создаем свойства для Methodology секции
        $this->createMethodologyProperties($helper, $iblockId);

        // Обновляем элемент значениями Methodology секции
        $this->updateElementWithMethodologyData($helper, $iblockId);
    }

    private function createMethodologyProperties($helper, $iblockId)
    {
        // Общий заголовок секции
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '600',
            'CODE' => 'METHODOLOGY_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '50',
            'HINT' => 'Заголовок секции "Методология продвижения"',
        ));

        // Создаем все 4 таба
        $this->createSEOTab($helper, $iblockId);
        $this->createPPCTab($helper, $iblockId);
        $this->createCombinedTab($helper, $iblockId);
        $this->createAdditionalTab($helper, $iblockId);
    }

    private function createSEOTab($helper, $iblockId)
    {
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology SEO: Заголовок',
            'ACTIVE' => 'Y',
            'SORT' => '610',
            'CODE' => 'METHODOLOGY_SEO_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '50',
            'HINT' => 'Поддерживает <br/> для переносов строк',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology SEO: Подзаголовок',
            'ACTIVE' => 'Y',
            'SORT' => '615',
            'CODE' => 'METHODOLOGY_SEO_SUBTITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
        ));

        // Аккордеоны SEO (4 блока)
        for ($i = 1; $i <= 4; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology SEO: Аккордеон {$i} - Заголовок",
                'ACTIVE' => 'Y',
                'SORT' => 620 + ($i * 5),
                'CODE' => "METHODOLOGY_SEO_ACCORDION_{$i}_TITLE",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '50',
            ));

            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology SEO: Аккордеон {$i} - Контент",
                'ACTIVE' => 'Y',
                'SORT' => 625 + ($i * 5),
                'CODE' => "METHODOLOGY_SEO_ACCORDION_{$i}_CONTENT",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '10',
                'COL_COUNT' => '75',
                'HINT' => 'Поддерживает <br/> для переносов. Каждый <br/> станет отдельным пунктом списка',
            ));
        }
    }

    private function createPPCTab($helper, $iblockId)
    {
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology PPC: Заголовок',
            'ACTIVE' => 'Y',
            'SORT' => '650',
            'CODE' => 'METHODOLOGY_PPC_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Поддерживает <br/> для переносов строк',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology PPC: Подзаголовок',
            'ACTIVE' => 'Y',
            'SORT' => '655',
            'CODE' => 'METHODOLOGY_PPC_SUBTITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
        ));

        // Аккордеоны PPC (4 блока)
        for ($i = 1; $i <= 4; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology PPC: Аккордеон {$i} - Заголовок",
                'ACTIVE' => 'Y',
                'SORT' => 660 + ($i * 5),
                'CODE' => "METHODOLOGY_PPC_ACCORDION_{$i}_TITLE",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '50',
            ));

            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology PPC: Аккордеон {$i} - Контент",
                'ACTIVE' => 'Y',
                'SORT' => 665 + ($i * 5),
                'CODE' => "METHODOLOGY_PPC_ACCORDION_{$i}_CONTENT",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '10',
                'COL_COUNT' => '75',
                'HINT' => 'Поддерживает <br/> для переносов. Каждый <br/> станет отдельным пунктом списка',
            ));
        }
    }

    private function createCombinedTab($helper, $iblockId)
    {
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology Combined: Заголовок',
            'ACTIVE' => 'Y',
            'SORT' => '690',
            'CODE' => 'METHODOLOGY_COMBINED_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Поддерживает <br/> для переносов строк',
        ));

        // Аккордеоны Combined (4 блока)
        for ($i = 1; $i <= 4; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology Combined: Аккордеон {$i} - Заголовок",
                'ACTIVE' => 'Y',
                'SORT' => 695 + ($i * 5),
                'CODE' => "METHODOLOGY_COMBINED_ACCORDION_{$i}_TITLE",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '50',
            ));

            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology Combined: Аккордеон {$i} - Контент",
                'ACTIVE' => 'Y',
                'SORT' => 700 + ($i * 5),
                'CODE' => "METHODOLOGY_COMBINED_ACCORDION_{$i}_CONTENT",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '10',
                'COL_COUNT' => '75',
                'HINT' => 'Поддерживает <br/> для переносов. Каждый <br/> станет отдельным пунктом списка',
            ));
        }
    }

    private function createAdditionalTab($helper, $iblockId)
    {
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Methodology Additional: Заголовок',
            'ACTIVE' => 'Y',
            'SORT' => '720',
            'CODE' => 'METHODOLOGY_ADDITIONAL_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Поддерживает <br/> для переносов строк',
        ));

        // Аккордеоны Additional (3 блока)
        for ($i = 1; $i <= 3; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology Additional: Аккордеон {$i} - Заголовок",
                'ACTIVE' => 'Y',
                'SORT' => 725 + ($i * 5),
                'CODE' => "METHODOLOGY_ADDITIONAL_ACCORDION_{$i}_TITLE",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '2',
                'COL_COUNT' => '60',
            ));

            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Methodology Additional: Аккордеон {$i} - Контент",
                'ACTIVE' => 'Y',
                'SORT' => 730 + ($i * 5),
                'CODE' => "METHODOLOGY_ADDITIONAL_ACCORDION_{$i}_CONTENT",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '10',
                'COL_COUNT' => '75',
                'HINT' => 'Поддерживает <br/> для переносов. Каждый <br/> станет отдельным пунктом списка',
            ));
        }
    }

    private function updateElementWithMethodologyData($helper, $iblockId)
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

            // Новые значения для Methodology секции
            $newValues = [
                // Methodology
                'METHODOLOGY_TITLE' => 'Методология продвижения',

                // SEO таб
                'METHODOLOGY_SEO_TITLE' => 'SEO (Search Engine Optimization)',
                'METHODOLOGY_SEO_SUBTITLE' => 'Оптимизация сайта для органического роста в канале Поисковые системы (в отчёте Яндекс Метрика)',

                'METHODOLOGY_SEO_ACCORDION_1_TITLE' => 'Основные методы',
                'METHODOLOGY_SEO_ACCORDION_1_CONTENT' => 'Техническое SEO (задачи разработки по нашим ТЗ)<br/>Ускорение загрузки: кэширование, оптимизация изображений по весу, CDN.<br/>Корректная индексация: robots.txt, sitemap.xml, управление Вебмастером Яндекс и Google Search Console.<br/>Адаптивность под мобильные устройства.<br/>Исправление ошибок: битые ссылки, дубли страниц, ошибки 404, базовые редиректы 301.',

                'METHODOLOGY_SEO_ACCORDION_2_TITLE' => 'Внутренняя оптимизация',
                'METHODOLOGY_SEO_ACCORDION_2_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_SEO_ACCORDION_3_TITLE' => 'Внешняя оптимизация (линкбилдинг)',
                'METHODOLOGY_SEO_ACCORDION_3_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_SEO_ACCORDION_4_TITLE' => 'Локальное SEO для бизнеса',
                'METHODOLOGY_SEO_ACCORDION_4_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                // PPC таб
                'METHODOLOGY_PPC_TITLE' => 'Контекстная реклама<br/>(PPC – Pay Per Click)',
                'METHODOLOGY_PPC_SUBTITLE' => 'Платное продвижение через рекламные системы Google Ads (временно отключено для России), Яндекс.Директ.',

                'METHODOLOGY_PPC_ACCORDION_1_TITLE' => 'Основные методы',
                'METHODOLOGY_PPC_ACCORDION_1_CONTENT' => 'Техническое SEO (задачи разработки по нашим ТЗ)<br/>Ускорение загрузки: кэширование, оптимизация изображений по весу, CDN.<br/>Корректная индексация: robots.txt, sitemap.xml, управление Вебмастером Яндекс и Google Search Console.<br/>Адаптивность под мобильные устройства.<br/>Исправление ошибок: битые ссылки, дубли страниц, ошибки 404, базовые редиректы 301.',

                'METHODOLOGY_PPC_ACCORDION_2_TITLE' => 'РСЯ (Рекламная сеть Яндекса) и КМС',
                'METHODOLOGY_PPC_ACCORDION_2_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_PPC_ACCORDION_3_TITLE' => 'Smart-кампании',
                'METHODOLOGY_PPC_ACCORDION_3_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_PPC_ACCORDION_4_TITLE' => 'Видеореклама (VK-видео, Rutube)',
                'METHODOLOGY_PPC_ACCORDION_4_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                // Combined таб
                'METHODOLOGY_COMBINED_TITLE' => 'Комбинированные<br/>стратегии SEO + Контекст',

                'METHODOLOGY_COMBINED_ACCORDION_1_TITLE' => 'Воронка трафика',
                'METHODOLOGY_COMBINED_ACCORDION_1_CONTENT' => 'Техническое SEO (задачи разработки по нашим ТЗ)<br/>Ускорение загрузки: кэширование, оптимизация изображений по весу, CDN.<br/>Корректная индексация: robots.txt, sitemap.xml, управление Вебмастером Яндекс и Google Search Console.<br/>Адаптивность под мобильные устройства.<br/>Исправление ошибок: битые ссылки, дубли страниц, ошибки 404, базовые редиректы 301.',

                'METHODOLOGY_COMBINED_ACCORDION_2_TITLE' => 'Ретаргетинг + SEO',
                'METHODOLOGY_COMBINED_ACCORDION_2_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_COMBINED_ACCORDION_3_TITLE' => 'Анализ ключевых слов',
                'METHODOLOGY_COMBINED_ACCORDION_3_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_COMBINED_ACCORDION_4_TITLE' => 'Ускорение индексации',
                'METHODOLOGY_COMBINED_ACCORDION_4_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                // Additional таб
                'METHODOLOGY_ADDITIONAL_TITLE' => 'Дополнительные<br/>инструменты',

                'METHODOLOGY_ADDITIONAL_ACCORDION_1_TITLE' => 'SEO + Content Marketing – создание полезного контента: блоги, гайды, FAQ.',
                'METHODOLOGY_ADDITIONAL_ACCORDION_1_CONTENT' => 'Техническое SEO (задачи разработки по нашим ТЗ)<br/>Ускорение загрузки: кэширование, оптимизация изображений по весу, CDN.<br/>Корректная индексация: robots.txt, sitemap.xml, управление Вебмастером Яндекс и Google Search Console.<br/>Адаптивность под мобильные устройства.<br/>Исправление ошибок: битые ссылки, дубли страниц, ошибки 404, базовые редиректы 301.',

                'METHODOLOGY_ADDITIONAL_ACCORDION_2_TITLE' => 'SEO + SMM – продвижение через соцсети, увеличение цитируемости',
                'METHODOLOGY_ADDITIONAL_ACCORDION_2_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',

                'METHODOLOGY_ADDITIONAL_ACCORDION_3_TITLE' => 'SEO + CRO (Conversion Rate Optimization) – улучшение юзабилити и конверсии.',
                'METHODOLOGY_ADDITIONAL_ACCORDION_3_CONTENT' => 'Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности способствует подготовки и реализации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации направлений прогрессивного развития.<br/><br/>Повседневная практика показывает, что рамки и место обучения кадров играет важную роль в формировании новых предложений. Задача организации, в особенности же реализация намеченных плановых заданий позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.',
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
            // Methodology
            'METHODOLOGY_TITLE',
            // SEO
            'METHODOLOGY_SEO_TITLE', 'METHODOLOGY_SEO_SUBTITLE',
            'METHODOLOGY_SEO_ACCORDION_1_TITLE', 'METHODOLOGY_SEO_ACCORDION_1_CONTENT',
            'METHODOLOGY_SEO_ACCORDION_2_TITLE', 'METHODOLOGY_SEO_ACCORDION_2_CONTENT',
            'METHODOLOGY_SEO_ACCORDION_3_TITLE', 'METHODOLOGY_SEO_ACCORDION_3_CONTENT',
            'METHODOLOGY_SEO_ACCORDION_4_TITLE', 'METHODOLOGY_SEO_ACCORDION_4_CONTENT',
            // PPC
            'METHODOLOGY_PPC_TITLE', 'METHODOLOGY_PPC_SUBTITLE',
            'METHODOLOGY_PPC_ACCORDION_1_TITLE', 'METHODOLOGY_PPC_ACCORDION_1_CONTENT',
            'METHODOLOGY_PPC_ACCORDION_2_TITLE', 'METHODOLOGY_PPC_ACCORDION_2_CONTENT',
            'METHODOLOGY_PPC_ACCORDION_3_TITLE', 'METHODOLOGY_PPC_ACCORDION_3_CONTENT',
            'METHODOLOGY_PPC_ACCORDION_4_TITLE', 'METHODOLOGY_PPC_ACCORDION_4_CONTENT',
            // Combined
            'METHODOLOGY_COMBINED_TITLE',
            'METHODOLOGY_COMBINED_ACCORDION_1_TITLE', 'METHODOLOGY_COMBINED_ACCORDION_1_CONTENT',
            'METHODOLOGY_COMBINED_ACCORDION_2_TITLE', 'METHODOLOGY_COMBINED_ACCORDION_2_CONTENT',
            'METHODOLOGY_COMBINED_ACCORDION_3_TITLE', 'METHODOLOGY_COMBINED_ACCORDION_3_CONTENT',
            'METHODOLOGY_COMBINED_ACCORDION_4_TITLE', 'METHODOLOGY_COMBINED_ACCORDION_4_CONTENT',
            // Additional
            'METHODOLOGY_ADDITIONAL_TITLE',
            'METHODOLOGY_ADDITIONAL_ACCORDION_1_TITLE', 'METHODOLOGY_ADDITIONAL_ACCORDION_1_CONTENT',
            'METHODOLOGY_ADDITIONAL_ACCORDION_2_TITLE', 'METHODOLOGY_ADDITIONAL_ACCORDION_2_CONTENT',
            'METHODOLOGY_ADDITIONAL_ACCORDION_3_TITLE', 'METHODOLOGY_ADDITIONAL_ACCORDION_3_CONTENT',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}