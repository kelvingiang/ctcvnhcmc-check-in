<?php

class controllers_Main
{

    private $_controller_name = 'controller_options';
    private $_controller_options = array();

    public function __construct()
    {
        $defaultOption = array(
            'controller_check_in_report' => TRUE,
            'controller_check_in_setting' => TRUE,
            'controller_check_in_event' => TRUE,
            'controller_setting' => false,
            'controller_check_in' => TRUE,


            // 'controller_checkin_setting' => get_current_user_id() == 1 ? TRUE : FALSE,
        );
        $this->_controller_options = get_option($this->_controller_name, $defaultOption);
        $this->page_check_in();
        $this->page_check_in_report();
        $this->page_check_in_event();
        $this->page_check_in_setting();

        add_action('admin_init', array($this, 'do_output_buffer'));
    }

    /* FUNCTION NAY GIAI VIET CHUYEN TRANG BI LOI  */

    public function do_output_buffer()
    {
        ob_start();
    }

    // page ========================================================


    public function page_check_in()
    {
        if ($this->_controller_options['controller_check_in'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller-check-in.php');
            new Controller_Check_In();
        }
    }

    public function page_check_in_report()
    {
        if ($this->_controller_options['controller_check_in_report'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller-check-in-report.php');
            new Controller_Check_In_Report();
        }
    }

    public function page_check_in_setting()
    {
        if ($this->_controller_options['controller_check_in_setting'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller-check-in-setting.php');
            new Controller_Check_In_Setting();
        }
    }

    public function page_check_in_event()
    {
        if ($this->_controller_options['controller_check_in_event'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller-check-in-event.php');
            new Controller_Check_In_Event();
        }
    }
}
