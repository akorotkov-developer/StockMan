<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

function GetNameBarnd($UF_XML_ID) {
    if (!CModule::IncludeModule('highloadblock'))
        continue;

    $ID = StockMan\Config::BRAND_REF_BLOCK_ID; //highloadblock Brendshl

//сначала выбрать информацию о ней из базы данных
    $hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();


//затем инициализировать класс сущности
    $hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);

    $hlDataClass = $hldata['NAME'].'Table';

    $result = $hlDataClass::getList(array(
        'select' => array('ID', 'UF_NAME'),
        'order' => array('UF_NAME' =>'ASC'),
        'filter' => array('=UF_XML_ID'=>$UF_XML_ID),
    ));

    while($res = $result->fetch())
    {
        return $res["UF_NAME"];
    }
}

$index = 0;
foreach ($arResult["ITEMS"] as $key => $Item) {
    if ($Item["PROPERTIES"]["BRAND_REF"]["VALUE"]) {
        $arResult["ITEMS"][$index]["BRAND_REF_NAME"] = GetNameBarnd($Item["PROPERTIES"]["BRAND_REF"]["VALUE"]);
    }
    $index++;
}
?>