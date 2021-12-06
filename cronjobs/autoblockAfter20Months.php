<?php

ini_set('display_errors', 1);
require_once('classes/Crud.php');

$crud = new Crud();

/**
 * block every member who've joined before 20 months
 */

$twentyMonthsBefore = strtotime(date('Y-m-d') . ' -20 months');

foreach ($crud->Read('users', " `is_admin_unlocked_after_expiration` = '0' AND `is_active` = '1' AND `joined_on` <= '$twentyMonthsBefore'") as $key) {
    $thisEpin = $key['epin'];
    $crud->Update('users', array(
        'is_active' => 3
    ), " `epin` = '$thisEpin'");
    echo $thisEpin . "<br />";
}
