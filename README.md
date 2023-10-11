# CNSMS 极简短信工具库

## Slogan

> 我就发个验证码，给我整那么活干啥...

## 介绍

适应中国大陆国情的极简短信工具库，除 `ext-curl`、`ext-json` 等大家都会用到的 PECL 扩展库外无任何第三方依赖包，适用于发送验证码短信、通知短信等场景。

A simple SMS toolkit without any third party dependencies, only for the Chinese Mainland.

- [GitHub](https://github.com/lucups/cnsms)
- [提交BUG](https://github.com/lucups/cnsms/issues/new)

## 支持的短信渠道

- [x] [短信宝](https://www.smsbao.com/)
- [x] [阿里云短信服务](https://www.aliyun.com/product/sms)
- [x] [腾讯云短信 SMS](https://cloud.tencent.com/product/sms)

## 安装

```shell
composer require lucups/cnsms
```

## 使用

### 短信宝

```php
$config = [
    'channel'     => Sms::CHANNEL_SMSBAO,
    'logFlag'     => true,
    'logfilePath' => '/tmp/cnsms.log',
    'username'    => 'xxxxx', // 登录账号
    'password'    => 'xxxxx', // 登录密码
    'apiKey'      => 'xxxxx', // 接口密钥（密码密钥二选一，请求的时候密码会被md5处理，apiKey 不会）
];
$result = Sms::create($config)->send('1340000000', '【测试账号】您的短信验证码是123456 ，在10分钟内有效。');

print_r($result);
```

### 阿里云短信服务

```php
use Lucups\Cnsms\Sms;

require_once __DIR__ . '/vendor/autoload.php';

$config = [
    'channel'         => Sms::CHANNEL_ALIYUN,
    'accessKeyId'     => 'xxxxxxx',
    'accessKeySecret' => 'xxxxxxx',
    'signName'        => 'xxx',
];

$result = Sms::create($config)->send('1340000000', 'SMS_12345678', ['code' => '666888']);
print_r($result);

// 完整配置
$config = [
    'channel'         => Sms::CHANNEL_ALIYUN,
    'logFlag'         => true,
    'logfilePath'     => '/tmp/cnsms.log',
    'accessKeyId'     => 'xxxxxxx',
    'accessKeySecret' => 'xxxxxxx',
    'signName'        => 'xxx',
    'regionId'        => 'cn-shanghai'
];
```

### 腾讯云短信服务

```php
$config = [
    'channel'     => Sms::CHANNEL_TENCENT,
    'logFlag'     => true,
    'logfilePath' => '/tmp/cnsms.log',
    'secretId'    => 'xxxxxxx',
    'secKey'      => 'xxxxxxx',
    'appId'       => 'xxx',
    'signName'    => 'xxx',
];
$result = Sms::create($config)->send('1340000000', '178888', ['12345']);
print_r($result);
```

## 注意事项

- 本工具库不校验手机号码合法性，需自行校验；
- 本工具库不处理短信发送失败的情况，需根据 `send` 方法的返回值自行处理；

---

## 题外话: 阿里云短信服务劝退宣言

鉴于本人在使用过程的实际体验，不建议使用阿里云短信服务，原因无他，在阿里云申请个短信签名难于登天。

在阿里云申请短信签名，各种材料全部提交了，各种证件、公司盖章、人脸识别、录视频，最后非要我开个测试账号给它进去看看。

![阿里云短信签名审核结果](images/aliyun-sms-sign-apply-result.jpg)

我真是服了，我用阿里云那么多服务，就没遇到这么折腾人的。

我就发个验证码，材料提交了一大推，都是实名的，能有啥问题？非要我脱光了给它看？

咱小公司一年也就几千块的短信费，人家也看不上，我没那个精力折腾。 所以放弃了，改用短信宝了。