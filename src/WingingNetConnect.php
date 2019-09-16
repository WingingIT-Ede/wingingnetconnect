<?php

namespace Wshovius\WingingNetConnect;

use Exception;
use GuzzleHttp\Client;

class WingingNetConnect
{
    public static function login($token){

        $url = 'https://connect.wingingit.nl/api/remotelogin';
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
        $url = 'https://connect.wingingit.nl/api/newregistration';
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


        $url = 'http://connect.wingingit.nl/api/checkAccount';
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

        try{$response = $http->post('https://connect.wingingit.nl/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('wingingnetconnect.client_id'),
                'client_secret' => config('wingingnetconnect.client_secret'),
                'redirect_uri' => config('wingingnetconnect.redirect_uri'),
                'code' => $code,
            ]
        ]);
        } catch(Exception $e){
            return redirect()->route('login');
        }

        return 'Bearer ' . json_decode((string) $response->getBody(), true)['access_token'];
    }
}