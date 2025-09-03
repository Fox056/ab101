<?php

namespace Sprint\Migration;

class Version20250901000003 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Complex секции главной страницы";

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

        // Создаем свойства для Complex секции
        $this->createComplexProperties($helper, $iblockId);

        // Обновляем элемент значениями Complex секции
        $this->updateElementWithComplexData($helper, $iblockId);
    }

    private function createComplexProperties($helper, $iblockId)
    {
        // Complex: Заголовок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Complex: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '200',
            'CODE' => 'COMPLEX_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Заголовок секции "Комплексные решения". Поддерживает <br/> для переносов',
        ));

        // Complex: Вводный текст
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Complex: Вводный текст',
            'ACTIVE' => 'Y',
            'SORT' => '210',
            'CODE' => 'COMPLEX_INTRO',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '4',
            'COL_COUNT' => '60',
            'HINT' => 'Описание перед списком преимуществ',
        ));

        // Список "Вы получаете" (4 пункта)
        for ($i = 1; $i <= 4; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Complex: Пункт списка {$i}",
                'ACTIVE' => 'Y',
                'SORT' => 215 + $i,
                'CODE' => "COMPLEX_LIST_ITEM_{$i}",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '3',
                'COL_COUNT' => '60',
                'HINT' => "Пункт {$i} в списке 'Вы получаете'",
            ));
        }

        // Complex: Подзаголовок внизу
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Complex: Подзаголовок внизу',
            'ACTIVE' => 'Y',
            'SORT' => '220',
            'CODE' => 'COMPLEX_SUBTITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Финальный текст секции',
        ));
    }

    private function updateElementWithComplexData($helper, $iblockId)
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

            // Новые значения для Complex секции
            $newValues = [
                'COMPLEX_TITLE' => 'Комплексные решения<br/> для роста вашего бизнеса',
                'COMPLEX_INTRO' => 'Мы помогаем компаниям увеличивать продажи и узнаваемость продукта/бренда через поисковое продвижение. На любом этапе развития вашего проекта — от запуска до масштабирования.',

                'COMPLEX_LIST_ITEM_1' => 'Стратегию, которая учитывает специфику вашего бизнеса и конкурентов.',
                'COMPLEX_LIST_ITEM_2' => 'Глубокую оптимизацию под алгоритмы поисковых систем и AI-чатботов.',
                'COMPLEX_LIST_ITEM_3' => 'Реальные результаты: рост позиций, трафика, конверсий, продаж.',
                'COMPLEX_LIST_ITEM_4' => 'Никаких аккаунт-менеджеров - вы общаетесь напрямую со спецом проекта.',

                'COMPLEX_SUBTITLE' => 'Работаем с проектами любого масштаба — от локального бизнеса до федеральных брендов.',
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
            'COMPLEX_TITLE',
            'COMPLEX_INTRO',
            'COMPLEX_LIST_ITEM_1',
            'COMPLEX_LIST_ITEM_2',
            'COMPLEX_LIST_ITEM_3',
            'COMPLEX_LIST_ITEM_4',
            'COMPLEX_SUBTITLE',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}