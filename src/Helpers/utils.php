<?php

namespace src\Helpers;

class Utils
{
    static function getArrayValueByKey($array, $key)
    {
        if (!is_array($array)) {
            return false;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return false;
    }
}
