<?php

namespace Sprint\Migration;

class Version20250901000002 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Welcome секции главной страницы";

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

        // Создаем свойства для Welcome секции
        $this->createWelcomeProperties($helper, $iblockId);

        // Обновляем элемент значениями Welcome секции
        $this->updateElementWithWelcomeData($helper, $iblockId);
    }

    private function createWelcomeProperties($helper, $iblockId)
    {
        // Welcome: Заголовок H1
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Welcome: Заголовок H1',
            'ACTIVE' => 'Y',
            'SORT' => '100',
            'CODE' => 'WELCOME_TITLE',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => NULL,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => NULL,
            'USER_TYPE_SETTINGS' => NULL,
            'HINT' => 'Главный заголовок в welcome секции. Поддерживает <br/> для переносов',
        ));

        // Welcome: Подзаголовок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Welcome: Подзаголовок',
            'ACTIVE' => 'Y',
            'SORT' => '110',
            'CODE' => 'WELCOME_SUBTITLE',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'HINT' => 'Описание под заголовком',
        ));

        // Welcome: Ссылка на Telegram
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Welcome: Ссылка на Telegram',
            'ACTIVE' => 'Y',
            'SORT' => '120',
            'CODE' => 'WELCOME_TELEGRAM_URL',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
            'HINT' => 'URL для кнопки "Написать в Телеграм"',
        ));

        // Преимущества (3 блока)
        for ($i = 1; $i <= 3; $i++) {
            // Заголовок преимущества
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Welcome: Преимущество {$i} - Заголовок",
                'ACTIVE' => 'Y',
                'SORT' => 120 + ($i * 10),
                'CODE' => "WELCOME_ADVANTAGE_{$i}_TITLE",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '2',
                'COL_COUNT' => '60',
                'HINT' => "Заголовок {$i}-го блока преимуществ",
            ));

            // Текст преимущества
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Welcome: Преимущество {$i} - Текст",
                'ACTIVE' => 'Y',
                'SORT' => 125 + ($i * 10),
                'CODE' => "WELCOME_ADVANTAGE_{$i}_TEXT",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '4',
                'COL_COUNT' => '60',
                'HINT' => "Описание {$i}-го преимущества",
            ));
        }
    }

    private function updateElementWithWelcomeData($helper, $iblockId)
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

            // Новые значения для Welcome секции
            $newValues = [
                'WELCOME_TITLE' => 'Рост ваших продаж<br/>- наш главный KPI',
                'WELCOME_SUBTITLE' => 'Продвижение сайтов для компаний, которые ценят прозрачность, скорость и измеримый результат',
                'WELCOME_TELEGRAM_URL' => 'https://t.me/durov',

                'WELCOME_ADVANTAGE_1_TITLE' => 'Глубокое погружение в ваш проект с фокусом на рост заявок и продаж.',
                'WELCOME_ADVANTAGE_1_TEXT' => 'Мы работаем как партнер, а не подрядчик: изучаем рынок, продукт и воронку продаж, чтобы приносить измеримую прибыль.',

                'WELCOME_ADVANTAGE_2_TITLE' => 'Мгновенные коммуникации',
                'WELCOME_ADVANTAGE_2_TEXT' => 'Никаких задержек в коммуникации, только четкие действия и быстрые качественные решения.',

                'WELCOME_ADVANTAGE_3_TITLE' => 'Экспертиза',
                'WELCOME_ADVANTAGE_3_TEXT' => 'Знаем, как продавать сложные продукты и услуги клиентам.',
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
            'WELCOME_TITLE',
            'WELCOME_SUBTITLE',
            'WELCOME_TELEGRAM_URL',
            'WELCOME_ADVANTAGE_1_TITLE',
            'WELCOME_ADVANTAGE_1_TEXT',
            'WELCOME_ADVANTAGE_2_TITLE',
            'WELCOME_ADVANTAGE_2_TEXT',
            'WELCOME_ADVANTAGE_3_TITLE',
            'WELCOME_ADVANTAGE_3_TEXT',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}