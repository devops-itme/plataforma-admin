<?php
if (!function_exists('format_date')) {
    function format_date($date)
    {
        if ($date != '1970-1-01') {
            $data = explode(" ", $date)[0];
            $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

            $day = explode("-", $data)[2];
            $month = explode("-", $data)[1];
            $year = explode("-", $data)[0];

            return $day . "-" . $months[$month - 1] . "-" . $year;
        }
    }
}

if (!function_exists('send_sms')) {
    function send_sms($phone, $body, $fecha = '')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://' . env('SMS_BASE_URL') . '/sms/2/text/advanced',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"messages":[{"destinations":[{"to":"' . $phone . '"}],"from":"Multientrega","text":"' . $body . '"}]}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: App '. env('SMS_API_KEY'),
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}

if (!function_exists('format_hour')) {
    function format_hour($date)
    {
        return \Carbon\Carbon::parse($date)->format('g:i A');
    }
}

if (!function_exists('sendCustomNotifications')) {
    function sendCustomNotifications($title = 'Notificación', $message = 'Nueva notificación', $data = [], $userToken)
    {
        try {
            $data = [
                "to" => $userToken,
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "data" => $data
            ];

            $dataString = json_encode($data, JSON_FORCE_OBJECT);

            $headers = [
                'Authorization: key=' . env('FCM_KEY'),
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            return $response;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
