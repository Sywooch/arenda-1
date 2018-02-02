<?php

namespace app\components\helpers;

class StringHelper extends \yii\helpers\StringHelper
{

    /**
     * will replace all tags: {attribute} with object attribute values
     * @param string $string
     * @param object/array $data
     * @param array $matchBetween default ['{','}']
     * @return string
     */
    public function replaceTagsWithDatatValues($string, $data, $matchBetween = ['{', '}'])
    {
        preg_match_all('#{(.*?)}#', $string, $matches);
        if (isset($data['image_url'])) {
            $string=str_replace('{%background_image%}', $data['image_url'], $string);
        }
        $params = [];
        if (count($matches) > 0) {
            if (array_key_exists(1, $matches) && is_array($matches[1])) {
                foreach ($matches[1] as $k)
                    $params[$matchBetween[0] . $k . $matchBetween[1]] = $k;
            }
        }
        foreach ($params as $k => $v) {
            try {
                $string = is_object($data) ?
                        (@$data->{$v} !== null ? str_replace($k, $data->{$v}, $string) : $string) :
                        (@$data[$v] !== null ? str_replace($k, $data[$v], $string) : $string);
            } catch (Exception $exc) {
                continue;
            }
        }
        return $string;
    }

    /**
     * transliterate from Russian to English and reverse
     * @param string $string
     * @return mixed
     */
    public function transliterate($string = null, $reverse = false)
    {
        $c = array(
            'ж', 'ч', 'щ', 'ш', 'ю', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
            'Ж', 'Ч', 'Щ', 'Ш', 'Ю', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я');
        $l = array(
            'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q',
            'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q');
        if (!$reverse) {
            return str_replace($c, $l, $string);
        } else {
            return str_replace($l, $c, $string);
        }
        return null;
    }

    /**
     * check if string contain substring
     * @param string $string
     * @param string $substring
     * @param mixed $ifFound default: true
     * @param mixed $ifNotFound default: false
     * @return boolean
     */
    public function contain($string, $substring, $ifFound = true, $ifNotFound = false)
    {
        if (strpos($string, $substring) !== false) {
            return $ifFound;
        }
        return $ifNotFound;
    }

    public static function dateToText($date=false){
        $ar = [
            1 => 'первого',
            2 => 'второго',
            3 => 'третьего',
            4 => 'четвертого',
            5 => 'пятого',
            6 => 'шестого',
            7 => 'седьмого',
            8 => 'восьмого',
            9 => 'девятого',
            10 => 'десятого',
            11 => 'одиннадцатого',
            12 => 'двенадцатого',
            13 => 'тринадцатого',
            14 => 'четырнадцатого',
            15 => 'пятнадцатого',
            16 => 'шестнадцатого',
            17 => 'семнадцатого',
            18 => 'восемнадцатого',
            19 => 'девятнадцатого',
            20 => 'двадцатого',
            21 => 'двадцать первого',
            22 => 'двадцать второго',
            23 => 'двадцать третого',
            24 => 'двадцать четвертого',
            25 => 'двадцать пятого',
            26 => 'двадцать шестого',
            27 => 'двадцать седмого',
            28 => 'двадцать восьмого',
            29 => 'двадцать двятого',
            30 => 'тридцатого',
            31 => 'тридцать первого',
        ];

        if($date){
            if(isset($ar[$date])){
                return $ar[$date];
            }else{
                return 'не известно';
            }
        }else{
            return $ar;
        }
    }

}
