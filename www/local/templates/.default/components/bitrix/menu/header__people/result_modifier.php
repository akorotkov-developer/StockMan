<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$selected = false;
foreach ($arResult as $arRes) {
    if ($arRes["SELECTED"]) {
        $selected=true;
    }
}

if (!$selected) {
    $i = 0;
    $selecteditem = "/".GetSectionCodeBySectionID(GetHomeCtalogSection())."/";
    foreach ($arResult as $arRes) {
        $findstring = "..".$arRes["LINK"];
        if (strpos($findstring,$selecteditem) > 0) {
            $arResult[$i]["SELECTED"] = true;
        }
        $i++;
    }
}
?>