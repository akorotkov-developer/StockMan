<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<?if ($APPLICATION->GetCurPage() != "/") {?>
            </div>
        </div>
    </div>
</div>
<?}?>

<?require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/footer.php');?>