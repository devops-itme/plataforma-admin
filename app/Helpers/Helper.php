<?php
if (!function_exists('format_date')) {
    function format_date($date)
    {
        $data = explode(" ", $date)[0];
        $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $day = explode("-", $data)[2];
        $month = explode("-", $data)[1];
        $year = explode("-", $data)[0];

        return $day."-".$months[$month - 1]."-".$year;

    }
}
