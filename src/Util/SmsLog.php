<?php

namespace Lucups\Cnsms\Util;

class SmsLog
{
    const LOG_FILE_NAME  = 'cnsms.log';
    const DATETIME_STYLE = 'Y-m-d H:i:s';

    const INFO  = 'INFO';
    const WARN  = 'WARNING';
    const ERROR = 'ERROR';

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
            self::$LOGFILE_PATH = sys_get_temp_dir() . DIRECTORY_SEPARATOR . self::LOG_FILE_NAME;
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

        $prefix = date(self::DATETIME_STYLE) . ' ' . $level . ' ';
        file_put_contents(self::$LOGFILE_PATH, $prefix . $text . "\n", FILE_APPEND);
    }

    public static function info($text)
    {
        self::log(self::INFO, $text);
    }

    public static function warn($text)
    {
        self::log(self::WARN, $text);
    }

    public static function error($text)
    {
        self::log(self::ERROR, $text);
    }
}