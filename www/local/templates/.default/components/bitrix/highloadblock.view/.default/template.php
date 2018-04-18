<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	ShowError($arResult['ERROR']);
	return false;
}
$name = htmlspecialcharsEx($arResult['fields']["UF_NAME"]["VALUE"]);
$APPLICATION->AddChainItem($name);
global $USER_FIELD_MANAGER;
$APPLICATION->SetTitle($name);
$count = intval(count($arResult["arIdProducts"]));
?>
<div class="content content_medium-gray">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center">
                <h1 class="margin-bottom-0"><?=$name?></h1>
                <div class="text-secondary margin-bottom-1"><?=$count?> <?=inclination($count,array('товар','товара','товаров'))?></div>
            </div>
        </div>
        <div class="grid-x grid-padding-x">
            <div class="cell large-3 medium-3 text-center">
                <?if ($arResult['fields']["UF_FILE"]["VALUE"]) {
                    ?><p><img src="<?=CFile::GetPath($arResult['fields']["UF_FILE"]["VALUE"]);?>" alt=""></p><?
                }?>
            </div>
            <div class="cell large-9 medium-9">
                <?if ($arResult['fields']["UF_FULL_DESCRIPTION"]["VALUE"]) {
                    echo $arResult['fields']["UF_FULL_DESCRIPTION"]["VALUE"];
                }?>
            </div>
        </div>
    </div>
</div>