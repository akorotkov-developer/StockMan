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

$WrokCatalog = new StockMan\Catalog\Workcatalog;


if (0 < $arResult["SECTIONS_COUNT"])
{
?>

    <div class="grid-container position-relative top-menu-on-site">
        <div class="grid-x directory" id="responsive-menu" data-toggler="js-open">
            <?
            foreach ($arResult['ROOT'] as $key) {
                foreach ($key["CHILD"] as $depthlevelfirst) {
                    /*Если нет подпунктов то пропускаем итерацию*/
                    if (!$depthlevelfirst["CHILD"]) {
                        continue;
                    } else {
                        ?>
                        <div class="subheader" data-toggler="js-open" id="subheader<?=$depthlevelfirst['ID']?>">
                        <button class="close-button close-button-childe show-for-small-only" aria-label="Close alert" type="button"><span aria-hidden="true" data-toggle="responsive-menu">×</span></button>
                        <button class="subheader__back" data-toggle="subheader<?=$depthlevelfirst['ID']?>"><i class="fa fa-chevron-left"></i>Назад</button>
                        <ul class="trousers">
                        <?
                    }
                    foreach ($depthlevelfirst["CHILD"] as $depthlevelsecond) {
                        if (intval($WrokCatalog->GetElmentCountBySectionID($depthlevelsecond['ID']))==0) {$displaynone = "style='display:none;'";}
                        ?>
                        <li class="trousers__item" <?=$displaynone;?>><a class="trousers__link" href="<?=$depthlevelsecond["SECTION_PAGE_URL"];?>"><?=$depthlevelsecond["NAME"];?></a></li>
                        <?
                        $displaynone = '';
                    }
                    ?>
                    </ul>
                    </div>
                    <?
                }
            }
            ?>
            <button class="close-button show-for-small-only" aria-label="Close alert" type="button"><span aria-hidden="true" data-toggle="responsive-menu">×</span></button>
            <div class="cell text-center medium-text-left">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "header__people_smallonly",
                    Array(
                        "ALLOW_MULTI_SELECT" => "Y",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => "",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "catalog-level1",
                        "USE_EXT" => "N"
                    )
                );?>
            </div>
            <div class="small-12 medium-9 large-9 cell" id="menu">
                <ul class="menu-base text-left medium-text-center">
                    <?
                        $idMenuSectionNovinka = getMainMenuSectionNovinka($arParams['SECTION_ID']);
                        if (intval($idMenuSectionNovinka) > 0) {
                            $section_page_url = '/';
                            $arFilterSectionMenuNovinka = array(
                                "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
                                'ID' => $idMenuSectionNovinka
                            );
                            $rsSectionMenuNovinka = CIBlockSection::GetList(array('ID' => 'asc'), $arFilterSectionMenuNovinka, false, array('SECTION_PAGE_URL'));
                            while ($arSectionMenuNovinka = $rsSectionMenuNovinka->GetNext()) {
                                $section_page_url = $arSectionMenuNovinka['SECTION_PAGE_URL'];
                            }

                            $APPLICATION->IncludeComponent(
                                "bitrix:catalog.smart.filter",
                                "menu_novinki",
                                array(
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
                                    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
                                    "SECTION_ID" => $idMenuSectionNovinka,
                                    "SECTION_CODE" => "",
                                    "FILTER_NAME" => "arrFilterMenu",
                                    "HIDE_NOT_AVAILABLE" => "N",
                                    "TEMPLATE_THEME" => "blue",
                                    "FILTER_VIEW_MODE" => "horizontal",
                                    "DISPLAY_ELEMENT_COUNT" => "Y",
                                    "SEF_MODE" => "Y",
                                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                    "CACHE_TIME" => $arParams['CACHE_TIME'],
                                    "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                                    "SAVE_IN_SESSION" => "N",
                                    "INSTANT_RELOAD" => "Y",
                                    "PAGER_PARAMS_NAME" => "arrPager",
                                    "PRICE_CODE" => array(),
                                    "CONVERT_CURRENCY" => "N",
                                    "XML_EXPORT" => "N",
                                    "SECTION_TITLE" => "-",
                                    "SECTION_DESCRIPTION" => "-",
                                    "POPUP_POSITION" => "left",
                                    "SECTION_PAGE_URL" => $section_page_url
                                ),
                                false,
                                array('HIDE_ICONS' => 'Y')
                            );
                        }?>
                    <?
                    foreach ($arResult['ROOT'] as $key) {
                        foreach ($key["CHILD"] as $depthlevelfirst) {
                            $href = "href='".$depthlevelfirst['SECTION_PAGE_URL']."'";
                            /*Если Меню не активное то обнуляем $activeItemFisrtLevel*/
                            $activeItemFisrtLevel= "menu-base__link_active";
                            if (!in_array(intval($depthlevelfirst["ID"]), $arResult["TREE_OF_SECTIONS"])) {
                                $activeItemFisrtLevel = "";
                            }
                            /*Если у меню есть подпункты, то задаем дата теги для него*/
                            $data_toogle = "";
                            if ($depthlevelfirst["CHILD"]) {
                                $data_toogle = 'data-toggle-hover-dd="menu_item_'.$depthlevelfirst["ID"].'" data-toggle="subheader'.$depthlevelfirst["ID"].'"';
                            }
                            if (intval($WrokCatalog->GetElmentCountBySectionID($depthlevelfirst['ID']))==0) {$displaynone = "style='display:none;'";}
                            ?>
                            <?
                            if (!$data_toogle) {
                                $href = "href='".$depthlevelfirst['SECTION_PAGE_URL']."'";
                            }
                            ?>
                            <li class="menu-base__item" <?=$displaynone;?>>
                                <a class="menu-base__link hide-for-small-only <?=$activeItemFisrtLevel;?> " <?=$data_toogle;?> <?=$href?>>
                                    <img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH.$depthlevelfirst['UF_PICTURE']?>" alt="">
                                    <?=$depthlevelfirst["NAME"];?>
                                </a>
                                <a class="menu-base__link show-for-small-only <?=$activeItemFisrtLevel;?>" <?=$data_toogle;?> >
                                    <img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH.$depthlevelfirst['UF_PICTURE']?>" alt="">
                                    <?=$depthlevelfirst["NAME"];?>
                                    <i class="fa fa-chevron-right show-for-small-only"></i>
                                </a>
                            </li>
                            <?
                            $displaynone = '';
                            $data_toogle = false;
                        }
                        ?>
                        <?

                        if (intval($idMenuSectionNovinka) > 0) {
                            $APPLICATION->IncludeComponent(
                                "bitrix:catalog.smart.filter",
                                "menu_sale",
                                array(
                                    "COMPONENT_TEMPLATE" => ".default",
                                    "IBLOCK_TYPE" => StockMan\Config::CATALOG_TYPE,
                                    "IBLOCK_ID" => StockMan\Config::CATALOG_ID,
                                    "SECTION_ID" => $idMenuSectionNovinka,
                                    "SECTION_CODE" => "",
                                    "FILTER_NAME" => "arrFilterMenu",
                                    "HIDE_NOT_AVAILABLE" => "N",
                                    "TEMPLATE_THEME" => "blue",
                                    "FILTER_VIEW_MODE" => "horizontal",
                                    "DISPLAY_ELEMENT_COUNT" => "Y",
                                    "SEF_MODE" => "Y",
                                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                    "CACHE_TIME" => $arParams['CACHE_TIME'],
                                    "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                                    "SAVE_IN_SESSION" => "N",
                                    "INSTANT_RELOAD" => "Y",
                                    "PAGER_PARAMS_NAME" => "arrPager",
                                    "PRICE_CODE" => array(),
                                    "CONVERT_CURRENCY" => "N",
                                    "XML_EXPORT" => "N",
                                    "SECTION_TITLE" => "-",
                                    "SECTION_DESCRIPTION" => "-",
                                    "POPUP_POSITION" => "left",
                                    "SECTION_PAGE_URL" => $section_page_url
                                ),
                                false,
                                array('HIDE_ICONS' => 'Y')
                            );
                        }
                        ?>
                        <li class="menu-base__item">
                            <a class="menu-base__link" href="/blog/">
                                <img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/blog.svg" alt="">Блог</a>
                        </li>
                        <?
                    }
                    ?>
                </ul>
            </div>
            <?$APPLICATION->IncludeComponent("bitrix:search.form","",Array(
                    "USE_SUGGEST" => "N",
                    "PAGE" => "/"
                )
            );?>
        </div>
    </div>

    <?
    foreach ($arResult['ROOT'] as $key) {
        foreach ($key["CHILD"] as $depthlevelfirst) {
            /*Если нет подпунктов то пропускаем итерацию*/
            if (!$depthlevelfirst["CHILD"]) {
                continue;
            } else {
            ?>
                <div class="dd hide-for-small-only" id="menu_item_<?=$depthlevelfirst['ID']?>" data-toggler-hover-dd="dd_show">
                    <div class="dd__content">
                        <div class="grid-container">
                            <div class="grid-x grid-padding-x">
                                <div class="small-6 medium-5 large-6 cell">
                                    <h5>По категориям</h5>
                                    <div class="grid-x grid-padding-x">

            <?
            }
                                                $elementscount = 0;
                                                $elementsmiddle = intval(count($depthlevelfirst["CHILD"]) / 2);
                                                foreach ($depthlevelfirst["CHILD"] as $depthlevelsecond) {
                                                    if ($elementscount == 0) {
                                                       ?>
                                                        <div class="small-6 cell">
                                                            <ul>
                                                       <?
                                                    }
                                                    if ($elementscount == $elementsmiddle) {
                                                        ?>
                                                            </ul>
                                                        </div>
                                                        <div class="small-6 cell">
                                                            <ul>
                                                        <?
                                                    }
                                                    if (intval($WrokCatalog->GetElmentCountBySectionID($depthlevelsecond['ID']))==0) {$displaynone = "style='display:none;'";}
                                                    ?>
                                                    <li <?=$displaynone?>><a href="<?=$depthlevelsecond['SECTION_PAGE_URL'];?>"><?=$depthlevelsecond['NAME'];?></a></li>
                                                    <?
                                                    $displaynone = '';
                                                    $elementscount++;
                                                }
            ?>
                                                            </ul>
                                                        </div>
                                    </div>
                                </div>
                                <div class="small-6 medium-4 large-3 cell">
                                    <?/*<h5>По дизайнерам</h5>
                                    <ul>
                                        <li><a href="#" title="">BURBERRY</a></li>
                                        <li><a href="#" title="">CHLOE</a></li>
                                        <li><a href="#" title="">DOLCE &amp; GABBANA</a></li>
                                        <li><a href="#" title="">DSQUARED2</a></li>
                                        <li><a href="#" title="">ETRO</a></li>
                                        <li><a href="#" title="">GIVENCHY</a></li>
                                        <li><a href="#" title="">ISABEL MARANT</a></li>
                                        <li><a href="#" title="">LANVIN</a></li>
                                        <li><a href="#" title="">MARC JACOBS</a></li>
                                        <li><a href="#" title="">MAX MARA</a></li>
                                    </ul><a class="font-bold text-decoration-none" href="#">Все дизайнеры</a>
                                    */?>
                                </div>




                                <?$bannermenusect = strtoupper(GetSectionCodeBySectionID(GetHomeCtalogSection()));?>
                                <?
                                $rs = CAdvBanner::GetList($by="s_id", $order="desc", array("TYPE_SID" => "BANNER_MENU_".$bannermenusect, "TYPE_SID_EXACT_MATCH" => "Y"), $if_filtered, "N");
                                while($ar = $rs->Fetch()) {
                                    $dom = new DOMDocument;
                                    $dom->loadHTML(CAdvBanner::GetHTML($ar));
                                    foreach ($dom->getElementsByTagName('a') as $node) {
                                        $arRes["LINK_BANNER"] = $node->getAttribute( 'href' );
                                    }
                                    foreach ($dom->getElementsByTagName('img') as $node) {
                                        $arRes["IMG_BANNER"] = $node->getAttribute( 'src' );
                                    }
                                    ?>
                                    <div class="margin-bottom-9">
                                        <a href="<?=$arRes["LINK_BANNER"]?>" >
                                            <img src="<?=$arRes["IMG_BANNER"]?>" alt="">
                                        </a>
                                        <?=$ar["CODE"];?>
                                        <?/*<a class="anchor" href="<?=$arRes["LINK_BANNER"]?>">смотреть все    </a>*/?>
                                    </div>
                                    <?
                                }
                                ?>

                                <?/*<div class="small-6 medium-3 large-3 cell text-center">
                                    <?
                                    foreach ($arResult['ROOT'] as $key) {
                                        foreach ($key["CHILD"] as $depthlevelfirst) {
                                            foreach ($depthlevelfirst["CHILD"] as $depthlevelsecond) {
                                                $renderImage = CFile::ResizeImageGet($depthlevelsecond['PICTURE'], Array("width" => 293, "height" => 216), BX_RESIZE_IMAGE_EXACT, false)
                                                ?>
                                                <div class="margin-bottom-9"><a href="<?=$depthlevelsecond['SECTION_PAGE_URL']?>"><img src="<?=$renderImage["src"];?>" alt=""></a></div>
                                                <h3 class="margin-bottom-0"><?=$depthlevelsecond["NAME"];?></h3><a class="anchor" href="<?=$depthlevelsecond['SECTION_PAGE_URL']?>">смотреть все</a>
                                                <?
                                                break;
                                            }
                                            break;
                                        }
                                        break;
                                    }
                                    ?>
                                </div>*/?>

                            </div>
                        </div>
                    </div>
                </div>
            <?
        }
    }
    ?>




<?
}
?>