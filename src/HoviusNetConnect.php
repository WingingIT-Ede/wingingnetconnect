<?php

namespace Wshovius\HoviusNetConnect;

use GuzzleHttp\Client;

class HoviusNetConnect
{
    public static function login($token){
        $http = new Client;

        $response = $http->post('https://network.wshovius.nl/api/remotelogin', [
            'header' => [
                'Accept' => 'application/json',
                'Authorization' => $token,
            ],
            'body' => json_encode([
                'client_id' => config('hoviusnetconnect.client_id')
            ])
        ]);
        if(!empty(json_decode((string) $response->getBody(), true)['error'])) {
            return redirect()->route('login');
        }
        return json_decode((string) $response->getBody(), true)['login_reference'];
    }

    public static function register($token){
        $http = new Client;

        $response = $http->post('https://network.wshovius.nl/api/newregistration', [
            'header' => [
                'Accept' => 'application/json',
                'Authorization' => $token,
            ],
            'body' => json_encode([
                'client_id' => config('hoviusnetconnect.client_id')
            ])
        ]);
        if(!empty(json_decode((string) $response->getBody(), true)['error'])) {
            return redirect()->route('login');
        }

        return json_decode((string) $response->getBody(), true)['login_reference'];
    }

    public static function checkAccount($token){
        $http = new Client;

        $response = $http->post('https://network.wshovius.nl/api/checkAccount', [
            'header' => [
                'Accept' => 'application/json',
                'Authorization' => $token,
            ],
            'body' => json_encode([
                'client_id' => config('hoviusnetconnect.client_id')
            ])
        ]);
        dd($response->getBody());
        return (bool)json_decode((string) $response->getBody(), true)['existing_account'];
    }

    public static function drawConnectButton(){
        return view('wshovius::connectbutton');
    }

    public static function getAuthToken($code){
        $http = new Client;

        $response = $http->post('https://network.wshovius.nl/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('hoviusnetconnect.client_id'),
                'client_secret' => config('hoviusnetconnect.client_secret'),
                'redirect_uri' => config('hoviusnetconnect.redirect_uri'),
                'code' => $code,
            ]
        ]);

        return 'Bearer ' . json_decode((string) $response->getBody(), true)['access_token'];
    }
}