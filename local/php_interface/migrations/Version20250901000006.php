<?php

namespace Sprint\Migration;

class Version20250901000006 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Expertise секции главной страницы";

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

        // Создаем свойства для Expertise секции
        $this->createExpertiseProperties($helper, $iblockId);

        // Обновляем элемент значениями Expertise секции
        $this->updateElementWithExpertiseData($helper, $iblockId);
    }

    private function createExpertiseProperties($helper, $iblockId)
    {
        // Заголовок секции
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'EXPERTISE_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        // SEO блок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise SEO: Название',
            'ACTIVE' => 'Y',
            'SORT' => '510',
            'CODE' => 'EXPERTISE_SEO_NAME',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '50',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise SEO: Описание',
            'ACTIVE' => 'Y',
            'SORT' => '515',
            'CODE' => 'EXPERTISE_SEO_DESC',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '6',
            'COL_COUNT' => '75',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise SEO: Ссылка',
            'ACTIVE' => 'Y',
            'SORT' => '520',
            'CODE' => 'EXPERTISE_SEO_LINK',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '50',
        ));

        // Яндекс.Директ блок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise PPC: Название',
            'ACTIVE' => 'Y',
            'SORT' => '530',
            'CODE' => 'EXPERTISE_PPC_NAME',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '50',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise PPC: Описание',
            'ACTIVE' => 'Y',
            'SORT' => '535',
            'CODE' => 'EXPERTISE_PPC_DESC',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '4',
            'COL_COUNT' => '60',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise PPC: Ссылка',
            'ACTIVE' => 'Y',
            'SORT' => '540',
            'CODE' => 'EXPERTISE_PPC_LINK',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '50',
        ));

        // Разработка блок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise Dev: Название',
            'ACTIVE' => 'Y',
            'SORT' => '550',
            'CODE' => 'EXPERTISE_DEV_NAME',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '50',
            'HINT' => 'Поддерживает <br/> для переносов строк',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Expertise Dev: Описание',
            'ACTIVE' => 'Y',
            'SORT' => '555',
            'CODE' => 'EXPERTISE_DEV_DESC',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '4',
            'COL_COUNT' => '60',
        ));

        // Технологии
        $stacks = ['frontend', 'backend', 'qa'];
        $stackNames = [
            'frontend' => 'Frontend',
            'backend' => 'Backend',
            'qa' => 'QA'
        ];

        foreach ($stacks as $stack) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Expertise {$stackNames[$stack]}: Технологии",
                'ACTIVE' => 'Y',
                'SORT' => 560 + array_search($stack, $stacks) * 5,
                'CODE' => "EXPERTISE_STACK_" . strtoupper($stack),
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '2',
                'COL_COUNT' => '60',
                'HINT' => "Список технологий для {$stackNames[$stack]}",
            ));
        }
    }

    private function updateElementWithExpertiseData($helper, $iblockId)
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

            // Новые значения для Expertise секции
            $newValues = [
                'EXPERTISE_TITLE' => 'Экспертиза',
                'EXPERTISE_SEO_NAME' => 'Search Engine Optimization (SEO)',
                'EXPERTISE_SEO_DESC' => 'Предложу точки роста и эффективные решения по развитию проекта в канале Поисковые системы. Напишу план на квартал перед стартом работ. Семантическое проектирование сайта, работа с семантическим ядром, построение структуры, техническая внутренняя оптимизация, внешнее продвижение, переезд сайта.',
                'EXPERTISE_SEO_LINK' => '#',
                'EXPERTISE_PPC_NAME' => 'Реклама Яндекс.Директ',
                'EXPERTISE_PPC_DESC' => 'Глубокий анализ, релевантные объявления, исключение мусора, ретаргетинг и постоянная оптимизация.',
                'EXPERTISE_PPC_LINK' => '#',
                'EXPERTISE_DEV_NAME' => 'Разработка и<br/>поддержка сайтов',
                'EXPERTISE_DEV_DESC' => 'Помощь в организации разработки и поддержке сайтов. Для проектов без своей команды разработки.',

                'EXPERTISE_STACK_FRONTEND' => 'React, Vue, Angular, HTML, CSS',
                'EXPERTISE_STACK_BACKEND' => 'PHP (Yii2, Laravel, Symfony, 1С-Битрикс), Python, Wordpress, С#',
                'EXPERTISE_STACK_QA' => 'Manual/Auto (Python, Java)',
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
            'EXPERTISE_TITLE',
            'EXPERTISE_SEO_NAME',
            'EXPERTISE_SEO_DESC',
            'EXPERTISE_SEO_LINK',
            'EXPERTISE_PPC_NAME',
            'EXPERTISE_PPC_DESC',
            'EXPERTISE_PPC_LINK',
            'EXPERTISE_DEV_NAME',
            'EXPERTISE_DEV_DESC',
            'EXPERTISE_STACK_FRONTEND',
            'EXPERTISE_STACK_BACKEND',
            'EXPERTISE_STACK_QA',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}