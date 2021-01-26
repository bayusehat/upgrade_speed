<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Storage;

class ApiController extends Controller
{
    public function getFileUploads()
    {
        $getFiles = [];
        $files = File::files(public_path());

        foreach ($files as $i => $v) {
            $f = pathinfo($v);
            if($f['extension'] == 'wma'){
                $filename = $f['filename'].'.'.$f['extension'];
                $filePath = asset($filename);
                // $fileData = file_get_contents($filePath);
                $fileData = file_get_contents($filePath);
                $getFiles[] = [
                    'filename' => $filename,
                    'filepath' => $filePath,
                    'filedata' => base64_encode($fileData)
                ];
            }
        }
        // $real = '03568834839_prof.wma';
        // $filePath = 'http://ccaretreg5.id/obc_upgradespeed/uploads/recording/'.$real;
        // $tempImage = tempnam(sys_get_temp_dir(), $real);
        // copy($filePath, $tempImage);

        $data = [
            'status' => 200,
            'message' => 'Success',
            'content' => $getFiles           
        ];
        
        return response($data);
        // return response()->download($tempImage,$real);
    }

    public function downloadFiles()
    {
        $data   = $this->getFileUploads();
        $result = json_encode($data);
        $d      = json_decode($result,1);

        foreach ($d['original']['content'] as $q => $v) {
           copy(base64_decode($v['filepath']),public_path('assets/').$v['filename']);
        }
    }
}