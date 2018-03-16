<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<div class="grid-container position-relative">
    <div class="grid-x directory" id="responsive-menu" data-toggler="js-open">
        <?/*Список категорий для мобильного меню*/?>
        <?
        $arrMenuPopup = array();
        $modalIndex = 0;
        $index = 0;
        foreach ($arResult as $arItem) {
            if ($arItem["MODAL"]) {
                $arrMenuPopup[$index]["ID_ELEMENT"] = $index;
                $arrMenuPopup[$index]["MODAL_INDEX"] = $modalIndex;
                $modalIndex++;
            }
            $index++;
        }
        ?>
        <?foreach ($arrMenuPopup as $arrMenu) {?>
                <div class="subheader" data-toggler="js-open" id="subheader<?=$arrMenu["MODAL_INDEX"]?>">
                        <button class="subheader__back" data-toggle="subheader1"><i class="fa fa-chevron-left"></i>Назад</button>
                        <ul class="trousers">
                                <?foreach ($arResult[$arrMenu["ID_ELEMENT"]]["MODAL"] as $arElement) {?>
                                        <li class="trousers__item"><a class="trousers__link" href="<?=$arElement["SECTION_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></li>
                                <?}?>
                        </ul>
                </div>
        <?}?>
        <?/*Конец списка категорий для мобильного меню*/?>

        <?/*Начало topmenu*/?>
        <button class="close-button show-for-small-only" aria-label="Close alert" type="button"><span aria-hidden="true" data-toggle="responsive-menu">×</span></button>
        <div class="cell text-center medium-text-left">
                <ul class="people show-for-small-only">
                        <li class="people__item"><a class="people__link" href="#">Женщинам</a></li>
                        <li class="people__item"><a class="people__link people__link_active" href="#">Мужчинам</a></li>
                        <li class="people__item"><a class="people__link" href="#">Детям</a></li>
                </ul>
        </div>
        <?/*Конец topmenu*/?>

        <div class="small-12 medium-9 large-9 cell" id="menu">
            <ul class="menu-base text-left medium-text-right">
                <?
                $modalIndex = 0;
                ?>
                <?foreach($arResult as $arItem){
                    $classActive = '';
                    if ($arItem['SELECTED']) {
                        $classActive = 'menu-base__link_active';
                    }
                    ?>
                    <?if ($arItem["MODAL"]) {?>
                        <li class="menu-base__item"><a class="menu-base__link <?=$classActive?>"  data-toggle-hover-dd="menu_item_<?=$modalIndex?>" data-toggle="subheader<?=$modalIndex?>"><img class="show-for-small-only" src="<?=$arItem["PARAMS"]["image"]?>" alt=""><?=$arItem["TEXT"]?><i class="fa fa-chevron-right show-for-small-only"></i></a></li>
                        <?
                        $modalIndex++;
                        ?>
                    <?} else {?>
                        <li class="menu-base__item"><a class="menu-base__link <?=$classActive?>" href="<?=$arItem["LINK"]?>"><img class="show-for-small-only" src="<?=$arItem["PARAMS"]["image"]?>" alt=""><?=$arItem["TEXT"]?></a></li>
                    <?}?>
                <?}?>
            </ul>
        </div>
        <?/*Поиск*/?>
        <?$APPLICATION->IncludeComponent("bitrix:search.form","search_small",Array(
                "USE_SUGGEST" => "N",
                "PAGE" => "/catalog/"
            )
        );?>
        <?/*Конец поиска*/?>
    </div>
</div>
    <?/*Выпадающее меню*/?>
    <?foreach ($arrMenuPopup as $arrMenu) {?>
        <div class="dd hide-for-small-only" id="menu_item_<?=$arrMenu["MODAL_INDEX"]?>" data-toggler-hover-dd="dd_show">
                <div class="dd__content">
                        <div class="grid-container">
                                <div class="grid-x grid-padding-x">
                                        <div class="small-6 medium-5 large-6 cell">
                                                <h5>По категориям</h5>
                                                <div class="grid-x grid-padding-x">
                                                        <div class="small-6 cell">
                                                                <ul>
                                                <?$countElements = 0;?>
                                                <?foreach ($arResult[$arrMenu["ID_ELEMENT"]]["MODAL"] as $arElement) {?>
                                                        <?if ($countElements % 6 == 0 && $countElements!=0 && $countElements!= count($arResult[$arrMenu["ID_ELEMENT"]]["MODAL"])) {?>
                                                                </ul>
                                                        </div>
                                                        <div class="small-6 cell">
                                                                <ul>
                                                        <?}?>
                                                                    <li><a href="<?=$arElement["SECTION_PAGE_URL"]?>" title=""><?=$arElement["NAME"]?></a></li>
                                                        <?$countElements++;?>
                                                <?}?>
                                                                 </ul>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="small-6 medium-4 large-3 cell">
                                                <h5>По дизайнерам</h5>
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
                                        </div>
                                        <div class="small-6 medium-3 large-3 cell text-center">
                                                <div class="margin-bottom-9"><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/i/dress.png" alt=""></a></div>
                                                <h3 class="margin-bottom-0">Платья</h3><a class="anchor" href="#">смотреть все    </a>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
    <?}?>
    <?/*Конец выпадающего меню*/?>
<?endif?>