<?php

class Model_Check_In_Report
{
    private $_table_guest;
    private $_table_check_in;
    private $_table_check_in_event;
    private $_event_id;

    public function __construct()
    {
        global $wpdb;
        $this->_table_guest = $wpdb->prefix . 'guests';
        $this->_table_check_in = $wpdb->prefix . 'guests_check_in';
        $this->_table_check_in_event = $wpdb->prefix .  'guests_check_in_event';
        $this->_getEventID();
    }


    /* =========================================================
    LAY ID CUA EVENT HIEN HAN
    ========================================================= */
    private function _getEventID()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_check_in_event WHERE status = 1 AND trash = 0";
        $row = $wpdb->get_row($sql, ARRAY_A);
        $this->_event_id = $row['ID'];
    }

    public function getActionEvent()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_check_in_event WHERE status = 1 AND trash = 0";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function getActionEventById($id)
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_check_in_event WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function ReportView()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_guest WHERE status = 1 AND trash = 0";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function RegisterTotal()
    {
        global $wpdb;
        $sql = "SELECT COUNT(ID) AS count FROM $this->_table_guest WHERE status = 1";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function ReportJoinView()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_guest AS A LEFT JOIN $this->_table_check_in AS B ON A.ID = B.member_id
                  WHERE A.status = 1 AND B.event_id = $this->_event_id
                  GROUP BY B.member_id
                  ORDER BY B.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportJoinViewByID($id)
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_guest AS A LEFT JOIN $this->_table_check_in AS B ON A.ID = B.member_id
                  WHERE A.status = 1 AND B.event_id = $id
                  GROUP BY B.member_id
                  ORDER BY B.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function getAllMember()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_guest order by member_code ASC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }
}
