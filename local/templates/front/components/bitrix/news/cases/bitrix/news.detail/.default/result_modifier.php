<?php

$arResult['ACTIVE_IMG'] = CFile::GetPath($arResult['PROPERTIES']['ACTIVE_IMG']['VALUE']);

$sectionsRaw = CIBlockElement::GetElementGroups([$arResult['ID']], true, [
    'ID', 'IBLOCK_ELEMENT_ID', 'NAME', 'SORT'
])->Fetch();
$arResult['ELEMENT_SECTION'] = $sectionsRaw['NAME'];

$res = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    [
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'ACTIVE' => 'Y',
    ],
    false,
    [
        'nElementID' => $arResult['ID'],
        'nPageSize' => 1
    ]
);
$nearElementsSide = 'LEFT';
while ($arElem = $res->GetNext()) {
    if ($arElem['ID'] == $arResult['ID']) {
        $nearElementsSide = 'RIGHT';
        continue;
    }
    $arResult['NEAR_ELEMENTS'][$nearElementsSide][] = $arElem;
}
