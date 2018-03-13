<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?>

    <div class="content padding-bottom-0">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell margin-bottom-10">
                    <div class="text-size-xxxlarge text-center">Выберите интересующий вас раздел</div>
                </div>
            </div>
            <div class="grid-x grid-padding-x medium-up-3 text-center margin-bottom-20">
                <?
                $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID" => StockMan\Config::CATALOG_ID, "SECTION_ID"=>false, "ACTIVE"=>"Y"), false);
                while ($uf_value = $uf_arresult->GetNext()) {
                    $res = CIBlockSection::GetByID($uf_value["ID"]);
                    if($ar_res = $res->GetNext()) {
                        $pic = CFile::GetFileArray($ar_res['PICTURE']);
                    }
                ?>
                    <div class="cell margin-bottom-5">
                        <p><a href="<?=$uf_value['SECTION_PAGE_URL']?>"> <img src="<?=$pic['SRC'];?>" alt=""></a></p><a class="kind" href="<?=$uf_value['SECTION_PAGE_URL']?>"><?=$uf_value["NAME"];?></a>
                    </div>
                <?}?>
            </div>
            <div class="grid-x grid-padding-x align-center">
                <div class="cell large-11">
                    <hr class="margin-vertical-7 hr">
                    <div class="grid-x grid-padding-x medium-up-4 small-up-2 large-up-8 text-center margin-bottom-20">
                        <div class="cell aligner">
                            <p><a><img src="/i/d11.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d21.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d31.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d4.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d5.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d6.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d7.png" alt=""></a></p>
                        </div>
                        <div class="cell aligner">
                            <p><a><img src="/i/d8.png" alt=""></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="background-light-gray padding-top-15 padding-bottom-4">
            <div class="grid-container">
                <div class="grid-x grid-padding-x align-justify text-dark-gray text-size-xlarge text-center large-text-left">
                    <div class="cell large-3 medium-4">
                        <div class="grid-x grid-padding-x">
                            <div class="large-3 cell margin-bottom-3"><img src="<?=SITE_TEMPLATE_PATH?>/images/ruble.svg" alt=""></div>
                            <div class="large-9 cell padding-top-3">Доступные цены</div>
                            <div class="cell text-size-xsmall text-center margin-bottom-8">Мы предлагаем самые выгодные цены и условия доставки</div>
                        </div>
                    </div>
                    <div class="cell large-3 medium-4">
                        <div class="grid-x grid-padding-x">
                            <div class="large-3 cell margin-bottom-3"><img src="<?=SITE_TEMPLATE_PATH?>/images/quality.svg" alt=""></div>
                            <div class="large-9 cell padding-top-3">Качественный товар</div>
                            <div class="cell text-size-xsmall text-center margin-bottom-8">Качество товара проверяется и соответствует самым высоким стандартам</div>
                        </div>
                    </div>
                    <div class="cell large-3 medium-4">
                        <div class="grid-x grid-padding-x">
                            <div class="large-3 cell margin-bottom-3"><img src="<?=SITE_TEMPLATE_PATH?>/images/fast.svg" alt=""></div>
                            <div class="large-9 cell padding-top-3">Быстрая доставка</div>
                            <div class="cell text-size-xsmall text-center margin-bottom-8">Мы предлагаем самые выгодные цены и услуги доставки</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>