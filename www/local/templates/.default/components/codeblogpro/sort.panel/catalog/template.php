<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($arResult['SORT']['PROPERTIES'])) { ?>
    <form method="GET">
        <div class="sort__over" id="sortbox">
            <? foreach ($arResult['SORT']['PROPERTIES'] as $property) {
                $property['NAME'] = strtolower($property['NAME']);
                ?>
                <? if ($property['ACTIVE']) { ?>
                    <div>
                        <div class="check">
                            <input class="check__input" type="checkbox" id="jsort<?= $property['CODE'] ?>" name="sort" value="<?= $property['CODE'] ?>" checked="checked">
                            <label class="check__label" for="jsort<?= $property['CODE'] ?>"><?= $property['NAME'] ?></label>
                        </div>
                    </div>
                <? } else { ?>
                    <div>
                        <div class="check">
                            <input class="check__input" type="checkbox" id="jsort<?= $property['CODE'] ?>" name="sort" value="<?= $property['CODE'] ?>">
                            <label class="check__label" for="jsort<?= $property['CODE'] ?>"><?= $property['NAME'] ?></label>
                        </div>
                    </div>
                <? }
            }?>
        </div>
        <div class="sort__footer"><a class="button margin-bottom-0 js-apply" href="javascript:void(0);">Применить</a></div>
    </form>
    <?
} ?>
