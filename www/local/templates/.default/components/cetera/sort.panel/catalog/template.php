<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!empty($arResult['SORT']['PROPERTIES'])) { ?>
    <form method="GET">
        <div class="sort__over" id="sortbox">
            <?
            $i = 0;
            foreach ($arResult['SORT']['PROPERTIES'] as $key => $property) {?>
                <div>
                    <div class="check">
                        <input class="check__input" type="radio" id="jsort<?=$i?>" name="sort" value="<?= $key ?>"<?= $property['ACTIVE'] ? ' checked="checked"' : '' ?>>
                        <label class="check__label" for="jsort<?=$i?>"><?= $property['NAME'] ?></label>
                    </div>
                </div>
                <?
                $i++;
            }?>
        </div>
        <div class="sort__footer"><a class="button margin-bottom-0 js-apply" href="javascript:void(0);">Применить</a></div>
    </form>
    <?
}