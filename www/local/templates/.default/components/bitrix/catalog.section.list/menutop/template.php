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

    <div class="grid-container position-relative">
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
                        <button class="subheader__back" data-toggle="subheader<?=$depthlevelfirst['ID']?>"><i class="fa fa-chevron-left"></i>Назад</button>
                        <ul class="trousers">
                        <?
                    }
                    foreach ($depthlevelfirst["CHILD"] as $depthlevelsecond) {
                        ?>
                        <li class="trousers__item"><a class="trousers__link" href="<?=$depthlevelsecond["SECTION_PAGE_URL"];?>"><?=$depthlevelsecond["NAME"];?></a></li>
                        <?
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
                <ul class="menu-base text-left medium-text-right">
                    <?
                    foreach ($arResult['ROOT'] as $key) {
                        foreach ($key["CHILD"] as $depthlevelfirst) {
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
                            ?>
                            <li class="menu-base__item"><a class="menu-base__link <?=$activeItemFisrtLevel;?>" <?=$data_toogle;?> href="<?=$depthlevelfirst['SECTION_PAGE_URL']?>"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH.$depthlevelfirst['UF_PICTURE']?>" alt=""><?=$depthlevelfirst["NAME"];?></a></li>
                            <?
                        }
                        ?>
                        <li class="menu-base__item"><a class="menu-base__link" href="#"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/sale.svg" alt="">Sale</a></li>
                        <li class="menu-base__item"><a class="menu-base__link" href="/blog/"><img class="show-for-small-only" src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/blog.svg" alt="">Блог</a></li>
                        <?
                    }
                    ?>
                </ul>
            </div>
            <?$APPLICATION->IncludeComponent("bitrix:search.form","",Array(
                    "USE_SUGGEST" => "N",
                    "PAGE" => "#SITE_DIR#search/index.php"
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
                                                    ?>
                                                    <li><a href="<?=$depthlevelsecond['SECTION_PAGE_URL'];?>"><?=$depthlevelsecond['NAME'];?></a></li>
                                                    <?
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
                                <div class="small-6 medium-3 large-3 cell text-center">
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
                                </div>
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