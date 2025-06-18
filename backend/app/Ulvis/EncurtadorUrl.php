<?php

namespace App\Ulvis;

class EncurtadorUrl {

    /**
     * Função responsável de encurtar uma url longa
     * @param string $url
     * @return string
     */
    public static function encurtar($url)
    {
        // Array contendo a url para enviar na requisição.
        $params = [
            'url' => $url
        ];

        $response = self::enviar($params);

        return $response['data']['url'];
    }

    /**
     * Função responsável de enviar para o endpoint da Api do Ulvis a requisição contendo a url longa.
     * @param array $params
     * @return array
     */
    private static function enviar($params = [])
    {
        $endpoint = 'https://ulvis.net/API/write/get?' . http_build_query($params);

        // Inicia o CURL
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        // Executa o curl
        $response = curl_exec($curl);

        // Fecha o curl
        curl_close($curl);

        return strlen($response) ? json_decode($response, true) : [];
    }

}