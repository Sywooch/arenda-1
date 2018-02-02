<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.04.2017
 * Time: 15:40
 */

namespace app\components\helpers;


class CadastrHelper
{
    /**
     * Приводит дату в формате dd.mm.yyyy к формату yyyy-mm-dd
     *
     * @param $date
     * @return string
     */
    public static function normalizeDate($date)
    {
        $parts = explode('.', $date);
        return implode('-', array_reverse($parts));
    }
}