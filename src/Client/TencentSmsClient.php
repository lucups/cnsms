<?php

namespace Lucups\Cnsms\Client;

use Lucups\Cnsms\Util\SmsLog;

/**
 * 腾讯云短信
 * @see https://cloud.tencent.com/document/api/382/55981
 */
class TencentSmsClient implements SmsClient
{
    const ENDPOINT = 'sms.tencentcloudapi.com';
    const ACTION   = 'SendSms';
    const VERSION  = '2021-01-11';

    private $appId;
    private $signName;
    private $region;
    private $secretId;
    private $secKey;

    public function __construct($secretId, $secKey, $appId, $signName, $region = 'ap-nanjing')
    {
        $this->secretId = $secretId;
        $this->secKey   = $secKey;
        $this->appId    = $appId;
        $this->signName = $signName;
        $this->region   = $region;
    }

    public function send($phone, string $templateCode, array $data, $sessionContext = 'test'): array
    {
        SmsLog::info('Send to ' . $phone . ' with templateCode = ' . $templateCode . ', data is: ' . json_encode($data));

        if (substr($phone, 0, 1) != '+') {
            $phone = '+86' . $phone;
        }

        $timestamp = time();
//        $timestamp = 1678706197;

        $payloadObj = [
            "SmsSdkAppId"      => $this->appId,
            "SignName"         => $this->signName,
            "TemplateId"       => $templateCode,
            "TemplateParamSet" => $data,
            "PhoneNumberSet"   => [$phone],
            "SessionContext"   => $sessionContext,
        ];

        $payload = json_encode($payloadObj);

        $hashedRequestPayload = hash("SHA256", $payload);

        $canonicalRequest = "POST\n"
            . "/\n"
            . "\n"
            . "content-type:application/json; charset=utf-8\n" . "host:" . self::ENDPOINT . "\n" . "\n"
            . "content-type;host\n"
            . $hashedRequestPayload;

        // step 2: build string to sign
        $date                   = gmdate("Y-m-d", $timestamp);
        $credentialScope        = $date . "/sms/tc3_request";
        $hashedCanonicalRequest = hash("SHA256", $canonicalRequest);
        $stringToSign           = "TC3-HMAC-SHA256\n"
            . $timestamp . "\n"
            . $credentialScope . "\n"
            . $hashedCanonicalRequest;

        // step 3: sign string
        $secretDate    = hash_hmac("SHA256", $date, "TC3" . $this->secKey, true);
        $secretService = hash_hmac("SHA256", 'sms', $secretDate, true);
        $secretSigning = hash_hmac("SHA256", "tc3_request", $secretService, true);
        $signature     = hash_hmac("SHA256", $stringToSign, $secretSigning);

        $authorization = 'TC3-HMAC-SHA256'
            . " Credential=" . $this->secretId . "/" . $credentialScope
            . ", SignedHeaders=content-type;host, Signature=" . $signature;

        $resp = $this->_request($authorization, $timestamp, $payload);
        return json_decode($resp, true);
    }

    private function _request($authorization, $timestamp, $payload): string
    {
        $url = 'https://' . self::ENDPOINT;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Host: ' . self::ENDPOINT,
            'content-type:application/json; charset=utf-8',
            'Authorization: ' . $authorization,
            'X-TC-Action: ' . self::ACTION,
            'X-TC-Timestamp: ' . $timestamp,
            'X-TC-Version: ' . self::VERSION,
            'X-TC-Region: ' . $this->region,
        ]);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}