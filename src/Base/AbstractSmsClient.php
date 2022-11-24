<?php

namespace Lucups\Cnsms\Base;

abstract class AbstractSmsClient
{
    /**
     * @param array|string $phone 如果是多个手机号码，需要使用数组传入
     * @param string $tplId 短信模板ID
     * @param array $data 模块数据
     * @return mixed
     */
    abstract function send($phone, $tplId, $data = []);
}