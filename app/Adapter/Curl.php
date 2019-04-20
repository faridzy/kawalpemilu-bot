<?php
/**
 * Created by PhpStorm.
 * User: mfarid
 * Date: 05/04/19
 * Time: 22.54
 */

namespace App\Adapter;


/**
 * Class Curl
 * @package App\Adapter
 */
class Curl
{
    /**
     * @param $signature
     * @return array
     */
    private static function getHeaders($signature,$methodType){

        $headers = array();

        $headers[] = 'Content-Type: application/json';

        return $headers;
    }

    /**
     * @param $url
     * @param $signature
     * @return mixed
     */
    public static function get($url, $signature)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::getHeaders($signature,'get'));
        $result = curl_exec($ch);
        return json_decode($result);
    }

    /**
     * @param $url
     * @param $postData
     * @param $signature
     * @return mixed
     */
    public static function post($url, $postData, $signature)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::getHeaders($signature,'post'));

        $result = curl_exec($ch);
        return json_decode($result);
    }

    /**
     * @param $url
     * @param $postData
     * @param $signature
     * @return mixed
     */
    public static function put($url, $postData, $signature)
    {
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization:'.$signature;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::getHeaders($signature,'put'));

        $result = curl_exec($ch);
        return json_decode($result);
    }

    /**
     * @param $url
     * @param $postData
     * @param $signature
     * @return mixed
     */
    public static function delete($url, $postData, $signature)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::getHeaders($signature,'delete'));

        $result = curl_exec($ch);
        return json_decode($result);
    }



}