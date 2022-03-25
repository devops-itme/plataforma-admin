<?php
if (!function_exists('format_date')) {
    function format_date($date)
    {
        if($date != '1970-1-01'){
            $data = explode(" ", $date)[0];
            $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

            $day = explode("-", $data)[2];
            $month = explode("-", $data)[1];
            $year = explode("-", $data)[0];

            return $day."-".$months[$month - 1]."-".$year;
        }
    }
}

if (!function_exists('send_sms')) {
    function send_sms($phone, $body, $fecha = '')
    {
        $ch=curl_init();

        $url = env('SMS_URL');

        $data = array(
            'account' => env('SMS_ACCOUNT'),
            'apiKey' => env('SMS_APIKEY'),
            'token' => env('SMS_TOKEN'),
            'toNumber' => $phone,
            'sms' => $body,
            'sendDate' => $fecha,
            'isPriority' => 1,
        );

        curl_setopt ($ch,CURLOPT_URL,$url) ;
        curl_setopt ($ch,CURLOPT_POST,1);
        curl_setopt ($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt ($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt ($ch,CURLOPT_TIMEOUT, 20);
        $response= curl_exec($ch);
        curl_close($ch);
        $response= json_decode($response ,true) ;

        return $response;
    }
}
