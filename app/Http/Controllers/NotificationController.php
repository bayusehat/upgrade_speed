<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NotificationController extends Controller
{
    public function getNotification()
    {
        $query = DB::select("SELECT * FROM UPSPEED_NEW WHERE FLAG_SEE = 0");
        $jumlah = count($query);

        $data = [
            'notification' => $query,
            'jumlah_notif' => $jumlah
        ];

        return response($data);
    }
}
