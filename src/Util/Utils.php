<?php

namespace Lucups\Sms\Util;

class Utils
{
    public static function safeGet($arr, $key, $default = null)
    {
        return array_key_exists($key, $arr) ? $arr[$key] : $default;
    }
}