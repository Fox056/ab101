<?php

namespace Sprint\Migration;

class Version20250901000008 extends Version
{
    protected $author = "developer";

    protected $description = "Добавление свойств для Starting секции главной страницы";

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

        // Создаем свойства для Starting секции
        $this->createStartingProperties($helper, $iblockId);

        // Обновляем элемент значениями Starting секции
        $this->updateElementWithStartingData($helper, $iblockId);
    }

    private function createStartingProperties($helper, $iblockId)
    {
        // Заголовок секции
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Starting: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '800',
            'CODE' => 'STARTING_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        // Описание процесса
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Starting: Описание процесса',
            'ACTIVE' => 'Y',
            'SORT' => '810',
            'CODE' => 'STARTING_DESCRIPTION',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
            'HINT' => 'Поддерживает <br/> для переносов строк',
        ));

        // Шаги процесса (6 шагов)
        for ($i = 1; $i <= 6; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Starting: Шаг {$i} - Номер",
                'ACTIVE' => 'Y',
                'SORT' => 815 + ($i * 10),
                'CODE' => "STARTING_STEP_{$i}_NUMBER",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '20',
                'HINT' => "Номер шага (например: '1 шаг')",
            ));

            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Starting: Шаг {$i} - Описание",
                'ACTIVE' => 'Y',
                'SORT' => 820 + ($i * 10),
                'CODE' => "STARTING_STEP_{$i}_TEXT",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '4',
                'COL_COUNT' => '60',
                'HINT' => "Описание {$i}-го шага процесса",
            ));
        }

        // Форма
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Starting: Заголовок формы',
            'ACTIVE' => 'Y',
            'SORT' => '890',
            'CODE' => 'STARTING_FORM_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '50',
        ));
    }

    private function updateElementWithStartingData($helper, $iblockId)
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

            // Новые значения для Starting секции
            $newValues = [
                'STARTING_TITLE' => 'Стартуем?',
                'STARTING_DESCRIPTION' => 'Процесс знакомства поможет найти точки интереса обеим сторонам<br/>для роста вашего проекта.',

                'STARTING_STEP_1_NUMBER' => '1 шаг',
                'STARTING_STEP_1_TEXT' => 'Заполните форму обратной связи. Опишите вашу ситуацию кратко и ваши ожидания от работы. Отправьте её нажав "Отправить".',

                'STARTING_STEP_2_NUMBER' => '2 шаг',
                'STARTING_STEP_2_TEXT' => 'Мы изучим ваш сайт и нишу в целом. Сделаем краткий аудит и постараемся найти точки роста для дальнейшего обсуждения.',

                'STARTING_STEP_3_NUMBER' => '3 шаг',
                'STARTING_STEP_3_TEXT' => 'Ответным письмом, в удобном для вас способом, пришлём краткую информацию о нашем видении развития. Укажим примерный бюджет для старта работ.',

                'STARTING_STEP_4_NUMBER' => '4 шаг',
                'STARTING_STEP_4_TEXT' => 'Договоримся о встрече. Встретимся. Поговорим устно о проекте о ваших KPI, болях проекта.',

                'STARTING_STEP_5_NUMBER' => '5 шаг',
                'STARTING_STEP_5_TEXT' => 'Если встреча пройдёт успешно, то напишем предварительный план развития на квартал с более понятными действиями и бюджетами.',

                'STARTING_STEP_6_NUMBER' => '6 шаг',
                'STARTING_STEP_6_TEXT' => 'Если всё устраивает, то подписываем договор и начинаем работу над развитием проекта.',

                'STARTING_FORM_TITLE' => 'Заполните форму обратной связи',
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
            'STARTING_TITLE',
            'STARTING_DESCRIPTION',
            'STARTING_STEP_1_NUMBER',
            'STARTING_STEP_1_TEXT',
            'STARTING_STEP_2_NUMBER',
            'STARTING_STEP_2_TEXT',
            'STARTING_STEP_3_NUMBER',
            'STARTING_STEP_3_TEXT',
            'STARTING_STEP_4_NUMBER',
            'STARTING_STEP_4_TEXT',
            'STARTING_STEP_5_NUMBER',
            'STARTING_STEP_5_TEXT',
            'STARTING_STEP_6_NUMBER',
            'STARTING_STEP_6_TEXT',
            'STARTING_FORM_TITLE',
        ];

        foreach ($propertiesToDelete as $code) {
            $helper->Iblock()->deletePropertyIfExists($iblockId, $code);
        }
    }
}