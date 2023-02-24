<?php

namespace Lucups\Cnsms\Util;

use Lucups\Cnsms\Client\AliyunSmsClient;
use Lucups\Cnsms\Sms;

class ClientUtils
{
    /**
     * @deprecated 下一个大版本将会移除
     */
    const CHANNEL_ALIYUN = 'aliyun';

    const AVAILABLE_CHANNELS = [
        Sms::CHANNEL_ALIYUN,
    ];

    public static function createClient($channel, $config)
    {
        if (!in_array($channel, self::AVAILABLE_CHANNELS)) {
            $errMsg = 'Channel [' . $channel . '] does not support.';
            SmsLog::error($errMsg);
            throw new SmsException($errMsg);
        }

        switch ($channel) {
            case Sms::CHANNEL_ALIYUN:

                // todo exception
                $accessKeyId     = Utils::safeGet($config, 'accessKeyId');
                $accessKeySecret = Utils::safeGet($config, 'accessKeySecret');
                $signName        = Utils::safeGet($config, 'signName');
                $regionId        = Utils::safeGet($config, 'regionId', 'cn-shanghai');

                return new AliyunSmsClient($accessKeyId, $accessKeySecret, $signName, $regionId);
            case Sms::CHANNEL_TENCENT:
            case Sms::CHANNEL_SMSBAO:
                $errMsg = 'Channel [' . $channel . '] does not support now.';
                SmsLog::error($errMsg);
                throw new SmsException($errMsg);
        }
    }
}