<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class NotificationUccul extends Controller
{
    // push notifications
    public function push(Request $request)
    {
        $apiKey = "AIzaSyDbNqntBTSqBJF-TFnVOHUueEiiTUzCO1Q";
        $registrationIDs = array("cZAe1oePDGA:APA91bE5ggQQvnq6Aprvz2hIXKaStv7rCme4Um0fX-hfO5tUnDEHFDTVk1XzfJYZcl7IxtCpRlik-W9pe6rz2R4NYqENdKLTbiIteljmorwVWNuKZpGJ_9dCKOoiy3I1uHhCHUwtFgY3");
        $subject = 'Kolos Team';
        $message = 'Hello world!';
        //$message = array("subject"=>$subject, "message"=>$message);
        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $fields = array(
                'registration_ids'  => $registrationIDs,
                'data'              => array("message"=>$message),
                );
        $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
                );

        //return response()->json($fields);

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($fields) );
        curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        $result = curl_exec($ch);
        if(curl_errno($ch)){ echo 'Curl error: ' . curl_error($ch); }
        curl_close($ch);
        return response()->json($result);
    }

//    public function notification()
//    {
//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//        error_reporting(E_ALL);
//        $gcm_reg_id = 'd4HrPZB3idk:APA91bFa-f2QQr_uDuMHJkAek6msfmyl50yBn9FG7-TGUksxLwZa9JpOljRbBU4k-3kTCGWsuVx1U6EVTyMptAV3pVkwVSGihtKiD7YV0G6KOl-_72_dy2S7Ixxz84Msb-7IYvadUZl5';
//        $subject = 'Kolos Team';
//        $message = 'Hello world!';
//
//        $registration_ids = array($gcm_reg_id);
//        $message = array("subject"=>$subject, "message"=>$message);
//
//        $result = $this->push($registration_ids, $message);
//        //return response()->json($result);
//    }
}
