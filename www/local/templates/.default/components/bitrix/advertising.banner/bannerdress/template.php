<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$frame = $this->createFrame()->begin("1");
?>
    <div class="cell large-3 medium-6 medium-order-2 large-order-1">
        <a class="coat" href="<?=$arResult["LINK_BANNER"]?>" style="background-image:url(<?=$arResult["IMG_BANNER"]?>);"><?=$arResult["BANNER_PROPERTIES"]["CODE"]?></a>
    </div>
<?
$frame->end();

