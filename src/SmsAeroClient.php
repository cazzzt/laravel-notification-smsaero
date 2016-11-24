<?php

namespace Cazzzt\SmsAero;

use DomainException;
use GuzzleHttp\Client as HttpClient;
use Cazzzt\SmsAero\Exceptions\CouldNotSendNotification;

class SmsAeroClient
{
    /**
     * Sms Aero API Base Url
     */
    const baseURL = 'https://gate.smsaero.ru/send';

    /** @var string */
    protected $user;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $sign;

    /** @var boolean */
    protected $digital;

    /**
     * Http Client
     * @var HttpClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * SmsAero constructor.
     * @param $user
     * @param $secret
     * @param $sign
     * @param $digital
     */
    public function __construct($user, $secret, $sign, $digital)
    {
        //        $this->setHttpClient($client);
        $this->user = $user;
        $this->secret = $secret;
        $this->sign = $sign;
        $this->digital = $digital;
        $this->client = new HttpClient();
    }

    /**
     * @param  array  $params
     * @return array
     * @throws CouldNotSendNotification
     */
    public function send($params)
    {
        $base = [
            'user'   => $this->user,
            'password' => md5($this->secret),
            'date' => false,
            'digital' => $this->digital,
            'type' => 2,
            'answer'  => 'json',
        ];

        if ($params['from'] == '') {
            $params['from'] = $this->sign;
        }

        $params = array_merge($base, $params);

        try {
            $response = $this->client->post(self::baseURL, ['form_params' => $params]);
            $response = json_decode((string) $response->getBody(), true);

            if (isset($response['error'])) {
                throw new DomainException($response['error'], $response['error_code']);
            }

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithSmsAero($exception);
        }
    }
}
