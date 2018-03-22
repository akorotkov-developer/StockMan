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

if (!$arResult["NavShowAlways"])
{
	if (0 == $arResult["NavRecordCount"] || (1 == $arResult["NavPageCount"] && false == $arResult["NavShowAll"]))
		return;
}
if ('' != $arResult["NavTitle"])
	$arResult["NavTitle"] .= ' ';

$strSelectPath = $arResult['sUrlPathParams'].($arResult["bSavePage"] ? '&PAGEN_'.$arResult["NavNum"].'='.(true !== $arResult["bDescPageNumbering"] ? 1 : '').'&' : '').'SHOWALL_'.$arResult["NavNum"].'=0&SIZEN_'.$arResult["NavNum"].'=';

?>
<div class="cell">
    <div class="text-center">
        <?
        if ($arResult["NavShowAll"])
        {
            ?>
            <ul class="pagination">
                <li><a href="<?=$arResult['sUrlPathParams']; ?>SHOWALL_<?=$arResult["NavNum"]?>=0&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>"><? echo GetMessage('nav_show_pages'); ?></a></li>
            </ul>
            <?
        }
        else
        {
            ?>
            <ul class="pagination">
            <?
            if (true === $arResult["bDescPageNumbering"])
            {
                if ($arResult["NavPageNomer"] < $arResult["NavPageCount"])
                {
                    ?>
                    <li class="pagination-next">
                        <a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>"
                           title="<? echo GetMessage('nav_prev_title'); ?>"
                           aria-label="<? echo GetMessage('nav_prev_title'); ?>"><? echo GetMessage('nav_prev_title'); ?></a>
                    </li>
                    <?
                }
                else
                {

                }
                $NavRecordGroup = $arResult["NavPageCount"];
                while ($NavRecordGroup >= 1)
                {
                    $NavRecordGroupPrint = $arResult["NavPageCount"] - $NavRecordGroup + 1;
                    $strTitle = GetMessage(
                        'nav_page_num_title',
                        array('#NUM#' => $NavRecordGroupPrint)
                    );
                    if ($NavRecordGroup == $arResult["NavPageNomer"])
                    {
                        ?><li class="current <?if ($NavRecordGroup == 1){?>pagination__first<?}?> <?if ($NavRecordGroup == $arResult["nEndPage"]){?>pagination__last<?}?>" title="<? echo GetMessage('nav_page_current_title'); ?>"><? echo $NavRecordGroupPrint; ?></li><?
                    }
                    elseif ($NavRecordGroup == $arResult["NavPageCount"] && $arResult["bSavePage"] == false)
                    {
                        ?><li class="<?if ($NavRecordGroup == 1){?>pagination__first<?}?>"><a href="<?=$arResult['sUrlPathParams']; ?>SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>"><?=$NavRecordGroupPrint?></a></li><?
                    }
                    else
                    {
                        ?><li class="<?if ($NavRecordGroup == $arResult["nEndPage"]){?>pagination__last<?}?>"><a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=$NavRecordGroup?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>"><?=$NavRecordGroupPrint?></a></li><?
                    }
                    if (1 == ($arResult["NavPageCount"] - $NavRecordGroup) && 2 < ($arResult["NavPageCount"] - $arResult["nStartPage"]))
                    {
                        $middlePage = floor(($arResult["nStartPage"] + $NavRecordGroup)/2);
                        $NavRecordGroupPrint = $arResult["NavPageCount"] - $middlePage + 1;
                        $strTitle = GetMessage(
                            'nav_page_num_title',
                            array('#NUM#' => $NavRecordGroupPrint)
                        );
                        ?><li><a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middlePage?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>">...</a></li><?
                        $NavRecordGroup = $arResult["nStartPage"];
                    }
                    elseif ($NavRecordGroup == $arResult["nEndPage"] && 3 < $arResult["nEndPage"])
                    {
                        $middlePage = ceil(($arResult["nEndPage"] + 2)/2);
                        $NavRecordGroupPrint = $arResult["NavPageCount"] - $middlePage + 1;
                        $strTitle = GetMessage(
                            'nav_page_num_title',
                            array('#NUM#' => $NavRecordGroupPrint)
                        );
                        ?><li><a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middlePage?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>">...</a></li><?
                        $NavRecordGroup = 2;
                    }
                    else
                    {
                        $NavRecordGroup--;
                    }
                }

                if ($arResult["NavPageNomer"] > 1)
                {
                    ?>
                    <li class="pagination-next">
                        <a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>"
                           title="<? echo GetMessage('nav_next_title'); ?>"
                           aria-label="<? echo GetMessage('nav_next_title'); ?>"><? echo GetMessage('nav_next_title'); ?></a>
                    </li><?
                }
                else
                {

                }
            }
            else
            {

                if (1 < $arResult["NavPageNomer"])
                {
                    ?>
                    <li class="pagination-next">
                        <a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>"
                           title="<? echo GetMessage('nav_prev_title'); ?>"
                           aria-label="<? echo GetMessage('nav_prev_title'); ?>"><? echo GetMessage('nav_prev_title'); ?></a>
                    </li>
                    <?
                }
                else
                {

                }
                $NavRecordGroup = 1;
                while($NavRecordGroup <= $arResult["NavPageCount"])
                {
                    $strTitle = GetMessage(
                        'nav_page_num_title',
                        array('#NUM#' => $NavRecordGroup)
                    );
                    if ($NavRecordGroup == $arResult["NavPageNomer"])
                    {
                        ?><li class="current <?if ($NavRecordGroup == 1){?>pagination__first<?}?> <?if ($NavRecordGroup == $arResult["nEndPage"]){?>pagination__last<?}?>" title="<? echo GetMessage('nav_page_current_title'); ?>"><? echo $NavRecordGroup; ?></li><?
                    }
                    elseif ($NavRecordGroup == 1 && $arResult["bSavePage"] == false)
                    {
                        ?><li class="<?if ($NavRecordGroup == 1){?>pagination__first<?}?>"><a href="<?=$arResult['sUrlPathParams']; ?>SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>"><?=$NavRecordGroup?></a></li><?
                    }
                    else
                    {
                        ?><li class="<?if ($NavRecordGroup == $arResult["NavPageCount"]){?>pagination__last<?}?>"><a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=$NavRecordGroup?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>"><?=$NavRecordGroup?></a></li><?
                    }
                    if ($NavRecordGroup == 2 && $arResult["nStartPage"] > 3 && $arResult["nStartPage"] - $NavRecordGroup > 1)
                    {
                        $middlePage = ceil(($arResult["nStartPage"] + $NavRecordGroup)/2);
                        $strTitle = GetMessage(
                            'nav_page_num_title',
                            array('#NUM#' => $middlePage)
                        );
                        ?><li><a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middlePage?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>">...</a></li><?
                        $NavRecordGroup = $arResult["nStartPage"];
                    }
                    elseif ($NavRecordGroup == $arResult["nEndPage"] && $arResult["nEndPage"] < ($arResult["NavPageCount"] - 2))
                    {
                        $middlePage = floor(($arResult["NavPageCount"] + $arResult["nEndPage"] - 1)/2);
                        $strTitle = GetMessage(
                            'nav_page_num_title',
                            array('#NUM#' => $middlePage)
                        );
                        ?><li><a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middlePage?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>" title="<? echo $strTitle; ?>">...</a></li><?
                        $NavRecordGroup = $arResult["NavPageCount"]-1;
                    }
                    else
                    {
                        $NavRecordGroup++;
                    }
                }
                if ($arResult["NavPageNomer"] < $arResult["NavPageCount"])
                {
                    ?>
                    <li class="pagination-next">
                        <a href="<?=$arResult['sUrlPathParams']; ?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult['NavPageSize']; ?>"
                           title="<? echo GetMessage('nav_next_title'); ?>"
                           aria-label="<? echo GetMessage('nav_next_title'); ?>"><? echo GetMessage('nav_next_title'); ?></a>
                    </li><?
                }
                else
                {
                }
                if ($arResult["bShowAll"])
                {
                    ?><li><a href="<?=$arResult['sUrlPathParams']; ?>SHOWALL_<?=$arResult["NavNum"]?>=1&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageSize"]?>"><? echo GetMessage('nav_all'); ?></a></li><?
                }
            }
            ?>
            </ul><?
        }
        ?>
    </div>
</div>
