<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!empty($arResult['SORT']['PROPERTIES'])) { ?>
    <form method="GET">
        <div class="sort__over" id="sortbox">
            <? foreach ($arResult['SORT']['PROPERTIES'] as $key => $property) {?>
                <? if ($property['ACTIVE']) { ?>
                    <div>
                        <div class="check">
                            <input class="check__input" type="radio" id="jsort<?=$key?>" name="sort" value="<?= $property['CODE'] ?>" checked="checked" data-direction="<?=$property['DIRECTION']?>">
                            <label class="check__label" for="jsort<?=$key?>"><?= $property['NAME'] ?></label>
                        </div>
                    </div>
                <? } else { ?>
                    <div>
                        <div class="check">
                            <input class="check__input" type="radio" id="jsort<?=$key?>" name="sort" value="<?= $property['CODE'] ?>" data-direction="<?=$property['DIRECTION']?>">
                            <label class="check__label" for="jsort<?=$key?>"><?= $property['NAME'] ?></label>
                        </div>
                    </div>
                <? }
            }?>
        </div>
        <div class="sort__footer"><a class="button margin-bottom-0 js-apply" href="javascript:void(0);">Применить</a></div>
    </form>
    <?
}