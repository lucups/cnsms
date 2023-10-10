<?php

namespace Lucups\Cnsms\Util;

use Lucups\Cnsms\Client\AliyunSmsClient;
use Lucups\Cnsms\Client\SmsBaoClient;
use Lucups\Cnsms\Client\TencentSmsClient;
use Lucups\Cnsms\Sms;

class ClientUtils
{
    /**
     * @deprecated 下一个大版本将会移除
     */
    const CHANNEL_ALIYUN = 'aliyun';

    const AVAILABLE_CHANNELS = [
        Sms::CHANNEL_ALIYUN,
        Sms::CHANNEL_TENCENT,
        Sms::CHANNEL_SMSBAO,
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
                // todo exception
                $secretId = Utils::safeGet($config, 'secretId');
                $secKey   = Utils::safeGet($config, 'secKey');
                $appId    = Utils::safeGet($config, 'appId');
                $signName = Utils::safeGet($config, 'signName');
                $region   = Utils::safeGet($config, 'region', 'ap-nanjing');

                return new TencentSmsClient($secretId, $secKey, $appId, $signName, $region);
            case Sms::CHANNEL_SMSBAO:
                $username = Utils::safeGet($config, 'username');
                $password = Utils::safeGet($config, 'password');
                $apiKey   = Utils::safeGet($config, 'apiKey');
                return new SmsBaoClient($username, $password, $apiKey);
        }
    }
}