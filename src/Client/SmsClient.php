<?php

namespace Lucups\Cnsms\Client;

interface SmsClient
{
    function send($phone, $templateCode, $data);
}