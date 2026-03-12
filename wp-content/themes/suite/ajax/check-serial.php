<?php

define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$serial = $_POST['serial'];

if (!empty($serial)) {
    global $wpdb;
    $table = $wpdb->prefix . 'guests';
    $sql = "SELECT ID, stt FROM $table WHERE stt = $serial";
    $row = $wpdb->get_row($sql, ARRAY_A);

    if (empty($row)) {
        $response = array('status' => 'done', 'message' => $serial);
    } else {
        $response = array('status' => 'has', 'message' => $row);
    }
}
echo json_encode($response);
