<?php

namespace src\Helpers;

class Json
{
    static function clear($path)
    {
        file_put_contents($path, '');
    }

    static function read($path)
    {
        return json_decode(file_get_contents($path), true);
    }

    static function write($path, $params)
    {
        file_put_contents($path, json_encode($params));
        return self::read($path);
    }
}
