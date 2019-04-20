<?php
/**
 * Created by PhpStorm.
 * User: mfarid
 * Date: 31/07/18
 * Time: 12.32
 */

namespace App\Helpers;


use App\Adapter\Curl;

class TelegramBotHelper
{

    public static function sendMessage($message)
    {
        $authorizationToken = "721772446:AAGm3bJ-IEYUrv0099aXoOfCGGcpmFtt2ME";
        $telegramApiUrl="https://api.telegram.org/bot".$authorizationToken."/";
        $chatId='-1001366647305';
        $message = str_replace("_", " ", $message);
        $dataGrupDev = [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_to_message_id' => null,
            'parse_mode' => 'Markdown'
        ];

        try{
            return Curl::post($telegramApiUrl."sendMessage", $dataGrupDev,'');
        }catch(\Exception $e){
            return null;
        }

    }

    public static function detailMessage($message,$total){
        $notifMessage = "*[KawalPemiluBot2019 Made in MitraAnakNegeri]*"."\n";
        $notifMessage .= "Hasil: "."\n";
//        foreach ($message as $item){
//            $notifMessage .="Nama Provinsi : ".$item['nama_provinsi']."\n";
//            $notifMessage .="Suara Pasangan 01 : Ir. Joko Widodo dan KH. Ma`ruf Amin : ".$item['pas1']."\n";
//            $notifMessage .="Suara Pasangan 02 : H. Prabowo Subianto dan Sandiaga Uno: ".$item['pas2']."\n";
//            $notifMessage .="Suara Sah : ".$item['sah']."\n";
//            $notifMessage .="Suara Tidak Sah : ".$item['tSah']."\n";
//            $notifMessage .="TPS di Proses : ".$item['tpsmasuk']."\n";
//            $notifMessage .="Total TPS : ".$item['total_tps']."\n";
//        }
//
        $notifMessage .="Total Suara Paslon 01: Ir.Joko Widodo dan KH.Maruf Amin :".number_format($total['total_pas1'],0)."\n";
        $notifMessage .="Prosentase : ".number_format(($total['total_pas1']/($total['total_sah']+$total['total_tSah']))*100,2)."%"."\n";
        $notifMessage .="Total Suara Paslon 02: H.Prabowo Subianto dan Sandiaga Uno :".number_format($total['total_pas2'],0)."\n";
        $notifMessage .="Prosentase : ".number_format(($total['total_pas2']/($total['total_sah']+$total['total_tSah']))*100,2)."%"."\n";
        $notifMessage .="Total Suara Sah : ".number_format($total['total_sah'],0)."\n";
        $notifMessage .="Total Suara Tidak Sah :".number_format($total['total_tSah'],0)."\n";
        $notifMessage .="TPS di Proses : ".$total['tps_proses']."\n";
        $notifMessage .="Total TPS : ".$total['total_tps']."\n";
        $notifMessage .="Data dari kawalpemilu.org";
        //dd($notifMessage);
        try{
            return self::sendMessage($notifMessage);
        }catch (\Exception $e){
            die("Gagal mengirim ke telegram");
        }
    }




}