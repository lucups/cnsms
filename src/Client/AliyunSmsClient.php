<?php

namespace Lucups\Cnsms\Client;

use Lucups\Cnsms\Util\SmsLog;

/**
 * 阿里云短信
 * @see https://help.aliyun.com/document_detail/71160.html
 * @see https://help.aliyun.com/document_detail/419273.htm
 *
 * 阿里云短信错误码处理
 * @see https://help.aliyun.com/document_detail/101346.html
 * @see https://help.aliyun.com/document_detail/101347.html
 */
class AliyunSmsClient implements SmsClient
{
    const URL = 'https://dysmsapi.aliyuncs.com/';

    private $accessKeyId;
    private $accessKeySecret;
    private $signName;
    private $regionId;

    public function __construct($accessKeyId, $accessKeySecret, $signName, $regionId)
    {
        $this->accessKeyId     = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->signName        = $signName;
        $this->regionId        = $regionId;
    }

    public function send($phone, $templateCode, $data)
    {
        SmsLog::info('Send to ' . $phone . ' with templateCode = ' . $templateCode . ', data is: ' . json_encode($data));

        $params = [
            'RegionId'         => $this->regionId,
            'Format'           => 'JSON',
            'Version'          => '2017-05-25',
            'AccessKeyId'      => $this->accessKeyId,
            'SignatureMethod'  => 'HMAC-SHA1',
            'Timestamp'        => gmdate('Y-m-d\TH:i:s\Z'),
            'SignatureVersion' => '1.0',
            'SignatureNonce'   => uniqid(),
            'Action'           => 'SendSms',
            'SignName'         => $this->signName,
            'TemplateParam'    => $this->getTempDataString($data),
            'PhoneNumbers'     => $phone,
            'TemplateCode'     => $templateCode,
        ];

        $params['Signature'] = $this->computeSignature($params);

        $result = $this->_request($params);
        print_r($result);
        print_r('Send ok');
    }

    private function computeSignature($parameters)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }
        $stringToSign = 'POST&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));

        return base64_encode(hash_hmac('sha1', $stringToSign, $this->accessKeySecret . '&', true));
    }

    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);

        return $res;
    }

    protected function getTempDataString(array $data)
    {
        $data = array_map(function ($value) {
            return (string)$value;
        }, $data);

        return json_encode($data);
    }

    private function _request($params): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        $response = curl_exec($ch);
        $request  = $response !== false;
        if (!$request) {
            $response = curl_getinfo($ch);
        }
        curl_close($ch);

        return compact('request', 'response');
    }
}