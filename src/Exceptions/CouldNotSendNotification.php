<?php

namespace Cazzzt\SmsAero\Exceptions;

class CouldNotSendNotification extends \Exception
{
    /**
     * @return static
     */
    public static function missingFrom()
    {
        return new static('Notification was not sent. Missing `from` number.');
    }

    /**
     * @return static
     */
    public static function missingTo()
    {
        return new static('Notification was not sent. Missing `to` number.');
    }

    /**
     * @return static
     */
    public static function serviceRespondedWithAnError($exception)
    {
        return new static("Service responded with an error '{$exception->getCode()}: {$exception->getMessage()}'");
    }

    /**
     * @param $exception
     * @return static
     */
    public static function couldNotCommunicateWithSmsAero($exception)
    {
        return new static("The communication with smsaero.ru failed. Reason: {$exception->getMessage()}");
    }
}
