<?php

namespace Wshovius\HoviusNetConnect;

use Exception;
use GuzzleHttp\Client;

class HoviusNetConnect
{
    public static function login($token){

        $url = 'https://network.wshovius.nl/api/remotelogin';
        $data = ['client_id' => '1'];

// use key 'http' even if you send the request to https://...
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: ".$token."\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE || !empty(json_decode($result, true)['error']) || empty(json_decode($result, true)['login_reference'])) {
            return redirect()->route('login');
        }

        return json_decode($result, true);


    }

    public static function register($token){
        $url = 'https://network.wshovius.nl/api/newregistration';
            $data = ['client_id' => '1'];

// use key 'http' even if you send the request to https://...
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: ".$token."\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE || !empty(json_decode($result, true)['error']) || empty(json_decode($result, true)['login_reference'])) {
            return redirect()->route('login');
        }

        return json_decode($result, true);
    }

    public static function checkAccount($token){


        $url = 'http://network.wshovius.nl/api/checkAccount';
        $data = ['client_id' => '1'];

// use key 'http' even if you send the request to https://...
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: ".$token."\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        }

        return (bool)json_decode($result, true)['existing_account'];
    }

    public static function drawConnectButton(){
        return view('wshovius::connectbutton');
    }

    public static function getAuthToken($code){
        $http = new Client;

        try{$response = $http->post('https://network.wshovius.nl/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('hoviusnetconnect.client_id'),
                'client_secret' => config('hoviusnetconnect.client_secret'),
                'redirect_uri' => config('hoviusnetconnect.redirect_uri'),
                'code' => $code,
            ]
        ]);
        } catch(Exception $e){
            return redirect()->route('login');
        }

        return 'Bearer ' . json_decode((string) $response->getBody(), true)['access_token'];
    }
}