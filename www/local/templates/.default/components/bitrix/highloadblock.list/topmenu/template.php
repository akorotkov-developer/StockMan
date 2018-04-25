<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
    echo $arResult['ERROR'];
    return false;
}
?>
<?if ($arResult['rows']) {
    ?>
    <h5>По брендам</h5>
    <ul><?
    foreach ($arResult['rows'] as $key => $val) {
        $url = str_replace(
            array('#ID#', '#BLOCK_ID#',"#UF_CODE#"),
            array($val["ID"], intval($arParams['BLOCK_ID']), $val["UF_CODE"]),
            $arParams['DETAIL_URL']
        );
        $url = htmlspecialcharsbx($url);
        ?>
        <li><a href="<?=$url?>" title="<?= $val["UF_NAME"] ?>"><?=ToUpper($val["UF_NAME"])?></a></li><?
    }
    ?></ul>
    <a class="font-bold text-decoration-none" href="/brands/">Все бренды</a>
    <?
}