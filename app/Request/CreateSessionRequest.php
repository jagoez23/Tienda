<?php

namespace App\Request;


use App\Contracts\WebcheckoutRequestContract;

class CreateSessionRequest extends GetInformationRequest implements WebcheckoutRequestContract
{
    public array $payment;
    public string $expiration;
    public string $returnUrl;

    public function __construct(array $data)
    {
        $this->payment = $data['payment'];
        $this->expiration = $data['expiration'];
        $this->returnUrl = $data['returnUrl'];
    }

    public static function url(?int $session_id): string
    {
        return config('webcheckout.url').'/api/session';
    }

    public function toArray()
    {
        return array_merge(parent::auth(),[
            'locale' => 'es_CO',
            'payment' => $this->payment,
            'expiration' => $this->expiration,
            'returnUrl' => $this->returnUrl,
            'ipAddress' => app(abstract:Request::class)->getClientIp(),
            'userAgent' => substr(app(abstract:Request::class)->header('User-Agent'),0,255)

        ]);
    }
    
}