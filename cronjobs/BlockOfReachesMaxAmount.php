<?php

/**
 * BlockOfReachesMaxAmount.php
 * check users who've reached more than provided amount in 4 weeks
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
$currentWeek = date('W');

foreach ($crud->Read('users', " `is_active` = '1'") as $key) {
    $thisEpin = $key['epin'];
    $searchWeek = 4;
    $searchOffset = 0;
    if (date('W') % 4 == 1) {
        $searchOffset = 1;
    }
    $walletSum = $crud->GetSum('weekly_credits', 'total_credit', " `epin` = '$thisEpin' ORDER BY `id` DESC LIMIT $searchWeek OFFSET $searchOffset");
    if (!is_null($walletSum[0]['total_credit'])) {
        if ((int)$walletSum[0]['total_credit'] < 5000) {
            continue;
        } else if ((int)$walletSum[0]['total_credit'] >= 5000 && (int)$walletSum[0]['total_credit'] <= 9999 && date('W') % 4 == 2) {
            $crud->Update('users', array(
                'is_active' => 2,
                'pending_started_date' => $today,
                'pending_user_total_amount' => $walletSum[0]['total_credit'],
                'pending_per_month_purchase' => 1500
            ), " `epin` = '$thisEpin'");
        } else if ((int)$walletSum[0]['total_credit'] >= 10000 && date('W') % 4 == 2) {
            $crud->Update('users', array(
                'is_active' => 2,
                'pending_started_date' => $today,
                'pending_user_total_amount' => $walletSum[0]['total_credit'],
                'pending_per_month_purchase' => 2000
            ), " `epin` = '$thisEpin'");
        }
    }
}
