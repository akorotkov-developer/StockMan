<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(is_array($arResult['BANNERS']) && !empty($arResult['BANNERS'])){?>
    <div class="sale margin-bottom-9">
        <?foreach($arResult['BANNERS'] as $arBanner){
            $arBannerTemp = unserialize($arBanner["FIELDS"]["TEMPLATE"]);
            if ($arBannerTemp['NAME'] == 'bootstrap') {
                $url = $arBannerTemp["PROPS"][0]["LINK_URL"];
                $url = CAdvBanner::PrepareHTML($url, $arBanner["FIELDS"]);
                $url = CAdvBanner::GetRedirectURL($url, $arBanner["FIELDS"]);
                $arPic = unserialize($arBanner["FIELDS"]["TEMPLATE_FILES"]);

                $img = CFile::GetPath($arPic[0]["IMG"]);
                $imgMobile = $img;
                if (intval($arPic[1]["IMG"])>0) {
                    $imgMobile = CFile::GetPath($arPic[1]["IMG"]);
                }
                ?>
                <a class="sale__slide" href="<?= $url ?>"
                   style="background-image:url(<?= $img ?>);">
                    <div class="sale__mobile" style="background-image:url(<?= $imgMobile ?>?>);"></div>
                </a>
                <?
            } else {
                $dom = new DOMDocument;
                $dom->loadHTML($arBanner['HTML']);
                foreach ($dom->getElementsByTagName('a') as $node) {
                    $arRes["LINK_BANNER"] = $node->getAttribute('href');
                }
                foreach ($dom->getElementsByTagName('img') as $node) {
                    $arRes["IMG_BANNER"] = $node->getAttribute('src');
                }
                ?>
                <a class="sale__slide" href="<?= $arRes["LINK_BANNER"] ?>"
                   style="background-image:url(<?= $arRes["IMG_BANNER"] ?>);">
                    <div class="sale__mobile" style="background-image:url(<?= $arRes["IMG_BANNER"] ?>?>);"></div>
                </a>
                <?
            }
        }?>
    </div>
    <?
    if (count($arResult['BANNERS'])==1) {
        ?><style>.sale .slick-dots { display: none;}</style><?
    }
    ?>
<?}?>