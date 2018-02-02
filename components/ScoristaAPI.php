<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 24.03.2017
 * Time: 9:44
 *
 */

namespace app\components;


use app\models\ScreeningReport;
use app\models\User;

class ScoristaAPI
{
    public $username = 'ivan@igalkin.ru';
    public $token = '12e520ee87037763eb8e3237e6b82dfe696d2c3a';
    public $nonce = '';
    public $password = '';
    public $host = 'https://api.scorista.ru';

    function __construct($username=null,$token=null) {
        if($username!=null){
            $this->username = $username;
        }
        if($token!=null){
            $this->token = $token;
        }
        $this->nonce  = sha1(uniqid(true));
        $this->password = sha1($this->nonce.$this->token);
    }

    public function check()
    {
        $url = $this->host.'/mixedcheck/json';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            [
                "Content-type: application/json",
                "username: ".$this->username,
                "nonce: ".$this->nonce,
                "password: ".$this->password,
            ]
        );
        curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
        $res = curl_exec($curl);
        curl_close($curl);
        var_dump($res);
        
        return false;
    }

    public function request($scid=null,$userid=null)
    {
        if($scid!=null){
            $sr = ScreeningReport::findOne($scid);
            if($sr!=null){
                $region = json_decode(file_get_contents('http://api.print-post.com/api/index/v2/?index='.$sr->post_code));
                if(isset($region->region)){
                   $region = $region->region;
                }else{
                    $region = 'Область';
                }
                $address = explode(',',$sr->address);

                $data = [
                    'form' => [
                        'persona'=>[
                            'personalInfo'=>[
                                //"personaID"=> "3",
                                "lastName"=> $sr->name_last, //r
                                "firstName"=> $sr->name_first, //r
                                "patronimic"=> $sr->name_middle,
                                "gender"=> mb_substr($sr->name_middle,-2)=='ич'?1:2,//1 - мужской, 2 - женский //r
                                "birthDate"=> date('d.m.Y',strtotime($sr->birthday)), //r
                                "placeOfBirth"=> $sr->user->passport->place_of_birth,// "Деревня", //r
                                "passportSN"=> str_replace('-',' ',$sr->user->passport->serial_nr), //"0000 000000", //r
                                "issueDate"=> date('d.m.Y',$sr->user->passport->issued_date),//"01.01.1970", //r
                                "subCode"=> $sr->user->passport->division_code,//"000-000"
                                "issueAuthority"=> $sr->user->passport->issued_by,//r
                            ],
                            'addressRegistration'=>[
                                "postIndex"=> $sr->post_code,//"000000",//r
                                "region"=> $region,//r
                                "city"=> isset($address[0])?$address[0]:'Город',//"Город",//r
                                "street"=> isset($address[1])?$address[1]:'Улица',//"Улица",//r
                                //"house"=> "1",
                                //"building"=> "А",
                                //"flat"=> "100",
                                //"kladrID"=> "100000000"
                            ],
                            'addressResidential'=>[
                                "postIndex"=> $sr->post_code, //r
                                "region"=> $region, //r
                                "city"=> isset($address[0])?$address[0]:'Город',//"Город",//r
                                "street"=> isset($address[1])?$address[1]:'Улица',//"Улица",//r
                                //"house"=> "1",
                                //"building"=> "А",
                                //"flat"=> "100",
                                //"kladrID"=> "100000000"
                            ],
                            'contactInfo'=>[
                                'cellular'=>$sr->phone//'89876543210'
                            ],
                            'cronos'=>'1' //0 – проверка не производится, 1 – проверка производится
                        ]
                    ],
                ];
            }else{
                return false;
            }
        }elseif ($userid!=null){
            $user = User::findOne($userid);
            if($user!=null){
                $region = 'Область';
                $address = explode(',',$user->passport->place_of_residence);

                $data = [
                    'form' => [
                        'persona'=>[
                            'personalInfo'=>[
                                //"personaID"=> "3",
                                "lastName"=> $user->last_name, //r
                                "firstName"=> $user->first_name, //r
                                "patronimic"=> $user->middle_name,
                                "gender"=> mb_substr($user->middle_name,-2)=='ич'?1:2,//1 - мужской, 2 - женский //r
                                "birthDate"=> date('d.m.Y',$user->date_of_birth), //r
                                "placeOfBirth"=> $user->passport->place_of_birth,// "Деревня", //r
                                "passportSN"=> str_replace('-',' ',$user->passport->serial_nr), //"0000 000000", //r
                                "issueDate"=> date('d.m.Y',$user->passport->issued_date),//"01.01.1970", //r
                                "subCode"=> $user->passport->division_code,//"000-000"
                                "issueAuthority"=> $user->passport->issued_by,//r
                            ],
                            'addressRegistration'=>[
                                "postIndex"=> "000000",//"000000",//r
                                "region"=> $region,//r
                                "city"=> isset($address[0])?$address[0]:'Город',//"Город",//r
                                "street"=> isset($address[1])?$address[1]:'Улица',//"Улица",//r
                                //"house"=> "1",
                                //"building"=> "А",
                                //"flat"=> "100",
                                //"kladrID"=> "100000000"
                            ],
                            'addressResidential'=>[
                                "postIndex"=> "000000",//"000000",//r
                                "region"=> $region, //r
                                "city"=> isset($address[0])?$address[0]:'Город',//"Город",//r
                                "street"=> isset($address[1])?$address[1]:'Улица',//"Улица",//r
                                //"house"=> "1",
                                //"building"=> "А",
                                //"flat"=> "100",
                                //"kladrID"=> "100000000"
                            ],
                            'contactInfo'=>[
                                'cellular'=>$user->phone//'89876543210'
                            ],
                            'cronos'=>'1' //0 – проверка не производится, 1 – проверка производится
                        ]
                    ],
                ];
            }else{
                return false;
            }
        }else{
            return false;
        }
        

        $json_string = json_encode($data);
        $url = $this->host.'/dossier/json';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            [
                "Content-type: application/json",
                "username: ".$this->username,
                "nonce: ".$this->nonce,
                "password: ".$this->password,
            ]
        );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
        $res = curl_exec($curl);
        curl_close($curl);
        $object = json_decode($res);
        return $object;
        //var_dump($object);//use $object->requestid or $object->status //object(stdClass)#78 (2) { ["status"]=> string(2) "OK" ["requestid"]=> string(18) "agrid58d4abf94c4f3" }
    }
    public function checkRequest($id)
    {
        $data = [
            'requestID'=> $id
        ];

        $json_string = json_encode($data);
        $url = $this->host.'/dossier/json';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            [
                "Content-type: application/json",
                "username: ".$this->username,
                "nonce: ".$this->nonce,
                "password: ".$this->password,
            ]
        );
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
        $res = curl_exec($curl);
        curl_close($curl);
        $object = json_decode($res);
        return $object;
    }
}