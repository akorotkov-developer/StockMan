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

    <ul class="cloth">
        <?
        $activeItemFisrtLevel = "cloth__link_more";
        $activeItemSecondLevel = "cloth__link_more";
        $activeItemThirdLevel = "cloth__link_more";

        foreach ($arResult['ROOT'] as $key) {
            foreach ($key["CHILD"] as $depthlevelfirst) {
                if (!in_array(intval($depthlevelfirst["ID"]), $arResult["TREE_OF_SECTIONS"])) {
                    $continueFirstLevel = true;
                    $activeItemFisrtLevel = false;
                }
                /*Первый уровень*/
                if (intval($WrokCatalog->GetElmentCountBySectionID($depthlevelfirst['ID']))==0) {$displaynone = "style='display:none;'";}
                echo "<li class='cloth__item' ".$displaynone."><a href='".$depthlevelfirst['SECTION_PAGE_URL']."' class='cloth__link ".$activeItemFisrtLevel."'>".$depthlevelfirst["NAME"]."<span class='cloth__num'>".$WrokCatalog->GetElmentCountBySectionID($depthlevelfirst['ID'])."</span></a>";
                $displaynone = '';
                if ($depthlevelfirst["CHILD"]) {
                    echo "<ul class='cloth'>";
                    $firstchildul = true;
                } else {echo "</li>";}
                /*---------------*/

                foreach ($depthlevelfirst["CHILD"] as $depthlevelsecond) {
                    if ($continueFirstLevel) {
                        continue;
                    }
                    if (!in_array(intval($depthlevelsecond["ID"]), $arResult["TREE_OF_SECTIONS"])) {
                        $continueSecondLevel = true;
                        $activeItemSecondLevel = false;
                    }
                    /*Второй уровень*/
                    if (intval($WrokCatalog->GetElmentCountBySectionID($depthlevelsecond['ID']))==0) {$displaynone = "style='display:none;'";}
                    echo "<li class='cloth__item' ".$displaynone."><a href='".$depthlevelsecond['SECTION_PAGE_URL']."' class='cloth__link cloth__link_inside ".$activeItemSecondLevel."'>".$depthlevelsecond["NAME"]."<span class='cloth__num'>".$WrokCatalog->GetElmentCountBySectionID($depthlevelsecond['ID'])."</span></a>";
                    $displaynone = '';
                    if ($depthlevelsecond["CHILD"]) {
                        echo "<ul class='cloth'>";
                        $secondchildul = true;
                    } else {echo "</li>";}
                    /*---------------*/

                    foreach ($depthlevelsecond["CHILD"] as $depthlevelthird) {
                        if ($continueSecondLevel) {
                            continue;
                        }
                        if (!in_array(intval($depthlevelthird["ID"]), $arResult["TREE_OF_SECTIONS"])) {
                            $activeItemThirdLevel = false;
                        }
                        if (intval($WrokCatalog->GetElmentCountBySectionID($depthlevelthird['ID']))==0) {$displaynone = "style='display:none;'";}
                        echo "<li class='cloth__item' ".$displaynone."><a href='".$depthlevelthird['SECTION_PAGE_URL']."' class='cloth__link cloth__link_inside ".$activeItemThirdLevel."'>".$depthlevelthird["NAME"]."<span class='cloth__num'>".$WrokCatalog->GetElmentCountBySectionID($depthlevelthird['ID'])."</span></a></li>";
                        $displaynone = '';
                        $activeItemThirdLevel = "cloth__link_more";
                    }

                    /*Второй уровень*/
                    if ($secondchildul) {
                        echo '</li></ul>';
                        $secondchildul = false;
                    }
                    /*---------------*/
                    $continueSecondLevel = false;
                    $activeItemSecondLevel = "cloth__link_more";
                }

                /*Первый уровень*/
                if ($firstchildul) {
                    echo '</li></ul>';
                    $firstchildul = false;
                }
                /*---------------*/

                $continueFirstLevel =false;
                $activeItemFisrtLevel = "cloth__link_more";
            }
        }
        ?>
    </ul>

<?
}
?>