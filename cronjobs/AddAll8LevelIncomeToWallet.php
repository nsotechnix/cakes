<?php

/**
 * AddAll8LevelIncomeToWallet.php
 * fix incorrect entry
 */

ini_set('display_errors', 1);
ini_set('max_execution_time', -1);

include('classes/Crud.php');

$crud = new Crud();

define('FIRST_LEVEL_BONUS', 200);
define('SECOND_LEVEL_BONUS', 100);
define('THIRD_LEVEL_BONUS', 50);
define('FOURTH_LEVEL_BONUS', 50);
define('FIFTH_LEVEL_BONUS', 50);
define('SIXTH_LEVEL_BONUS', 50);
define('SEVENTH_LEVEL_BONUS', 100);
define('EIGHTH_LEVEL_BONUS', 200);
$bonusArray = array(
    FIRST_LEVEL_BONUS,
    SECOND_LEVEL_BONUS,
    THIRD_LEVEL_BONUS,
    FOURTH_LEVEL_BONUS,
    FIFTH_LEVEL_BONUS,
    SIXTH_LEVEL_BONUS,
    SEVENTH_LEVEL_BONUS,
    EIGHTH_LEVEL_BONUS
);

$bonuses = [];

function findReferrer($epin) {
    global $crud;
    $data = $crud->Read('users', " `epin` = '$epin'");
    if (isset($data[0]['position_under']) && strlen($data[0]['position_under']) == 8) {
        return array(
            'epin' => $data[0]['position_under'],
            'status' => $data[0]['is_active']
        );
    } else {
        return false;
    }
}

foreach ($crud->Read('users', " `is_active` = '1' AND `is_payment_distributed` = '0' ORDER BY `id` DESC") as $key) {
    $newReferrer = findReferrer($key['epin']);
    for ($i = 0; $i < 8; $i++) {
        if ($newReferrer) {
            if ($newReferrer['status'] == 1) {
                if (array_key_exists($newReferrer['epin'], $bonuses)) {
                    $prevBonus = (int) $bonuses[$newReferrer['epin']];
                    // echo "P: ". $newReferrer['epin'] ." $prevBonus<br />";
                    $prevBonus += (int) $bonusArray[$i];
                    // echo "B: ". $newReferrer['epin'] ." $prevBonus<br />";
                    $bonuses[$newReferrer['epin']] = $prevBonus;
                } else {
                    $prevBonus = (int) $bonusArray[$i];
                    $bonuses += [$newReferrer['epin'] => $prevBonus];
                }
                // save the record
                $crud->Create(array(
                    'epin' => $newReferrer['epin'],
                    'amount' => $bonusArray[$i],
                    'for_epin' => $key['epin'],
                    'for_level' => $i + 1,
                    'added_on' => date('Y-m-d H:i:s')
                ), 'level_pay_history');
                $newReferrer = findReferrer($newReferrer['epin']);
            } else {
                $theEpinKey = $newReferrer['epin'];
                $wallet = $crud->Read('wallet', " `epin`='$key'");
                $total = (float)$wallet[0]['available'] + (float)$bonusArray[$i];
                $updateWallet = $crud->Update('wallet', [
                    'lost_balance' => $total,
                    'last_updated' => time()
                ], " `epin`='$theEpinKey'");
            }
        } else break;
    }
}
// var_dump($bonuses);

foreach ($bonuses as $key => $value) {
    echo "$key=$value<br />";
    if ($crud->Count('wallet', "`epin`='$key'") > 0) {
        $wallet = $crud->Read('wallet', " `epin`='$key'");
        $total = (float)$wallet[0]['available'] + (float)$value;
        $updateWallet = $crud->Update('wallet', [
            'available' => $total,
            'total_balance' => (float)$wallet[0]['total_balance'] + (float)$value,
            'last_updated' => time()
        ], " `epin`='$key'");
    } else {
        $total = $value;
        $updateWallet = $crud->Create(array(
            'epin' => $key,
            'total_balance' => (float)$wallet[0]['total_balance'] + (float)$value,
            'available' => (float)$value,
            'last_updated' => time()
        ), 'wallet');
    }

    $crud->Create(array(
        'epin' => $key,
        'narration' => 'Credited Joining Amount',
        'credit' => $value,
        'updated_amount' => (float)$wallet[0]['available'] + (float)$value,
        'updated_on' => time(),
        'updated_date' => date('Y-m-d')
    ), 'transaction_history');
}

$crud->Update('users', ['is_payment_distributed' => 1], " `is_payment_distributed` = '0'");
