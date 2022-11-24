<?php

namespace Lucups\Sms\Channel\Aliyun;

use Lucups\Sms\Base\AbstractSmsClient;
use Lucups\Sms\Util\SmsLog;

class AliyunSmsClient extends AbstractSmsClient
{
    private $accessKeyId;
    private $accessKeySecret;
    private $signName;

    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $signName
     */
    public function __construct($accessKeyId, $accessKeySecret, $signName)
    {
        $this->accessKeyId     = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->signName        = $signName;
    }


    public function send($phone, $tplId, $data = [])
    {
        SmsLog::info('Send to ' . $phone . ' with tplId = ' . $tplId . ', data is: ' . json_encode($data));

        // TODO: Implement send() method.
    }
}