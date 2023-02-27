<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
    $APPLICATION->SetTitle('Каталог-мини');

    CModule::IncludeModule('iblock');

    const INFOBLOCK_ID   = 1;
    const COUNT_ELEMENTS = 3;

    $dbResultInfoblock = CIBlockSection::GetList(['NAME'=>'ASC'], ['IBLOCK_ID'=>INFOBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y']);
    while($arResultSection = $dbResultInfoblock->GetNext())
    {
        echo $arResultSection['NAME'] . '<br>';
        $arSelectElements = ['ID', 'NAME', 'IBLOCK_ID', 'SECTION_ID', 'DATE_CREATE', 'ACTIVE'];
        $arFilterElements = ['IBLOCK_ID'=>INFOBLOCK_ID, 'SECTION_ID'=>$arResultSection['ID'],  'ACTIVE'=>'Y'];
        $dbResultElements = CIBlockElement::GetList(['DATE_CREATE'=>'DESC'], $arFilterElements, false, ['nPageSize'=>COUNT_ELEMENTS], $arSelectElements);
        $arNamesElements  = [];
        while($obElement = $dbResultElements->GetNextElement())
        {
            $arFieldsElement   = $obElement->GetFields();
            $arNamesElements[] = $arFieldsElement['NAME'];
        }
        natsort($arNamesElements);
        echo '<ul><li>' . implode('</li><li>', $arNamesElements) . '</li></ul>';
    } 

    require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');