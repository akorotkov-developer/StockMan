<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<ul class="cloth">
<?
    $intCurrentDepth = 1;
    $boolFirst = true;

    foreach ($arResult['SECTIONS'] as &$arSection)
    {
        $activeItem = "";
        if (($arSection["ELEMENT_CNT"] > 0)and(in_array($arSection["ID"],$GLOBALS["arSectionIdBrands"]))) {

            $arSection["SECTION_PAGE_URL"] = str_replace("//","/",$arParams["CUR_PAGE_BRAND"] . $arSection["SECTION_PAGE_URL"]);
            if ($APPLICATION->GetCurPage() == $arSection["SECTION_PAGE_URL"]) {
                $activeItem = "cloth__link_more";
            }
            if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL']) {
                if (0 < $intCurrentDepth)
                    echo "\n", str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']), '<ul  class="cloth">';
            } elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL']) {
                if (!$boolFirst)
                    echo '</li>';
            } else {
                while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL']) {
                    echo '</li>', "\n", str_repeat("\t", $intCurrentDepth), '</ul>', "\n", str_repeat("\t", $intCurrentDepth - 1);
                    $intCurrentDepth--;
                }
                echo str_repeat("\t", $intCurrentDepth - 1), '</li>';
            }

            echo(!$boolFirst ? "\n" : ''), str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
            ?>
                <li class='cloth__item'>
                    <a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"
                       class='cloth__link <?= $activeItem ?> <?if ($arSection["DEPTH_LEVEL"] > 2) {?>cloth__link_inside<?}?> '><? echo $arSection["NAME"]; ?><?
                        if ($arParams["COUNT_ELEMENTS"]) {
                            ?> <span class='cloth__num'>(<? echo $GLOBALS["arSectionIdBrandsCount"][$arSection["ID"]]; ?>)</span><?
                        }
                        ?>
                    </a><?

            $intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
            $boolFirst = false;
        }
    }
    unset($arSection);
    while ($intCurrentDepth > 1)
    {
        echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
        $intCurrentDepth--;
    }
    if ($intCurrentDepth > 0)
    {
        echo '</li>',"\n";
    }
?>
</ul>
<?
}
?>