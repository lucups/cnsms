<?php

namespace Lucups\Cnsms\Base;

/**
 * 短信统一错误码
 */
class SmsErrCode
{
    const SUCCESS = 0;

    const ERR_DEFAULT = 1; // 默认错误码，详细错误信息在信息字段中呈现
    const ERR_UNKNOWN = 2; // 未知错误
}