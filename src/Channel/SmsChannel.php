<?php

namespace Lucups\Cnsms\Channel;

use Lucups\Cnsms\Channel\Aliyun\AliyunSmsClient;
use Lucups\Cnsms\Exception\SmsException;
use Lucups\Cnsms\Util\SmsLog;

class SmsChannel
{
    const CHANNEL_ALIYUN  = 'aliyun';  // 阿里云短信服务
    const CHANNEL_TENCENT = 'tencent'; // 腾讯云短信服务
    const CHANNEL_SMSBAO  = 'smsbao';  // 短信宝

    const AVAILABLE_CHANNELS = [
        self::CHANNEL_ALIYUN,
    ];

    public static function initClient($channel, $useEnv, $config)
    {
        if (!array_key_exists($channel, self::AVAILABLE_CHANNELS)) {
            $errMsg = 'Channel [' . $channel . '] does not support.';
            SmsLog::error($errMsg);
            throw new SmsException($errMsg);
        }

        switch ($channel) {
            case self::CHANNEL_ALIYUN:
                if ($useEnv) {
                    $accessKeyId     = $_ENV['ALI_SMS_ACCESS_KEY_ID'];
                    $accessKeySecret = $_ENV['ALI_SMS_ACCESS_KEY_SECRET'];
                    $signName        = $_ENV['ALI_SMS_SIGN_NAME'];
                } else {
                    $accessKeyId     = $config['accessKeyId'];
                    $accessKeySecret = $config['accessKeySecret'];
                    $signName        = $config['signName'];
                }
                return new AliyunSmsClient($accessKeyId, $accessKeySecret, $signName);
            case self::CHANNEL_TENCENT:
            case self::CHANNEL_SMSBAO:
                $errMsg = 'Channel [' . $channel . '] does not support now.';
                SmsLog::error($errMsg);
                throw new SmsException($errMsg);
        }
    }
}