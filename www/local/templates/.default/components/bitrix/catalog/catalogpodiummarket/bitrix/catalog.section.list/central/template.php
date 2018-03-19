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
    <div class="grid-x grid-padding-x">
        <div class="cell margin-bottom-10">
            <div class="text-size-xxxlarge text-center">Выберите интересующий вас раздел</div>
        </div>
    </div>
    <div class="grid-x grid-padding-x medium-up-3 text-center margin-bottom-20">
        <?foreach ($arResult['SECTIONS'] as &$arSection)
        {
            if (false === $arSection['PICTURE'])
                $arSection['PICTURE'] = array(
                    'SRC' => $this->GetFolder().'/images/tile-empty.png',
                    'ALT' => (
                    '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                        : $arSection["NAME"]
                    ),
                    'TITLE' => (
                    '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                        : $arSection["NAME"]
                    )
                );
            ?>
            <div class="cell margin-bottom-5">
                <p>
                    <a title="<? echo $arSection['PICTURE']['TITLE']; ?>" href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                        <img src="<? echo $arSection['PICTURE']['SRC']; ?>" alt="<? echo $arSection['PICTURE']['TITLE']; ?>">
                    </a>
                </p>
                <a class="kind" href="<? echo $arSection['SECTION_PAGE_URL']; ?>"><? echo $arSection['NAME']; ?></a>
            </div>
            <?
        }
        unset($arSection);?>
    </div>
<?
}
?>