<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
    echo $arResult['ERROR'];
    return false;
}
?><ul><?
foreach ($arResult['rows'] as $key => $val) {
    ?><li><a href="/brends/<?=$val["ID"]?>/" title="<?=$val["UF_NAME"]?>"><?=$val["UF_NAME"]?></a></li><?
}
?></ul><?