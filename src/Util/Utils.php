<?php

namespace Lucups\Cnsms\Util;

class Utils
{
    public static function safeGet($arr, $key, $default = null)
    {
        return array_key_exists($key, $arr) ? $arr[$key] : $default;
    }
}