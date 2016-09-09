<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;

class NotificationController extends Controller
{
    public function getIndex()
    {
        //$ids = User::where('gcm_id','<>','')->lists('gcm_id')->all();
        //print_r($ids);
        return view('admin.notification.view');
    }

    // send notification to user's
    public function postNotification(Request $request)
    {

        $sendTo = $request->input('sendTo');
        if ($sendTo == '4') {
            $ids = User::where('gcm_id','<>','')->lists('gcm_id')->all();
        } elseif ($sendTo == '1') {
            $ids = User::where('gcm_id','<>','')->where('status', '1')->lists('gcm_id')->all();
        } elseif ($sendTo == '0') {
            $ids = User::where('gcm_id','<>','')->where('status', '0')->lists('gcm_id')->all();
        } elseif ($sendTo == '2') {
            $ids = User::where('gcm_id','<>','')->where('status', '2')->lists('gcm_id')->all();
        } else {
            $ids = User::where('gcm_id','<>','')->lists('gcm_id')->all();
        }

        $apiKey = "AIzaSyDbNqntBTSqBJF-TFnVOHUueEiiTUzCO1Q";
        //$ids = User::where('gcm_id','<>','')->lists('gcm_id')->all();
        $registrationIDs = $ids;
        $message = $request->input('message');
        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $fields = array(
                'registration_ids'  => $registrationIDs,
                'data'              => array("message"=>$message),
                );
        $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
                );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($fields) );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        $result = curl_exec($ch);
        if(curl_errno($ch)){ echo 'Curl error: ' . curl_error($ch); }
        curl_close($ch);
        //return response()->json($result);

        return redirect()->back()->with('msg', 'Message has been successfully push to all users');
    }
}
