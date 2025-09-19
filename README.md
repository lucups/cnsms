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

$result = Sms::create($config)->send('1340000000', '【测试账号】您的短信验证码是{code} ，在10分钟内有效。', ['code'=> '123456']);
print_r($result);
```

自 v0.6.0 开始，短信宝支持查询余额/短信余量:

```php
$result = Sms::create($config)->balance();
print_r($result);
```

调用得到PHP数组，字段含义如下：

```
Array
(
    [code] => 0
    [msg] => success // 调用失败则是 fail
    [leftNum] => 48 // 短信剩余条数
    [balance] => 0 // 账户余额
)
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
- 鉴于国内日益严格的审查政策，建议使用服务相对比较人性化、审核速度相对较快的短信宝服务。