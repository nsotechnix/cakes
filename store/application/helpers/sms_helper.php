<?php
function sendsms($message, $mobile_no) {
    $xml_data = '<?xml version="1.0"?>
        <parent>
            <child>
                <user>sgumpl</user>
                <key>4e1d911076XX</key>
                <mobile>+91' . $mobile_no . '</mobile>
                <message>' . $message . '</message>
                <accusage>1</accusage>
                <senderid>SGUMPL</senderid>
            </child>
        </parent>';
    $URL = "http://login.otechnix.in/submitsms.jsp?";
    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
}

function generateCouponCode() {
    $CI = &get_instance();
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $couponCode = substr(str_shuffle($str_result), 0, 12);
    $couponCount = $CI->Crud->ciCount("coupon_of_users", " `coupon_code` = '$couponCode'");
    if ($couponCount > 0) {
        generateCouponCode();
    } else {
        $couponCountCoupon = $CI->Crud->ciCount("coupon_of_users", " `coupon_code` = '$couponCode'");
        if ($couponCountCoupon > 0) {
            generateCouponCode();
        } else {
            return $couponCode;
        }
    }
}

function diffInMonths($date1, $date2) {
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);

    $diff = $date1->diff($date2);

    $difference = (int)($diff->format('%y') * 12) + $diff->format('%m');
    return $difference == 0 ? 1 : $difference;
}