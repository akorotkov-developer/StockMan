<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$sections = array();

$i = 0;
foreach ($arResult as $key => $arItem) {
    if ($arItem["PARAMS"]["section_id"] !== NULL) {
        // выборка только активных разделов из инфоблока $IBLOCK_ID, в которых есть элементы
        // со значением свойства SRC, начинающееся с https://
        $arFilter = Array('IBLOCK_ID'=>StockMan\Config::CATALOG_ID, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$arItem["PARAMS"]["section_id"]);
        $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);

        $k = 0;
        while($ar_result = $db_list->GetNext())
        {
            $sections[$k]["ID"] = $ar_result['ID'];
            $sections[$k]["NAME"] = $ar_result['NAME'];
            $sections[$k]['SECTION_PAGE_URL'] = $ar_result['SECTION_PAGE_URL'];
            $k++;
        }
        $arResult[$i]["MODAL"] = $sections;
    }
    $i++;
}
?>