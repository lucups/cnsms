<?php

namespace Lucups\Cnsms\Client;

use Lucups\Cnsms\Util\SmsLog;

/**
 * 腾讯云短信
 * @see https://cloud.tencent.com/document/api/382/55981
 */
class TencentSmsClient implements SmsClient
{
    public function send($phone, $templateCode, $data)
    {
        SmsLog::info('Send to ' . $phone . ' with templateCode = ' . $templateCode . ', data is: ' . json_encode($data));
    }
}