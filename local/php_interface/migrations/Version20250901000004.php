<?php

namespace Sprint\Migration;

class Version20250901000004 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Attract секции главной страницы";

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

        // Создаем свойства для Attract секции
        $this->createAttractProperties($helper, $iblockId);

        // Обновляем элемент значениями Attract секции
        $this->updateElementWithAttractData($helper, $iblockId);
    }

    private function createAttractProperties($helper, $iblockId)
    {
        // Attract: Заголовок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Attract: Заголовок',
            'ACTIVE' => 'Y',
            'SORT' => '300',
            'CODE' => 'ATTRACT_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Заголовок секции привлечения клиентов. Поддерживает <br/> для переносов',
        ));

        // Attract: Подзаголовок
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Attract: Подзаголовок',
            'ACTIVE' => 'Y',
            'SORT' => '310',
            'CODE' => 'ATTRACT_SUBTITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
            'HINT' => 'Описание поисковых систем',
        ));
    }

    private function updateElementWithAttractData($helper, $iblockId)
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

            // Новые значения для Attract секции
            $newValues = [
                'ATTRACT_TITLE' => 'Привлекайте целевых<br/>клиентов из поиска!',
                'ATTRACT_SUBTITLE' => 'Яндекс, Google и AI-ассистентов (ChatGPT, Gemini, Поиск Нейро в Яндекс и др.)',
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
            'ATTRACT_TITLE',
            'ATTRACT_SUBTITLE',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}