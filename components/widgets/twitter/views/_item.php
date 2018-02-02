<?php
/**
 * Created by PhpStorm.
 * User: acid
 * Date: 30.03.17
 * Time: 13:59
 */

?>

<div class="b-follow-l__item">
	<div class="b-follow-l__item-top">
		<div class="b-follow-l__item-t">
			<a href="https://twitter.com/<?= $screen_name ?>" target="_blank">
				<img src="<?= $avatar ?>" alt="<?= $screen_name ?>">
				<div class="b-follow-l__txt">
					<p class="b-follow-l__mt"><?= $name ?></p>
					<p class="b-follow-l__tag">@<?= $screen_name ?></p>
				</div>
			</a>
		</div>
		<div class="b-follow-l__item-link">
			<a href="https://twitter.com/<?= $screen_name ?>" target="_blank" class="btn btn--follow-tw">Подписаться</a>
		</div>
	</div>
	<div class="b-follow-l__item-bottom">
		<?= $text ?>
	</div>
</div>
