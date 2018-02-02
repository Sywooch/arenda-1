<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 03.03.2017
 * Time: 9:19
 */
namespace app\components\widgets\twitter;

use app\models\Ads;
use app\models\Applications;
use app\models\LeaseContractParticipants;
use app\models\LeaseContracts;
use app\models\RealEstate;
use app\models\UserPassport;
use Yii;

use yii\base\Widget;
use app\models\User;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;
use app\models\UserCustomerInfo;
use app\models\UserInfo;
use yii\helpers\Json;

class TwitterWidget extends Widget
{
	public function run()
	{
		$timeout = 3; //Seconds

		$api_key = urlencode(Yii::$app->params['twitter']['api_key']); // Consumer Key (API Key)
		$api_secret = urlencode(Yii::$app->params['twitter']['api_secret']); // Consumer Secret (API Secret)
		$data_username = Yii::$app->params['twitter']['screen_name']; // screen_name

		if (empty($api_key) || empty($api_secret) || empty($data_username)) {
			return '';
		}

		$tweets = [];

		$key = implode('_', [
			'tweets',
			$api_key,
			$api_secret,
			$data_username,
		]);

		$cache = Yii::$app->cache;

		$tweets = $cache->get($key);

		if ($tweets === false) {
			try {
				// auth parameters
				$auth_url = 'https://api.twitter.com/oauth2/token';

				// what we want?
				$data_count = 2; // number of tweets
				$data_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?tweet_mode=extended';

				// get api access token
				$api_credentials = base64_encode($api_key . ':' . $api_secret);

				$auth_headers = 'Authorization: Basic ' . $api_credentials . "\r\n" .
					'Content-Type: application/x-www-form-urlencoded;charset=UTF-8' . "\r\n";

				$auth_context = stream_context_create(
					[
						'http' => [
							'header'  => $auth_headers,
							'method'  => 'POST',
							'content' => http_build_query(['grant_type' => 'client_credentials',]),
							'timeout' => $timeout,
						],
					]
				);

				$auth_response = json_decode(file_get_contents($auth_url, 0, $auth_context), true);
				$auth_token = $auth_response['access_token'];

				// get tweets
				$data_context = stream_context_create([
					'http' => [
						'header'  => 'Authorization: Bearer ' . $auth_token . "\r\n",
						'timeout' => $timeout,
					],
				]);

				$data = json_decode(file_get_contents($data_url . '&count=' . $data_count . '&screen_name=' . urlencode($data_username), 0, $data_context), true);

				foreach ($data as $tweet) {
					$tweets[] = [
						'text'        => $tweet['full_text'],
						'name'        => $tweet['user']['name'],
						'screen_name' => $tweet['user']['screen_name'],
						'avatar'      => $tweet['user']['profile_image_url'],
					];
				}

				if (!empty($tweets)) {
					$cache->set($key, $tweets, 300);
				}

			} catch (\Exception $e) {
				// Ничего не делаем
			}
		}

		if (![$tweets] || empty($tweets)) {
			return '';
		} else {
			$content = [];
			foreach ($tweets as $tweet) {
				$content[] = $this->render('_item', $tweet);
			}

			return implode('', $content);
		}
	}
}