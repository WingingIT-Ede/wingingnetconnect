<?php

namespace Wshovius\HoviusNetConnect;

use GuzzleHttp\Client;

class HoviusNetConnect
{
    public static function login(){

    }

    public static function register(){

    }

    public static function checkAccount($code = null){

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

        dd($response);
        return $response;
    }
}