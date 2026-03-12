<?php

define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$barcode = $_POST['barcode'];
$eventID = $_POST['eventID'];

if (!empty($barcode)) {
    global $wpdb;
    $tbl_guests = $wpdb->prefix . 'guests';
    $tbl_check_in = $wpdb->prefix . 'guests_check_in';
    // lấy thông tin thành viên thông qua Barcode
    $sql = "SELECT * FROM $tbl_guests WHERE barcode = $barcode";
    $row = $wpdb->get_row($sql, ARRAY_A);


    // end ================================================================================================      

    if (!empty($row)) {
        if ($row['status'] == 1) {
            // lấy thông tin số lấy check in =============
            $sql2 = "SELECT time, date,  COUNT(ID) as count FROM $tbl_check_in WHERE member_id =" . $row['ID'] . " AND event_id = " . $eventID . " ORDER BY time DESC LIMIT 1";
            $row2 = $wpdb->get_row($sql2, ARRAY_A);

            $data = array(
                'member_id' => $row['ID'],
                'event_id' => $eventID,
                'time' => date('H:i:s'),
                'date' => date('m-d-Y'),
            );
            $wpdb->insert($tbl_check_in, $data);

            $info = array(
                'FullName' => $row['full_name'],
                'MemberCode' => $row['stt'],
                'Position' => $row['position'],
                'Company' => $row['company'],
                'Email' => $row['email'],
                'Phone' => $row['phone'],
                'Note' => $row['note'],
                'TotalTimes' => $row2['count'],
                'LastCheckIn' => $row2['date'] . ' / ' . $row2['time']
            );

            $response = array('status' => 'done', 'message' => $row['ID'], 'info' => $info,);
        } else {
            $response = array('status' => 'not', 'message' => "not active");
        }
    } else {
        $response = array('status' => 'error', 'message' => '0000');
    }
}
echo json_encode($response);
