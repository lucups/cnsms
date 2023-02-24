# CNSMS 极简短信工具库

适应中国国情的极简短信工具库，无任何第三方依赖包。

A simple SMS toolkit without any third party dependencies, only for China.

### 安装

```shell
composer require lucups/cnsms
```

### 使用

阿里云短信服务:

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

### 短信渠道支持 Roadmap

- [x] [阿里云短信服务](https://www.aliyun.com/product/sms)
- [ ] [腾讯云短信 SMS](https://cloud.tencent.com/product/sms)
- [ ] [短信宝](https://www.smsbao.com/)

### 注意事项

- 本工具库不校验手机号码合法性，需自行校验；