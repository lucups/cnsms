<?php

namespace Lucups\Sms;

use Lucups\Sms\Base\AbstractSmsClient;
use Lucups\Sms\Channel\SmsChannel;
use Lucups\Sms\Exception\SmsException;
use Lucups\Sms\Util\SmsLog;
use Lucups\Sms\Util\Utils;

/**
 * SMS
 */
class Sms
{
    /**
     * @var AbstractSmsClient 短信客户端
     */
    private static $SMS_CLIENT = null;

    /**
     * @param array|null $config
     * @return void
     */
    public static function init($config = null)
    {
        if (empty(self::$SMS_CLIENT)) {
            $useEnv = false;
            if (empty($config)) {
                $channel     = Utils::safeGet($_ENV, 'SMS_CHANNEL');
                $logfilePath = Utils::safeGet($_ENV, 'SMS_LOGFILE_PATH');
                $logFlag     = (bool)Utils::safeGet($_ENV, 'SMS_LOG_FLAG');
                $useEnv      = true;
            } else {
                $channel     = Utils::safeGet($config, 'channel');
                $logfilePath = Utils::safeGet($config, 'logfilePath');
                $logFlag     = (bool)Utils::safeGet($config, 'logFlag');
            }
            if (empty($channel)) {
                throw new SmsException('Invalid init data.');
            }
            SmsLog::initLogFilePath($logfilePath, $logFlag);
            self::$SMS_CLIENT = SmsChannel::initClient($channel, $useEnv, $config);
        }
    }

    /**
     * @param array|string $phone 如果是多个手机号码，需要使用数组传入
     * @param string $tplId 短信模板ID
     * @param array $data 模块数据
     * @return void
     */
    public static function send($phone, $tplId, $data = [])
    {
        if (empty(self::$SMS_CLIENT)) {
            self::init(); // try to init
        }
        if (self::$SMS_CLIENT instanceof AbstractSmsClient) {
            self::$SMS_CLIENT->send($phone, $tplId, $data);
        } else {
            throw new SmsException('Sms Client is not a instance of AbstractSmsClient.');
        }
    }
}