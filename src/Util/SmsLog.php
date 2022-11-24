<?php

namespace Lucups\Cnsms\Util;

use Lucups\Cnsms\Exception\SmsException;
use Lucups\Cnsms\Sms;

class SmsLog
{
    /**
     * @var string 日志文件路径
     */
    private static $LOGFILE_PATH = null;

    /**
     * @var bool 是否开启日志，默认开启
     */
    private static $LOG_FLAG = true;

    public static function initLogFilePath($logFilePath = null, $logFlag = true)
    {
        if (empty($logFilePath)) {
            self::$LOGFILE_PATH = sys_get_temp_dir() . '/lucups-sms.log';
        } else {
            self::$LOGFILE_PATH = $logFilePath;
        }
        self::$LOG_FLAG = $logFlag;
    }

    private static function log($level, $text)
    {
        if (!self::$LOG_FLAG) {
            return;
        }
        if (empty(self::$LOGFILE_PATH)) {
            throw new SmsException('Logfile Path  is empty.');
        }

        $prefix = date('Y-m-d H:i:s') . ' ' . $level . ' ';
        file_put_contents($prefix . self::$LOGFILE_PATH, $text . "\n", FILE_APPEND);
    }

    public static function info($text)
    {
        self::log('INFO', $text);
    }

    public static function warn($text)
    {
        self::log('WARNING', $text);
    }

    public static function error($text)
    {
        self::log('ERROR', $text);
    }
}