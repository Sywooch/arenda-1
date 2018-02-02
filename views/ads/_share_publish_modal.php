<?php
use app\components\extend\Url;
?>
<!-- sharePublish -->
<div style="display: none;">
	<div class="box-modal modal" id='sharePublish'>
		<div class="modal__close box-modal_close arcticmodal-close"></div>
		<div class="modal__wr">
			<h2 class="modal__title">Поделиться объявлением</h2>
			<div class="modal__body">

				<div class="copy-link">
					<input id="copy_text2" type="text" value="<?= Url::toRoute(['/ads/view', 'id' => $model->primaryKey], true); ?>">
					<div class="copy-link__btn" data-clipboard-target="#copy_text2">
						<img src="/images/files-i.png" alt="">
					</div>
				</div>

				<p class="sub sub--t">
					<?= $this->render('//_general/pluso_sharing'); ?>
				</p>
			</div>
		</div>
	</div>
</div>
<!-- end sharePublish -->