<?php

namespace Lucups\Cnsms;

use Lucups\Cnsms\Base\AbstractSmsClient;
use Lucups\Cnsms\Util\ClientUtils;
use Lucups\Cnsms\Util\SmsException;
use Lucups\Cnsms\Util\SmsLog;
use Lucups\Cnsms\Util\Utils;

/**
 * SMS
 */
class Sms
{
    /**
     * @var AbstractSmsClient 短信客户端
     */
    private static $SMS_CLIENT = null;


    public static function create($config = null)
    {
        if (empty(self::$SMS_CLIENT)) {
            $channel     = strtolower(Utils::safeGet($config, 'channel'));
            $logfilePath = Utils::safeGet($config, 'logfilePath');
            $logFlag     = (bool)Utils::safeGet($config, 'logFlag', false);

            if (empty($channel)) {
                throw new SmsException('Invalid init data.');
            }
            SmsLog::initLogFilePath($logfilePath, $logFlag);
            self::$SMS_CLIENT = ClientUtils::createClient($channel, $config);
        }
        return self::$SMS_CLIENT;
    }

}