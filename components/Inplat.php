<?php
/**
 * Created by PhpStorm.
 * User: ivphpan
 * Date: 18.03.17
 * Time: 11:35
 */

namespace app\components;


use app\models\Pay;
use app\models\User;

class Inplat
{
	public $apiKey = '';
	public $secretCode = '';
	const HOST = 'api2.inplat.ru';

	public function test()
	{
		return [
			$this->apiKey,
			$this->secretCode,
		];
	}

	public function formUrl(Pay $pay, User $user)
	{
		$data = [
			'method'     => 'form',
			'pay_type'   => 'card',
			'pay_params' => [

			],
			'params'     => [
				'id'      => $pay->id,
				'account' => $user->username,
				'sum'     => $pay->sum * 100,
				'email'   => $user->email,
				'details' => $pay->description(),
			],
		];

		$json_string = json_encode($data);
		$sign = hash_hmac('sha256', $json_string, $this->secretCode);
		$url = 'https://'.self::HOST.'/?apikey=' . $this->apiKey . '&sign=' . $sign;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
		$res = curl_exec($curl);
		curl_close($curl);
		$object = json_decode($res);
		if ($object->code == 0) {
			return $object->url . '&theme=orange';
		} else {
			//var_dump($object);
			return false;
		}
	}

	public function formLinkUrl(User $user)
	{
		$data = [
			'method'     => 'form',
			'case'       => 'link',
			'pay_type'   => 'card',
			'pay_params' => [

			],
			'client_id'  => $user->id,
			'params'     => [
				'account' => $user->username,
				'sum'     => 100,
				'details' => 'Добавление карты',
			],
		];

		$json_string = json_encode($data);
		$sign = hash_hmac('sha256', $json_string, $this->secretCode);
		$url = 'https://'.self::HOST.'/?apikey=' . $this->apiKey . '&sign=' . $sign;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
		$res = curl_exec($curl);
		curl_close($curl);
		$object = json_decode($res);
		if ($object->code == 0) {
			return $object->url . '&theme=orange';
		} else {
			//var_dump($object);
			return false;
		}
	}

	public function getLinks(User $user)
	{
		$data = [
			'method'    => 'links',
			'client_id' => $user->id,
		];

		$json_string = json_encode($data);
		$sign = hash_hmac('sha256', $json_string, $this->secretCode);
		$url = 'https://'.self::HOST.'/?apikey=' . $this->apiKey . '&sign=' . $sign;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
		$res = curl_exec($curl);
		curl_close($curl);
		$object = json_decode($res);
		if ($object->code == 0) {
			return $object->links;
		} else {
			//var_dump($object);
			return false;
		}
	}

	public function getUnlink($link_id)
	{
		$data = [
			'method'  => 'unlink',
			'link_id' => $link_id,
		];

		$json_string = json_encode($data);
		$sign = hash_hmac('sha256', $json_string, $this->secretCode);
		$url = 'https://'.self::HOST.'/?apikey=' . $this->apiKey . '&sign=' . $sign;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
		$res = curl_exec($curl);
		curl_close($curl);
		$object = json_decode($res);
		if ($object->code == 0) {
			return true;
		} else {
			//var_dump($object);
			return false;
		}
	}
}