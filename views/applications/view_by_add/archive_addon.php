<?php
use app\models\Ads;
use app\components\extend\Html;
use app\components\extend\Url;
use app\models\Applications;

?>

<?php if (!$isArchive): ?>
	<button type="button" class="btn btn-round btn-tp"
	        onclick="window.location = $(this).data('href')"
	        data-href="<?= Url::to(['/applications/view-by-ad', 'id' => isset($model->primaryKey)?$model->primaryKey:'0', 'archive' => 1]) ?>"
	>
		Архив
		<?php
		$archiveCount = Applications::getArchiveCount();
		if ($archiveCount > 0) {
			echo Html::tag('sup', $archiveCount);
		} else {
			echo Html::tag('sup', '&nbsp');
		}
		?>
	</button>
<?php endif; ?>