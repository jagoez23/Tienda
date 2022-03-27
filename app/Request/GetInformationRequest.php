<?php

namespace App\Request;

use App\Contracts\WebcheckoutRequestContract;
use Illuminate\Support\Str;

class GetInformationRequest implements WebcheckoutRequestContract
{
    public function aut()
    {
        $seed = date(format:'c');
        $nonce = Str::random(8);
        $tranKey = base64_encode(hash(algo: 'sha1', data: $nonce.$seed.config(key:'webcheckout.tranKey'),binary:true));

        return [
            'auth' => [
                'login' => config(key: 'webcheckout.login'),
                'tranKey' => $tranKey,
                'nonce' => base64_encode($nonce),
                'seed' => $seed, 
            ]
        ];
    }

    public static function url(?int $session_id): string
    {
        return config(key: 'webcheckout.url').'/api/session/'.$session_id;
    }
}