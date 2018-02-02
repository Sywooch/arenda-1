<?php

namespace app\commands;

use app\components\helpers\CommonHelper;
use yii\console\Controller;
use app\models\AdBoard;
use app\models\Ads;
use yii;

class AdsFeedController extends Controller
{
    public function actionIndex($board=null)
    {
		$query = AdBoard::find();
        if ($board) {
			$query->where(['code' => explode(',', $board)]);
		}
		$query->where(['enabled' => 1]);
		$boards = $query->all();
		foreach ($boards as $board) {
			$this->buildFeed($board);
		}
    }
    
    protected function buildFeed($board)
    {
		if ($board->rebuildRequired()) {
			echo "Rebuilding feed for {$board->name}...\n";
			$dir = yii::getAlias('@app/web/adboards/export');
			$target = sprintf('%s.xml', $board->code);
			$tmpfile = sprintf('%s-new.xml', $board->code);
			if (!is_dir($dir)) {
				if (!@mkdir($dir)) {
					throw new \Exception('Can not create directory ' . $dir);
				}
			} elseif (!is_writable($dir)) {
				throw new \Exception('Directory ' . $dir . ' is not writable');
			}
			$f = @fopen($dir . '/' . $tmpfile, 'w');
			if (!is_resource($f)) {
				throw new \Exception('Can not write to ' . $dir . '/' . $tmpfile);
			}
			fwrite($f, $board->renderFeedHeader());
			$counter = 0;
			foreach ($board->eachAdvert() as $advert) {
				$counter++;
				fwrite($f, $board->renderFeedElement(array_merge($advert->getFeedData($board), ['sequence' => $counter])));
			}
			fwrite($f, $board->renderFeedFooter());
			fclose($f);
			if (is_file($dir . '/' . $target)) {
				@unlink($dir . '/' . $target);
			}
			@rename($dir . '/' . $tmpfile, $dir . '/' . $target);
			$board->updateAttributes([
				'ads_count' => $counter,
				'feed_updated' => time(),
			]);
			echo "Done! $counter advert(s) have been published.\n";
		} else {
			echo "Feed for {$board->name} does not require to be updated.\n";
		}
	}
}
