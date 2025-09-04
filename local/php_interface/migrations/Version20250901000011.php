<?php

namespace Sprint\Migration;

class Version20250901000011 extends Version
{
    protected $author = "developer";

    protected $description = "Создание инфоблока для страницы контактов";

    protected $moduleVersion = "5.4.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        // Создаем инфоблок для страницы контактов
        $iblockId = $helper->Iblock()->saveIblock(array(
            'IBLOCK_TYPE_ID' => 'iblocks_for_main',
            'LID' => array('s1'),
            'CODE' => 'contacts_page',
            'API_CODE' => 'contactspage',
            'REST_ON' => 'N',
            'NAME' => 'Страница контактов',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'LIST_PAGE_URL' => '',
            'DETAIL_PAGE_URL' => '',
            'SECTION_PAGE_URL' => '',
            'CANONICAL_PAGE_URL' => '',
            'PICTURE' => NULL,
            'DESCRIPTION' => 'Управление контентом страницы контактов',
            'DESCRIPTION_TYPE' => 'text',
            'RSS_TTL' => '24',
            'RSS_ACTIVE' => 'Y',
            'RSS_FILE_ACTIVE' => 'N',
            'RSS_FILE_LIMIT' => NULL,
            'RSS_FILE_DAYS' => NULL,
            'RSS_YANDEX_ACTIVE' => 'N',
            'XML_ID' => NULL,
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'N',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'LIST_MODE' => '',
            'RIGHTS_MODE' => 'S',
            'SECTION_PROPERTY' => 'N',
            'PROPERTY_INDEX' => 'N',
            'VERSION' => '1',
            'LAST_CONV_ELEMENT' => '0',
            'SOCNET_GROUP_ID' => NULL,
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Контент',
            'ELEMENT_NAME' => 'Блок контента',
            'FULLTEXT_INDEX' => 'N',
            'EXTERNAL_ID' => NULL,
            'LANG_DIR' => '/',
            'IPROPERTY_TEMPLATES' => array(),
            'ELEMENT_ADD' => 'Добавить блок',
            'ELEMENT_EDIT' => 'Изменить блок',
            'ELEMENT_DELETE' => 'Удалить блок',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
        ));

        // Настраиваем поля инфоблока
        $helper->Iblock()->saveIblockFields($iblockId, array(
            'ACTIVE' => array(
                'NAME' => 'Активность',
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => 'Y',
                'VISIBLE' => 'Y',
            ),
            'NAME' => array(
                'NAME' => 'Название',
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => '',
                'VISIBLE' => 'Y',
            ),
            'CODE' => array(
                'NAME' => 'Символьный код',
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => array(
                    'UNIQUE' => 'Y',
                    'TRANSLITERATION' => 'Y',
                    'TRANS_LEN' => 100,
                    'TRANS_CASE' => 'L',
                    'TRANS_SPACE' => '-',
                    'TRANS_OTHER' => '-',
                    'TRANS_EAT' => 'Y',
                    'USE_GOOGLE' => 'N',
                ),
                'VISIBLE' => 'Y',
            ),
        ));

        // Создаем свойства для секций
        $this->createContactsProperties($helper, $iblockId);

        // Настраиваем права доступа
        $helper->Iblock()->saveGroupPermissions($iblockId, array(
            'administrators' => 'X',
            'everyone' => 'R',
        ));

