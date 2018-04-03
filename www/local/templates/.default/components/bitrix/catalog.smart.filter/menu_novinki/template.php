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

$arSearchable = ['TSVET', 'BRAND'];

$arExcluded = ['DISCOUNT'];

?>

    <?
    foreach($arResult["ITEMS"] as $key=>$arItem)
    {
        if ($arItem['CODE'] == StockMan\Config::PROP_NOVINKA) {
            $HTML_VALUE_ALT = false;
            $HTML_VALUE = '';
            foreach($arItem["VALUES"] as $keyVal=>$arItemVal)
            {
                $HTML_VALUE_ALT = $arItemVal['HTML_VALUE_ALT'];
                $HTML_VALUE = $arItemVal['HTML_VALUE'];
            }
            $strFilter = 'sFS_'. $arItem['ID'] . '_' . $HTML_VALUE_ALT . '=' . $HTML_VALUE;

            $url = $arParams['SECTION_PAGE_URL'] . '?'. $strFilter . '&set_filter=Применить';
            if ($HTML_VALUE_ALT !== false) { ?>
                <li class="menu-base__item">
                    <a class="menu-base__link" href="<?= $url ?>">
                        <img class="show-for-small-only"
                             src="<?= StockMan\Config::STOCKMAN_TEMPLATE_PATH ?>/images/new.svg" alt="Новинки"> Новинки
                    </a>
                </li>
                <?
            }
        }
    }
    ?>