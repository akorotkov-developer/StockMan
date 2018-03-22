<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin("");
?>

<?
echo "<pre>";
var_dump($arResult);
echo "</pre>";
?>
    <div class="small-6 medium-3 large-3 cell text-center">
        <div class="margin-bottom-9"><a href="<?=$arResult["LINK_BANNER"]?>"><img src="<?=$arResult["IMG_BANNER"]?>" alt=""></a></div>
        <h3 class="margin-bottom-0">Платья</h3>
        <a class="anchor" href="<?=$arResult["LINK_BANNER"]?>">смотреть все    </a>
    </div>

<?
$frame->end();

