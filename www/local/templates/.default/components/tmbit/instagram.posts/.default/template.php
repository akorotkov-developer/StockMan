<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<? if (isset($arResult["INSTAGRAM"]["posts"])){ ?>
    <div class="podium text-center"># PODIUMMARKET</div>
    <div class="girl text-center">
        <? foreach ($arResult["INSTAGRAM"]["posts"] as $key => $post){ ?>
<?/*
 				<a href="https://www.instagram.com/p/<?=$post->node->shortcode?>" target="_blank">
					<img src="<?=$post->node->thumbnail_src?>">
					<div class="instagram-info">
						<div class="instagram-icon instagram-icon--likes">
							<span><? echo number_format($post->node->edge_media_preview_like->count, 0, '.', ' '); ?> <?=GetMessage("TMBIT_INSTAGRAMPOSTS_")?></span>
						</div>
						<div class="instagram-icon instagram-icon--comments">
							<span><? echo number_format($post->node->edge_media_to_comment->count, 0, '.', ' '); ?> <?=GetMessage("TMBIT_INSTAGRAMPOSTS_")?></span>
						</div>
					</div>
				</a>
 */?>
        <div class="girl__slide">
            <a href="https://www.instagram.com/p/<?=$post->node->shortcode?>" target="_blank">
                <img src="<?=$post->node->thumbnail_src?>" alt="">
            </a>
        </div>
        <?}?>
    </div>
<?}?>
