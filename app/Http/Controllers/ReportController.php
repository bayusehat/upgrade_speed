<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Report Witel',
            'content' => 'report_witel'
        ];

        return view('layout.index',['data' => $data]);
    }
    public function getReport()
    {
        $response['data'] = [];
        $query = DB::select("
        SELECT X.AREA,
        SUM(CASE WHEN Y.STATUS_OPLANG = 1 THEN 1 ELSE 0 END) SUKSES,
        SUM(CASE WHEN Y.STATUS_OPLANG = 2 THEN 1 ELSE 0 END) ANOMALI,
        SUM(CASE WHEN Y.STATUS_OPLANG = 3 THEN 1 ELSE 0 END) GAGAL,
        SUM(CASE WHEN Y.STATUS_OPLANG IS NULL THEN 1 ELSE 0 END) BELUM_VERIF
        FROM(
            SELECT A.*, B.PENAWARAN, C.SPEED_S UP_SPEED, B.PRICE + A.HARGA_ADDON - A.ABONEMEN HARGA, SUBSTRING(A.PERIODE_TAG,5,6) BULAN_TAGIHAN FROM(
            SELECT A.*,B.*,C.ADDON, CASE WHEN C.PRICE IS NOT NULL THEN C.PRICE ELSE 0 END HARGA_ADDON,D.AREA 
                FROM HP A 
                LEFT JOIN UPSPEED_MASTER B ON A.ND_INTERNET = B.ND_INTERNET
                LEFT JOIN ADDONS C ON B.ADDON_ID = C.ID
                LEFT JOIN AREAS D ON  B.CWITEL = D.CWITEL 
                WHERE B.USER_CALL = 56
        ) A LEFT JOIN OFFERS B ON A.OFFER_ID = B.ID
            LEFT JOIN SPEEDS C ON B.SPEED_ID = C.ID) X
        LEFT JOIN 
        UPSPEED_NEW Y ON X.HP = Y.NOMOR_HP
        GROUP BY X.AREA
        ORDER BY X.AREA
        ");

        foreach ($query as $i => $v) {

            $response['data'][] = [
                ++$i,
                $v->area,
                $v->sukses,
                $v->anomali,
                $v->gagal,
                $v->belum_verif
            ];
        }

        return response($response);
    }
}
