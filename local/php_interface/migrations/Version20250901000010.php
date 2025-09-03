<?php

namespace Sprint\Migration;

class Version20250901000010 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Slogan секции главной страницы";

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

        // Создаем свойства для Slogan секции
        $this->createSloganProperties($helper, $iblockId);

        // Обновляем элемент значениями Slogan секции
        $this->updateElementWithSloganData($helper, $iblockId);
    }

    private function createSloganProperties($helper, $iblockId)
    {
        // Slogan: Финальный призыв
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Slogan: Финальный призыв',
            'ACTIVE' => 'Y',
            'SORT' => '1100',
            'CODE' => 'SLOGAN_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
            'HINT' => 'Финальный призыв к действию. Поддерживает <br/> для переносов строк',
        ));
    }

    private function updateElementWithSloganData($helper, $iblockId)
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

            // Новые значения для Slogan секции (текст из статичного HTML)
            $newValues = [
                'SLOGAN_TITLE' => 'Лидеры вашего рынка уже<br/>занимают ТОП. Сделаем вместе так,<br/>чтобы следующий был ваш проект!',
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
            'SLOGAN_TITLE',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}