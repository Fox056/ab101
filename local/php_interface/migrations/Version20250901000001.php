<?php

namespace Sprint\Migration;

class Version20250901000001 extends Version
{
    protected $author = "developer";

    protected $description = "Создание базового инфоблока для управления главной страницей";

    protected $moduleVersion = "5.4.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        // Создаем инфоблок в существующем типе
        $iblockId = $helper->Iblock()->saveIblock(array(
            'IBLOCK_TYPE_ID' => 'iblocks_for_main',
            'LID' => array(0 => 's1'),
            'CODE' => 'main_page',
            'REST_ON' => 'N',
            'NAME' => 'Главная страница',
            'ACTIVE' => 'Y',
            'SORT' => '1',
            'LIST_PAGE_URL' => '',
            'DETAIL_PAGE_URL' => '',
            'SECTION_PAGE_URL' => '',
            'CANONICAL_PAGE_URL' => '',
            'PICTURE' => NULL,
            'DESCRIPTION' => 'Управление контентом главной страницы сайта',
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
            'IBLOCK_SECTION' => array(
                'NAME' => 'Привязка к разделам',
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => array('KEEP_IBLOCK_SECTION_ID' => 'N'),
                'VISIBLE' => 'N',
            ),
            'ACTIVE' => array(
                'NAME' => 'Активность',
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => 'Y',
                'VISIBLE' => 'Y',
            ),
            'NAME' => array(
                'NAME' => 'Название блока',
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

        // Настраиваем права доступа
        $helper->Iblock()->saveGroupPermissions($iblockId, array(
            'administrators' => 'X',
            'everyone' => 'R',
        ));

        // Создаем базовый элемент без свойств (заполнится в следующих миграциях)
        $helper->Iblock()->saveElement($iblockId, array(
            'NAME' => 'Главная страница',
            'CODE' => 'main_page_content',
            'ACTIVE' => 'Y',
        ));
    }

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function down()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->deleteIblockIfExists('main_page');
    }
}