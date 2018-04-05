<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */

$bPriceType  = false;
$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
?>
<?
if ($_GET["delayed"] == "Y") {
    $display = "block";
} else {
    $display = "none";
}
?>
<div id="basket_items_delayed" class="callout" style="display:<?=$display?>">
    <div id="delayed_items">
            <?
            foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {
                if (in_array($arHeader["id"], array("TYPE"))) // some header columns are shown differently
                {
                    $bPriceType = true;
                    continue;
                } elseif ($arHeader["id"] == "PROPS") {
                    $bPropsColumn = true;
                    continue;
                } elseif ($arHeader["id"] == "DELAY") {
                    continue;
                } elseif ($arHeader["id"] == "DELETE") {
                    $bDeleteColumn = true;
                    continue;
                } elseif ($arHeader["id"] == "WEIGHT") {
                    $bWeightColumn = true;
                }
            }
            ?>
        <?
        $skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');

        $i = 0;
        foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
            if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y") {
                if ($i > 0){?><hr class="margin-bottom-6"><?}?>
                <div class="grid-x grid-padding-x x-basket_item" id="<?= $arItem["ID"] ?>"
                     data-item-name="<?= $arItem["NAME"] ?>"
                     data-item-brand="<?= $arItem[$arParams['BRAND_PROPERTY'] . "_VALUE"] ?>"
                     data-item-price="<?= $arItem["PRICE"] ?>"
                     data-item-currency="<?= $arItem["CURRENCY"] ?>">
                    <?
                    foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {

                        if (in_array($arHeader["id"], $skipHeaders)) // some values are not shown in the columns in this template
                            continue;

                        if ($arHeader["name"] == '')
                            $arHeader["name"] = GetMessage("SALE_" . $arHeader["id"]);

                        if ($arHeader["id"] == "NAME") {
                            ?>
                            <div class="cell small-3 medium-2 large-2 itemphoto">
                                <?
                                if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0) {
                                    $url = $arItem["PREVIEW_PICTURE_SRC"];
                                } elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0) {
                                    $url = $arItem["DETAIL_PICTURE_SRC"];
                                } else {
                                    $url = $templateFolder . "/images/no_photo.png";
                                }

                                if (strlen($arItem["DETAIL_PAGE_URL"]) > 0) {
                                ?><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?
                                    } ?>
                                    <img class="margin-bottom-6" src="<?= $url ?>" alt="<?= $arItem["NAME"] ?>">
                                    <? if (strlen($arItem["DETAIL_PAGE_URL"]) > 0){
                                    ?></a><?
                            } ?>
                                <?
                                /*if (!empty($arItem["BRAND"])){
                                    ?>
                                    <div class="bx_ordercart_brand">
                                        <img alt="" src="<?=$arItem["BRAND"]?>" />
                                    </div>
                                    <?
                                }*/
                                ?>
                            </div>
                            <div class="cell small-9 medium-5 large-5">
                                <h5>
                                    <? if (strlen($arItem["DETAIL_PAGE_URL"]) > 0){
                                    ?><a target="_blank" class="text-insta text-decoration-none text-size-xlarge"
                                         href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?
                                        }
                                        ?><?= $arItem["NAME"] ?><?
                                        if (strlen($arItem["DETAIL_PAGE_URL"]) > 0){
                                        ?></a><?
                                } ?>
                                </h5>

                                <? /*<div class="text-secondary margin-bottom-3">Полосатое платье-рубашка</div>*/ ?>
                                <div class="rid-x grid-padding-x">
                                    <?
                                    /*if ($bPropsColumn) {
                                        foreach ($arItem["PROPS"] as $val) {

                                            if (is_array($arItem["SKU_DATA"])) {
                                                $bSkip = false;
                                                foreach ($arItem["SKU_DATA"] as $propId => $arProp) {
                                                    if ($arProp["CODE"] == $val["CODE"]) {
                                                        $bSkip = true;
                                                        break;
                                                    }
                                                }
                                                if ($bSkip)
                                                    continue;
                                            }

                                            echo htmlspecialcharsbx($val["NAME"]) . ":&nbsp;<span>" . $val["VALUE"] . "</span><br/>";
                                        }
                                    }*/
                                    ?>
                                </div>
                                <?
                                if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])) {
                                    $propsMap = array();
                                    foreach ($arItem["PROPS"] as $propValue) {
                                        if (empty($propValue) || !is_array($propValue))
                                            continue;
                                        $propsMap[$propValue['CODE']] = (isset($propValue['~VALUE']) ? $propValue['~VALUE'] : $propValue['VALUE']);
                                    }
                                    unset($propValue);

                                    foreach ($arItem["SKU_DATA"] as $propId => $arProp) {
                                        $selectedIndex = 0;
                                        // if property contains images or values
                                        $isImgProperty = false;
                                        if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"])) {
                                            $counter = 0;
                                            foreach ($arProp["VALUES"] as $id => $arVal) {
                                                $counter++;
                                                if (isset($propsMap[$arProp['CODE']])) {
                                                    if ($propsMap[$arProp['CODE']] == $arVal['NAME'] || $propsMap[$arProp['CODE']] == $arVal['XML_ID'])
                                                        $selectedIndex = $counter;
                                                }
                                                if (!empty($arVal["PICT"]) && is_array($arVal["PICT"])
                                                    && !empty($arVal["PICT"]['SRC'])
                                                ) {
                                                    $isImgProperty = true;
                                                }
                                            }
                                            unset($counter);
                                        }
                                        $countValues = count($arProp["VALUES"]);
                                        if ($countValues > 5) {
                                            $full = "full";
                                            $fullWidth = ($countValues * 20) . '%';
                                            $itemWidth = (100 / $countValues) . '%';
                                        } else {
                                            $full = "";
                                            $fullWidth = '100%';
                                            $itemWidth = '20%';
                                        }

                                        $marginLeft = 0;
                                        if ($countValues > 5 && $selectedIndex > 5)
                                            $marginLeft = ((5 - $selectedIndex) * 20) . '%';

                                        if ($isImgProperty) { // iblock element relation property
                                            ?>
                                            <div class="bx_item_detail_scu_small_noadaptive <?= $full ?>">
													<span class="bx_item_section_name_gray">
														<?= htmlspecialcharsbx($arProp["NAME"]) ?>:
													</span>
                                                <div class="bx_scu_scroller_container">

                                                    <div class="bx_scu">
                                                        <ul id="prop_<?= $arProp["CODE"] ?>_<?= $arItem["ID"] ?>"
                                                            style="width: <?= $fullWidth; ?>; margin-left: <?= $marginLeft; ?>"
                                                            class="sku_prop_list"
                                                        >
                                                            <?
                                                            $counter = 0;
                                                            foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
                                                                $counter++;
                                                                $selected = ($selectedIndex == $counter ? ' bx_active' : '');
                                                                ?>
                                                                <li style="width: <?= $itemWidth; ?>; padding-top: <?= $itemWidth; ?>;"
                                                                    class="sku_prop<?= $selected ?>"
                                                                    data-sku-selector="Y"
                                                                    data-value-id="<?= $arSkuValue["XML_ID"] ?>"
                                                                    data-sku-name="<?= htmlspecialcharsbx($arSkuValue["NAME"]); ?>"
                                                                    data-element="<?= $arItem["ID"] ?>"
                                                                    data-property="<?= $arProp["CODE"] ?>"
                                                                >
                                                                    <a href="javascript:void(0)"
                                                                       class="cnt"><span class="cnt_item"
                                                                                         style="background-image:url(<?= $arSkuValue["PICT"]["SRC"]; ?>)"></span></a>
                                                                </li>
                                                                <?
                                                            endforeach;
                                                            unset($counter);
                                                            ?>
                                                        </ul>
                                                    </div>

                                                    <div class="bx_slide_left"
                                                         onclick="leftScroll('<?= $arProp["CODE"] ?>', <?= $arItem["ID"] ?>, <?= $countValues ?>);"></div>
                                                    <div class="bx_slide_right"
                                                         onclick="rightScroll('<?= $arProp["CODE"] ?>', <?= $arItem["ID"] ?>, <?= $countValues ?>);"></div>
                                                </div>

                                            </div>
                                            <?
                                        } else {
                                            ?>
                                            <div class="grid-x grid-padding-x <?= $full ?>">
                                                <div class="large-3 medium-12 small-5 cell"><?= htmlspecialcharsbx($arProp["NAME"]) ?></div>
                                                <?
                                                if (!empty($arProp["VALUES"])) {
                                                    $selected = 0;
                                                    $counter = 0;
                                                    foreach ($arProp["VALUES"] as $valueId => $arSkuValue) {
                                                        $counter++;
                                                        if ($selectedIndex == $counter) {
                                                            $selected = $valueId;
                                                        }
                                                    }
                                                    unset($counter);
                                                    ?>
                                                    <div class="large-9 medium-12 small-7 cell"><?= htmlspecialcharsbx($arProp["VALUES"][$selected]['NAME']); ?></div><?
                                                }
                                                ?>
                                            </div>
                                            <?
                                        }
                                    }
                                }
                                ?>
                                <?
                                $arPropProd = $arResult["PROD_OFFERS"][$arItem["PRODUCT_ID"]]['prop'];
                                if (is_array($arPropProd)) {
                                    ?>
                                    <div class="grid-x grid-padding-x">
                                        <div class="large-3 medium-12 small-5 cell"><?= htmlspecialcharsbx($arPropProd["name"]) ?></div>
                                        <div class="large-9 medium-12 small-7 cell"><?= htmlspecialcharsbx($arPropProd['val']); ?></div>
                                    </div>
                                <? } ?>
                            </div>
                            <?
                        } elseif (($arHeader["id"] == "QUANTITY") or ($arHeader["id"] == "PRICE") or ($arHeader["id"] == "DISCOUNT") or ($arHeader["id"] == "SUM") /*or ($arHeader["id"] == "DISCOUNT")*/) { ?>
                            <?
                            if ($arHeader["id"] == "PRICE") { ?>
                                <div class="cell small-12 medium-5 large-5">
                                <div class="grid-x grid-padding-x">
                                <div class="cell small-6 medium-7 large-4">
                                    <div class="margin-bottom-6">
                                        <span id="current_price_<?= $arItem["ID"] ?>"><?= $arItem["PRICE_FORMATED"] ?></span>
                                        <div>
                                            <del class="text-dark-gray" id="old_price_<?= $arItem["ID"] ?>">
                                                <? if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0) { ?>
                                                    <?= $arItem["FULL_PRICE_FORMATED"] ?>
                                                    <?
                                                } ?>
                                            </del>
                                        </div>
                                        <?
                                        /*if ($arHeader["id"] == "DISCOUNT") {
                                            ?>
                                            <div>
                                                <span><?= $arHeader["name"]; ?>:</span>
                                                <div id="discount_value_<?= $arItem["ID"] ?>"><?= $arItem["DISCOUNT_PRICE_PERCENT_FORMATED"] ?></div>
                                            </div>
                                            <?
                                        }*/
                                        ?>
                                        <?
                                        if ($bDelayColumn || $bDeleteColumn) {
                                            ?>
                                            <div>
                                                <a href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["add"]) ?>"><?= GetMessage("SALE_ADD_TO_BASKET") ?></a>
                                            </div>
                                            <?
                                            if ($bDeleteColumn) {
                                                ?>
                                                <div>
                                                    <a href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["delete"]) ?>"><?= GetMessage("SALE_DELETE") ?></a>
                                                </div>
                                                <?
                                            }
                                        }
                                        ?>
                                    </div>
                                    <? if ($bPriceType && strlen($arItem["NOTES"]) > 0) { ?>
                                        <div class="type_price"><?= GetMessage("SALE_TYPE") ?></div>
                                        <div class="type_price_value"><?= $arItem["NOTES"] ?></div>
                                    <? } ?>
                                </div>
                                <?
                            }
                            if ($arHeader["id"] == "QUANTITY") {
                                ?>
                                <div class="cell small-6 medium-5 large-3 counter">
                                    <div>
                                        <?echo $arItem["QUANTITY"];
                                        if (isset($arItem["MEASURE_TEXT"]))
                                            echo "&nbsp;".htmlspecialcharsbx($arItem["MEASURE_TEXT"]);
                                        ?>
                                    </div>
                                </div>
                                <?
                            }
                            if ($arHeader["id"] == "SUM") {
                                ?>
                                <div class="cell small-12 large-5 text-center medium-text-left">
                                    <div class="margin-bottom-6"
                                         id="sum_<?= $arItem["ID"] ?>"><?= $arItem[$arHeader["id"]] ?></div>
                                </div>
                                </div>
                                </div>
                                <?
                            } ?>
                            <?
                        }
                    }
                    ?>
                </div>
                <?
                $i++;
            }
        }
        ?>
</div>