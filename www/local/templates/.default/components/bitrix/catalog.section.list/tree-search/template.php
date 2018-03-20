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

$strTitle = "";
?>
<div class="hide-for-small-only" id="menu-left">
    <?/*<div class="margin-bottom-2"><a class="text-uppercase text-decoration-none" href="#">Вся одежда</a></div>*/?>
	<?
	$TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
	$CURRENT_DEPTH = $TOP_DEPTH;

	foreach($arResult["SECTIONS"] as $arSection)
	{
	    $flag = false;
	    if ($arSection["ELEMENT_CNT"] > 0) {
            if ($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"]) {
                $flag = true;
                echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH), "<ul class=\"cloth\">";
            } elseif ($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"]) {
                $flag = true;
                echo "</li>";
            } else {
                while ($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"]) {
                    echo "</li>";
                    echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</ul>", "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH - 1);
                    $CURRENT_DEPTH--;
                }
                echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</li>";
            }

            $count = "";//$arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"] ? "&nbsp;<span class=\"cloth__num\">".$arSection["ELEMENT_CNT"]."</span>" : "";

            if ($_REQUEST['SECTION_ID'] == $arSection['ID']) {
                $link = '<b>' . $arSection["NAME"] . $count . '</b>';
                $strTitle = $arSection["NAME"];
            } else {
                $cl = '';
                if ($flag) {
                    $cl = 'cloth__link_inside';
                }
                $link = '<a class="cloth__link ' . $cl .'" href="' . $arSection["SECTION_PAGE_URL"] . '">' . $arSection["NAME"] . $count . '</a>';
            }

            echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH);
            ?>
            <li class="cloth__item"><?= $link ?><?
        $CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
        }
	}

	while($CURRENT_DEPTH > $TOP_DEPTH)
	{
		echo "</li>";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	?>
</div>
<?=($strTitle?'<br/><h2>'.$strTitle.'</h2>':'')?>
