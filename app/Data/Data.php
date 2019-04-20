<?php
/**
 * Created by PhpStorm.
 * User: mfarid
 * Date: 20/04/19
 * Time: 15.55
 */

namespace App\Data;


use App\Helpers\TelegramBotHelper;
use App\Adapter\Curl;

class Data
{


    public  static function getData()
    {
        $data=Curl::get('https://kawal-c1.appspot.com/api/c/0','');

        $dataChild=$data->children;
        $currentChild=[];
        for($i=0;$i<count($dataChild);$i++){
            $currentChild[]=[
                'id'=>$dataChild[$i][0],
                'nama_provinsi'=>$dataChild[$i][1],
                'jumlah_tps'=>$dataChild[$i][2]
            ];

        }
        $totalSuaraPaslon1=0;
        $totalSuaraPaslon2=0;
        $totalSah=0;
        $totalTidakSah=0;
        $dataPerolehan=$data->data;
        $totalTps=0;
        $tpsProses=0;
        $currentDataPerolehan=[];
        foreach ($dataPerolehan as $key =>$item){
            foreach ($currentChild as $value){
                if($key==$value['id']){
                    $currentDataPerolehan[]=[
                        'nama_provinsi'=>$value['nama_provinsi'],
                        'pas1'=>$item->sum->pas1,
                        'pas2'=>$item->sum->pas2,
                        'sah'=>$item->sum->sah,
                        'tSah'=>$item->sum->tSah,
                        'tpsmasuk' =>$item->sum->cakupan,
                        'total_tps' =>$value['jumlah_tps']

                    ];
                    $totalSuaraPaslon1+=$item->sum->pas1;
                    $totalSuaraPaslon2+=$item->sum->pas2;
                    $totalSah+=$item->sum->sah;
                    $totalTidakSah+=$item->sum->tSah;
                    $totalTps+=$value['jumlah_tps'];
                    $tpsProses+=$item->sum->cakupan;

                }
            }
        }

        $totalData=[
            'total_pas1'=>$totalSuaraPaslon1,
            'total_pas2'=>$totalSuaraPaslon2,
            'total_tSah'=>$totalTidakSah,
            'total_sah' =>$totalSah,
            'total_tps' =>$totalTps,
            'tps_proses'=>$tpsProses
        ];

        return TelegramBotHelper::detailMessage($currentDataPerolehan,$totalData);
    }

}