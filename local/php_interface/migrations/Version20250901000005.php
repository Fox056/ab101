<?php

namespace Sprint\Migration;

class Version20250901000005 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Cases секции главной страницы";

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

        // Создаем свойства для Cases секции
        $this->createCasesProperties($helper, $iblockId);

        // Обновляем элемент значениями Cases секции
        $this->updateElementWithCasesData($helper, $iblockId);
    }

    private function createCasesProperties($helper, $iblockId)
    {
        // Cases: Заголовок секции (кейсы статичные)
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Cases: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '400',
            'CODE' => 'CASES_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'HINT' => 'Заголовок секции с кейсами',
        ));

        // Cases: Описание секции
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Cases: Описание секции',
            'ACTIVE' => 'Y',
            'SORT' => '410',
            'CODE' => 'CASES_DESCRIPTION',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
            'HINT' => 'Описание под заголовком кейсов. Поддерживает <br/> для переносов',
        ));
    }

    private function updateElementWithCasesData($helper, $iblockId)
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

            // Новые значения для Cases секции
            $newValues = [
                'CASES_TITLE' => 'Кейсы',
                'CASES_DESCRIPTION' => 'Выстраиваю долгосрочные доверительные отношения<br/>с клиентами, срок сотрудничества более 2-х лет',
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
            'CASES_TITLE',
            'CASES_DESCRIPTION',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}