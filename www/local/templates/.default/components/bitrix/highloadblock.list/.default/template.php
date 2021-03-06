<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}
?><div class="grid-x grid-padding-x text-center">
    <div class="cell margin-bottom-20"><?
    foreach ($arResult['rows'] as $key => $val) {
        ?><a class="brand" href="#<?=$key?>"><?=$key?></a><?
    }
    ?></div>
</div>
<?
foreach ($arResult['rows'] as $key => $val) {
    ?>
    <a name="<?=$key?>"></a>
    <div class="grid-x grid-padding-x text-center">
        <div class="cell text-size-xxlarge margin-bottom-4 font-bold"><?=$key?></div>
    </div>
    <div class="grid-x grid-padding-x large-up-4 margin-bottom-20 medium-up-2"><?
    foreach ($val as $brand) {
        $url = str_replace(
            array('#ID#', '#BLOCK_ID#',"#UF_CODE#"),
            array($brand["ID"], intval($arParams['BLOCK_ID']), $brand["UF_CODE"]),
            $arParams['DETAIL_URL']
        );
        $url = htmlspecialcharsbx($url);
        ?><div class="cell margin-bottom-3">
            <a class="brand brand_none" href="<?=$url?>"><?=$brand["name"]?></a>
        </div><?
    }
    ?></div><?
}
?>