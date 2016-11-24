<?php

namespace Cazzzt\SmsAero;

use DomainException;
use \Illuminate\Notifications\Notification;
use Cazzzt\SmsAero\Exceptions\CouldNotSendNotification;

class SmsAeroChannel
{
    /**
     * The Sms Aero client instance.
     *
     * @var \Cazzzt\SmsAero\Client
     */
    protected $smsaero;

    /**
     * Create a new Sms Aero channel instance
     * @param \Cazzzt\SmsAero\SmsAeroClient $smsaero
     * @param $from
     */
    public function __construct(SmsAeroClient $smsaero)
    {
        $this->smsaero = $smsaero;
    }

    /**
     * @param $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('smsaero')) {
            throw CouldNotSendNotification::missingTo();
        }

        $message = $notification->toSmsAero($notifiable);

        if (is_string($message)) {
            $message = new SmsAeroMessage($message);
        }

        try {
            $response = $this->smsaero->send([
                'from' => $message->from,
                'to' => $to,
                'text' => trim($message->content),
            ]);

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
