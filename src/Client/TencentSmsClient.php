<?php

namespace Lucups\Cnsms\Client;

use Lucups\Cnsms\Util\SmsLog;

/**
 * todo 腾讯云短信
 * @see https://cloud.tencent.com/document/api/382/55981
 */
class TencentSmsClient implements SmsClient
{
    public function send($phone, string $templateCode, array $data): array
    {
        SmsLog::info('Send to ' . $phone . ' with templateCode = ' . $templateCode . ', data is: ' . json_encode($data));

        // todo 待实现

        return [];
    }
}