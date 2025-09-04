<?php
foreach ($arResult['ITEMS'] as $key => &$arItem){

    $ipropTemplates = new \Bitrix\Iblock\InheritedProperty\ElementTemplates($arItem['IBLOCK_ID'], $arItem['ID']);
    $arTemplates = $ipropTemplates->findTemplates();
    $arResult['ITEMS'][$key]['ITEMP'] = $arTemplates;



    $arSelect = ["ID","IBLOCK_ID","NAME","DATA_ACTIVE_FROM","PREVIEW_PICTURE",'DETAIL_PICTURE',"PROPERTY_*"];
    $arFilter = ["IBLOCK_ID"=>CASES,'ID'=>$arItem['ID'], 'ACTIVE_DATE'=>'Y','ACTIVE'=>'Y'];
    $res = CIBlockElement::GetList([],$arFilter,false,false,$arSelect);
    while($ob = $res->GetNextElement()){
        $arItem['DISPLAY_PROPERTIES'] = $ob->GetProperties();
        $arItem['DISPLAY_PROPERTIES']['DETAIL_PICTURE']['SRC'] = CFile::GetPath($ob->GetFields()['DETAIL_PICTURE']);
        $arItem['DISPLAY_PROPERTIES']['PREVIEW_PICTURE']['SRC'] = CFile::GetPath($ob->GetFields()['PREVIEW_PICTURE']);

    }
}