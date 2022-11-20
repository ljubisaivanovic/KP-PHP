<?php

namespace App\Core\Libraries;

class MaxMind
{
    private static $accountId = 'test';
    private static $key = 'test';
    private static $headers;
    private static $url = 'https://minfraud.maxmind.com/minfraud/v2.0/score';

    /** Client
     * @param array $params
     * @return mixed
     */
    public static function getScore(array $params)
    {
        $dataJson = json_encode($params);

        self::$headers[] = 'Authorization: Basic ' . base64_encode(self::$accountId . ':' . self::$key);
        self::$headers[] = 'Content-Type: application/json';
        self::$headers[] = 'Content-Length: ' . strlen($dataJson);

        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, self::$url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_ENCODING, '');
        curl_setopt($handle, CURLOPT_MAXREDIRS, 10);
        curl_setopt($handle, CURLOPT_TIMEOUT, 0);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($handle, CURLOPT_HTTPHEADER, self::$headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($handle);

        //using fake data for test
        $fakeResult = json_decode('{
            "ip_address": {
                "risk": 2
            },
            "email": {
                "domain": {
                    "first_seen": "2015-01-20"
                },
                "first_seen": "2016-02-03",
                "is_disposable": false,
                "is_free": false,
                "is_high_risk": false
            }
        }');

        return $fakeResult;
    }
}