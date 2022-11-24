# 极简短信工具库

适应中国国情的极简短信工具库，无任何第三方依赖包。

### 安装

```shell
composer require lucups/cnsms
```

### 使用

阿里云短信服务:

```php
use Lucups\Cnsms\Sms;

// 配置
Sms::init([
    'channel'         => 'aliyun', 
    'accessKeyId'     => 'xxxxxxxxxxxxxxxxxx',
    'accessKeySecret' => 'xxxxxxxxxxxxxxxxxx',
    'signName'        => '某某科技',
]);

// 单个号码发送
Sms::send('18888888888', 'YOUR_SMS_TPL_ID', ['code' => '123456']);

// 多个号码
Sms::send(['18888888888', '17777777777'], 'YOUR_SMS_TPL_ID', ['code' => '123456']);
```

### 短信渠道支持 Roadmap

- [x] [阿里云短信服务](https://www.aliyun.com/product/sms)
- [ ] [腾讯云短信 SMS](https://cloud.tencent.com/product/sms)
- [ ] [短信宝](https://www.smsbao.com/)
