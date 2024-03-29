<?php

namespace Lucups\Cnsms\Client;

/**
 * 短信宝
 * @see https://www.smsbao.com/openapi/213.html
 */
class SmsBaoClient implements SmsClient
{
    private $username;
    private $password;
    private $apiKey;

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
        $statusMap = [
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

        $smsapi     = "https://api.smsbao.com/";
        $user       = $this->username;                                                   //短信平台帐号
        $pass       = empty($this->password) ? $this->apiKey : md5($this->password);     //短信平台密码
        $content    = $templateCode;                                                     //要发送的短信内容
        $sendurl    = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $resultCode = file_get_contents($sendurl);
        return ['code' => $resultCode, 'msg' => $statusMap[$resultCode]];
    }
}