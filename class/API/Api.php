<?php

namespace API;

class Api {
    public static $method;
    private $response;
    private $error;
    private $data;
    private $defaultOptions;
    private $methodOptions;
    private $baseURL = 'http://localhost:3333';

    public function getResponse() {
        return json_decode($this->response);
    }

    public function getError() {
        return $this->error;
    }

    public function request($endpoint, $data = null){
        $url = $this->baseURL . "/$endpoint";
        $this->data = $data;

        $this->execCurl($url);
    }

    private function execCurl($url) {
        $curl = curl_init();

        $this->defaultOptions = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => self::$method,
        ];
        $this->setOptions();
        $options = $this->defaultOptions + $this->methodOptions;

        curl_setopt_array($curl, $options);

        $this->response = curl_exec($curl);
        $this->error = curl_error($curl);
        $curl = curl_close($curl);
    }

    private function setOptions() {
        if ( self::$method == 'GET' ) {
            $this->methodOptions = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HEADER => false,
            ];
        } else if ( self::$method == 'PUT' ) {
            $data = '{ "status": "' . $this->data['status'] . '", "title": "' . $this->data['title'] . '" }';
            $this->methodOptions = [
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => $data
            ];
        } else if ( self::$method == 'POST' ) {
            $data = '{ "status": "' . $this->data['status'] . '", "title": "' . $this->data['title'] . '" }';
            $this->methodOptions = [
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $data
            ];
        }
    }
}