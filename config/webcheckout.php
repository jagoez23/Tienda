<?php

return [
    'login' => env(key:'WEBCHECKOUT_LOGIN', default:null),
    'trankey' => env(key:'WEBCHECKOUT_TRANKEY', default:null),
    'url' => env(key:'WEBCHECKOUT_URL', default:null)
];