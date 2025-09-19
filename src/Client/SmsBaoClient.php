<?php

namespace Lucups\Cnsms\Client;

/**
 * 短信宝
 * @see https://www.smsbao.com/openapi/213.html
 */
class SmsBaoClient implements SmsClient
{
    const BASE_API_URL = 'https://api.smsbao.com/';
    const BASE_WWW_URL = 'https://www.smsbao.com/';

    private $username;
    private $password;
    private $apiKey;

    const STATUS_MAP = [
        "0"  => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词",
    ];

    public function __construct($username, $password, $apiKey = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->apiKey   = $apiKey;
    }

    /**
     * @param $phone
     * @param string $templateCode
     * @param array $data
     * @return array
     */
    public function send($phone, string $templateCode, array $data = []): array
    {
        $user = $this->username;                                                   //短信平台帐号
        $pass = empty($this->password) ? $this->apiKey : md5($this->password);     //短信平台密码

        $content = $templateCode; //要发送的短信内容
        foreach ($data as $key => $val) {
            $content = str_replace('{' . $key . '}', $val, $content);
        }

        $sendUrl = self::BASE_API_URL . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result  = file_get_contents($sendUrl);

        $resultParts = explode("\n", $result);
        $resultCode  = $resultParts[0];

        return ['code' => $resultCode, 'msg' => self::STATUS_MAP[$resultCode]];
    }

    public function balance(): array
    {
        $user    = $this->username;                                                   //短信平台帐号
        $pass    = empty($this->password) ? $this->apiKey : md5($this->password);     //短信平台密码
        $sendUrl = self::BASE_WWW_URL . "query?u=" . $user . "&p=" . $pass;
        $result  = file_get_contents($sendUrl);

        $resultParts = explode("\n", $result);
        $resultCode  = $resultParts[0];

        $dataParts = explode(',', $resultParts[1]);
        $balance   = $dataParts[0];
        $leftNum   = $dataParts[1];

        return [
            'code'    => $resultCode,
            'msg'     => $resultCode == 0 ? 'success' : 'fail',
            'leftNum' => $leftNum,
            'balance' => $balance,
        ];
    }
}