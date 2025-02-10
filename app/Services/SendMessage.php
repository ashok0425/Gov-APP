<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendMessage{


function send($text,$phone){
 # Make the call using API.
    $args=http_build_query(array(
        'token' => config('services.sms.token'),
        'from'  => config('services.sms.identity'),
        'to'    => $phone,
        'text'  => "$text"));

        $url = "http://api.sparrowsms.com/v2/sms/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        Log::info($response);
}

}
