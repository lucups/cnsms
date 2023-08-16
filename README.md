# CNSMS 极简短信工具库

## Slogan

> 我就发个验证码，给我整那么活干啥...

## 介绍

适应中国大陆国情的极简短信工具库，除 `ext-curl`、`ext-json` 等大家都会用到的 PECL 扩展库外无任何第三方依赖包，适用于发送验证码短信、通知短信等场景。

A simple SMS toolkit without any third party dependencies, only for the Chinese Mainland.

- [GitHub](https://github.com/lucups/cnsms)
- [提交BUG](https://github.com/lucups/cnsms/issues/new)

## 安装

```shell
composer require lucups/cnsms
```

## 使用

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

Sms::create($config)->send('1340000000', 'SMS_12345678', ['code' => '666888']);

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
Sms::create($config)->send('1340000000', '178888', ['12345']);
```

## 短信渠道支持 Roadmap

- [x] [阿里云短信服务](https://www.aliyun.com/product/sms)
- [x] [腾讯云短信 SMS](https://cloud.tencent.com/product/sms)
- [ ] [短信宝](https://www.smsbao.com/)

## 注意事项

- 本工具库不校验手机号码合法性，需自行校验；
- 本工具库不处理短信发送失败的情况，需根据 `send` 方法的返回值自行处理；