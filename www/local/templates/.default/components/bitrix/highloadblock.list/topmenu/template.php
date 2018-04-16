<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
    echo $arResult['ERROR'];
    return false;
}
?>
<?if ($arResult['rows']) { ?>
    <h5>По брендам</h5>
    <ul><?
    foreach ($arResult['rows'] as $key => $val) {
        ?>
        <li><a href="/brands/<?= $val["ID"] ?>/" title="<?= $val["UF_NAME"] ?>"><?=ToUpper($val["UF_NAME"])?></a></li><?
    }
    ?></ul>
    <a class="font-bold text-decoration-none" href="/brands/">Все бренды</a>
    <?
}