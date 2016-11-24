<?php

namespace Cazzzt\SmsAero\Exceptions;

class InvalidConfiguration extends \Exception
{
    /**
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static(
            'In order to send notification via SmsAero you need to add credentials in the `smsaero` key of `config.services`.');
    }
}
