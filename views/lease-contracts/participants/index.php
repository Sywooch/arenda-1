<div class="lk-temp__container lk-temp__container_residents">
	<?php
	foreach ($model->participants as $participant) {
		echo $this->render('_item', [
			'model' => $participant,
		]);
	}
	?>
</div>