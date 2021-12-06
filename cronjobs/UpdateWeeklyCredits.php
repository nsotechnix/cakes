<?php

/**
 * UpdateWeeklyCredits.php
 * insert weekly income to weekly_credits table for all epins
 */

ini_set('display_errors', 1);
ini_set('max_execution_time', -1);

include('classes/Crud.php');

$crud = new Crud();

date_default_timezone_set('Asia/Kolkata');
define('DEFAULT_WEEK_START_NAME', 'Monday');
define('DEFAULT_WEEK_END_NAME', 'Sunday');
define('DEFAULT_WEEK_START', 1);
define('DEFAULT_WEEK_END', 7);


$today = date('Y-m-d');
$isFirstWeek = (date('W') % 4 == 0) ? true : false;

if (date('N') == DEFAULT_WEEK_START) {
    ${'next' . DEFAULT_WEEK_START_NAME} = date('Y-m-d', strtotime('next ' . DEFAULT_WEEK_END_NAME));
    $beginingDate = $today;
} else {
    if (date('N') == DEFAULT_WEEK_END) {
        ${'next' . DEFAULT_WEEK_START_NAME} = $today;
    } else {
        ${'next' . DEFAULT_WEEK_START_NAME} = date('Y-m-d', strtotime('next ' . DEFAULT_WEEK_END_NAME));
    }
    $beginingDate = date('Y-m-d', strtotime('last ' . DEFAULT_WEEK_START_NAME));
}
$endDate = ${'next' . DEFAULT_WEEK_START_NAME};

foreach ($crud->Read('users', " `is_active` = '1'") as $key) {
    $thisEpin = $key['epin'];
    $walletSum = $crud->GetSum('transaction_history', 'credit', " `epin` = '$thisEpin' AND `updated_date` BETWEEN '$beginingDate' AND '$endDate'");
    if (!is_null($walletSum[0]['credit'])) {
        echo $thisEpin . ": " . $walletSum[0]['credit'] . "<br />";
        if ($crud->Read('weekly_credits', " `epin` = '$thisEpin' AND `start_date` = '$beginingDate' AND `end_date` = '$endDate'")) {
            $crud->Update('weekly_credits', array(
                'total_credit' => $walletSum[0]['credit']
            ), " `epin` = '$thisEpin' AND `start_date` = '$beginingDate' AND `end_date` = '$endDate'");
        } else {
            $crud->Create(array(
                'epin' => $thisEpin,
                'start_date' => $beginingDate,
                'end_date' => $endDate,
                'week_no' => date('W'),
                'total_credit' => $walletSum[0]['credit']
            ), 'weekly_credits');
        }
    }
}
