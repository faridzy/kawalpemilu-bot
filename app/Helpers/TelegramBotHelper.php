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
        $notifMessage = "*[KawalPemiluBot2019 Made by MitraAnakNegeri]*\n";
        $notifMessage .= "Hasil : \n\n";
        $notifMessage .= "--------------------------------------------------\n";
        $notifMessage .= "*Paslon 1 - Ir.Joko Widodo dan KH.Maruf Amin* \n";
        $notifMessage .= "--------------------------------------------------\n";
        $notifMessage .= "Total Suara\t: " .number_format($total['total_pas1'],0)."\n";
        $notifMessage .= "Prosentase\t: ".number_format(($total['total_pas1']/($total['total_sah']+$total['total_tSah']))*100,2)."%\n\n";
        $notifMessage .= "--------------------------------------------------\n\n";
        $notifMessage .= "--------------------------------------------------\n";
        $notifMessage .= "*Paslon 2 - H.Prabowo Subianto dan Sandiaga Uno* \n";
        $notifMessage .= "--------------------------------------------------\n";
        $notifMessage .= "Total Suara\t: ".number_format($total['total_pas2'],0)."\n";
        $notifMessage .= "Prosentase\t: ".number_format(($total['total_pas2']/($total['total_sah']+$total['total_tSah']))*100,2)."%\n";
        $notifMessage .= "--------------------------------------------------\n\n";
        $notifMessage .= "--------------------------------------------------\n";
        $notifMessage .= "Total Suara Sah\t: ".number_format($total['total_sah'],0)."\n";
        $notifMessage .= "Total Suara Tidak Sah\t: ".number_format($total['total_tSah'],0)."\n";
        $notifMessage .= "TPS di Proses\t: ".$total['tps_proses']."\n";
        $notifMessage .= "Total TPS\t: ".$total['total_tps']."\n";
        $notifMessage .= "--------------------------------------------------\n";
        $notifMessage .= "Note\t: Prosentase lebih dari 100% karena ada data jumlah suara sah dari kedua paslon di beberapa daerah tidak sama dengan total suara sah didaerah tersebut"."\n";
        $notifMessage .= "Sumber data\t: http://kawalpemilu.org";
        //dd($notifMessage);
        try{
            return self::sendMessage($notifMessage);
        }catch (\Exception $e){
            die("Gagal mengirim ke telegram");
        }
    }
}