        // Создаем базовый элемент с данными
        $this->createContactsElement($helper, $iblockId);
    }

    private function createContactsProperties($helper, $iblockId)
    {
        // === Секция приветствия ===
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Contacts Welcome: Заголовок страницы',
            'ACTIVE' => 'Y',
            'SORT' => '100',
            'CODE' => 'CONTACTS_WELCOME_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
        ));

        // === Секция SEO контактов ===
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'SEO: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '200',
            'CODE' => 'SEO_SECTION_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'SEO: Телефон',
            'ACTIVE' => 'Y',
            'SORT' => '210',
            'CODE' => 'SEO_PHONE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'SEO: Ссылка на телефон',
            'ACTIVE' => 'Y',
            'SORT' => '220',
            'CODE' => 'SEO_PHONE_LINK',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'SEO: Telegram',
            'ACTIVE' => 'Y',
            'SORT' => '230',
            'CODE' => 'SEO_TELEGRAM',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'SEO: Ссылка на Telegram',
            'ACTIVE' => 'Y',
            'SORT' => '240',
            'CODE' => 'SEO_TELEGRAM_LINK',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
        ));

        // === Секция Яндекс.Директ контактов ===
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Директ: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '300',
            'CODE' => 'DIRECT_SECTION_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '2',
            'COL_COUNT' => '60',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Директ: Телефон',
            'ACTIVE' => 'Y',
            'SORT' => '310',
            'CODE' => 'DIRECT_PHONE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Директ: Ссылка на телефон',
            'ACTIVE' => 'Y',
            'SORT' => '320',
            'CODE' => 'DIRECT_PHONE_LINK',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Директ: Telegram',
            'ACTIVE' => 'Y',
            'SORT' => '330',
            'CODE' => 'DIRECT_TELEGRAM',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Директ: Ссылка на Telegram',
            'ACTIVE' => 'Y',
            'SORT' => '340',
            'CODE' => 'DIRECT_TELEGRAM_LINK',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
        ));

        // === Секция формы заявки ===
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Форма: Заголовок секции',
            'ACTIVE' => 'Y',
            'SORT' => '400',
            'CODE' => 'FORM_SECTION_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Форма: Описание процесса',
            'ACTIVE' => 'Y',
            'SORT' => '410',
            'CODE' => 'FORM_PROCESS_DESCRIPTION',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '3',
            'COL_COUNT' => '60',
        ));

        // Шаги процесса (6 шагов)
        for ($i = 1; $i <= 6; $i++) {
            $helper->Iblock()->saveProperty($iblockId, array(
                'NAME' => "Форма: Шаг {$i}",
                'ACTIVE' => 'Y',
                'SORT' => 415 + $i,
                'CODE' => "FORM_STEP_{$i}",
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '3',
                'COL_COUNT' => '60',
            ));
        }

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Форма: Заголовок формы',
            'ACTIVE' => 'Y',
            'SORT' => '430',
            'CODE' => 'FORM_TITLE',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '60',
        ));
    }

    private function createContactsElement($helper, $iblockId)
    {
        // Создаем элемент с базовым контентом
        $elementId = $helper->Iblock()->saveElement($iblockId, array(
            'NAME' => 'Страница контактов',
            'CODE' => 'contacts_page_content',
            'ACTIVE' => 'Y',
        ));

        // Получаем существующие значения свойств
        $currentValues = [];
        $props = \CIBlockElement::GetProperty($iblockId, $elementId);
        while ($prop = $props->Fetch()) {
            if (!empty($prop['VALUE'])) {
                $currentValues[$prop['CODE']] = $prop['VALUE'];
            }
        }

        // Новые значения свойств
        $newValues = [
            // Секция приветствия
            'CONTACTS_WELCOME_TITLE' => 'Контакты',

            // Секция SEO
            'SEO_SECTION_TITLE' => 'Связаться по услугам seo',
            'SEO_PHONE' => '8-800-000 00 00',
            'SEO_PHONE_LINK' => 'tel:8-800-000 00 00',
            'SEO_TELEGRAM' => '@AndreyBaklenev',
            'SEO_TELEGRAM_LINK' => 'https://t.me/AndreyBaklenev',

            // Секция Директ
            'DIRECT_SECTION_TITLE' => 'Связаться по услугам<br/> Я.Директ',
            'DIRECT_PHONE' => '+7 903 712 5956',
            'DIRECT_PHONE_LINK' => 'tel:+79037125956',
            'DIRECT_TELEGRAM' => '@Ivanova_IM',
            'DIRECT_TELEGRAM_LINK' => 'https://t.me/Ivanova_IM',

            // Секция формы
            'FORM_SECTION_TITLE' => 'Отправьте заявку с сайта',
            'FORM_PROCESS_DESCRIPTION' => 'Процесс знакомства поможет найти точки интереса обеим сторонам для роста вашего проекта.',

            // Шаги процесса
            'FORM_STEP_1' => 'Заполните форму обратной связи. Опишите вашу ситуацию кратко и ваши ожидания от работы. Отправьте её нажав "Отправить".',
            'FORM_STEP_2' => 'Мы изучим ваш сайт и нишу в целом. Сделаем краткий аудит и постараемся найти точки роста для дальнейшего обсуждения.',
            'FORM_STEP_3' => 'Ответным письмом, в удобном для вас способом, пришлём краткую информацию о нашем видении развития. Укажим примерный бюджет для старта работ.',
            'FORM_STEP_4' => 'Договоримся о встрече. Встретимся. Поговорим устно о проекте о ваших KPI, болях проекта.',
            'FORM_STEP_5' => 'Если встреча пройдёт успешно, то напишем предварительный план развития на квартал с более понятными действиями и бюджетами.',
            'FORM_STEP_6' => 'Если всё устраивает, то подписываем договор и начинаем работу над развитием проекта.',

            // Форма
            'FORM_TITLE' => 'Заполните форму обратной связи',
        ];

        // Мерджим существующие значения с новыми
        $propertyValues = array_merge($currentValues, $newValues);

        \CIBlockElement::SetPropertyValues($elementId, $iblockId, $propertyValues);
    }

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function down()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->deleteIblockIfExists('contacts_page');
    }
}