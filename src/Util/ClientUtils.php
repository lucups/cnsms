<?php

namespace Lucups\Cnsms\Util;

use Lucups\Cnsms\Client\AliyunSmsClient;

class ClientUtils
{
    const CHANNEL_ALIYUN  = 'aliyun';  // 阿里云短信服务
    const CHANNEL_TENCENT = 'tencent'; // 腾讯云短信服务
    const CHANNEL_SMSBAO  = 'smsbao';  // 短信宝

    const AVAILABLE_CHANNELS = [
        self::CHANNEL_ALIYUN,
    ];

    public static function createClient($channel, $config)
    {
        if (!in_array($channel, self::AVAILABLE_CHANNELS)) {
            $errMsg = 'Channel [' . $channel . '] does not support.';
            SmsLog::error($errMsg);
            throw new SmsException($errMsg);
        }

        switch ($channel) {
            case self::CHANNEL_ALIYUN:

                // todo exception
                $accessKeyId     = Utils::safeGet($config, 'accessKeyId');
                $accessKeySecret = Utils::safeGet($config, 'accessKeySecret');
                $signName        = Utils::safeGet($config, 'signName');
                $regionId        = Utils::safeGet($config, 'regionId', 'cn-shanghai');

                return new AliyunSmsClient($accessKeyId, $accessKeySecret, $signName, $regionId);
            case self::CHANNEL_TENCENT:
            case self::CHANNEL_SMSBAO:
                $errMsg = 'Channel [' . $channel . '] does not support now.';
                SmsLog::error($errMsg);
                throw new SmsException($errMsg);
        }
    }
}