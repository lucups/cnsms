<?php

namespace Lucups\Cnsms\Client;

interface SmsClient
{
    /**
     * 模板短信统一配置
     *
     * @param string|array $phone 单个或多个手机号码，多个使用数组
     * @param string $templateCode
     * @param array $data
     * @return array
     */
    function send($phone, string $templateCode, array $data = []): array;
}