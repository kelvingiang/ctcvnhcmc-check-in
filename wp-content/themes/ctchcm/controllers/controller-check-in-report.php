<?php
require_once(DIR_MODEL . 'model-check-in-report.php');
class Controller_Check_In_Report
{
    private $_model;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'CheckInReportAdminMenu'));
        $this->_model = new Model_Check_In_Report();
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function CheckInReportAdminMenu()
    {
        $parent_slug = 'tw_checkin';
        $page_title = '報到報表';
        $menu_title = '報到報表';
        $capability = 'manage_categories';
        $menu_slug = 'checkinreport';
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'));
    }

    public function dispatchActive()
    {
        //        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'export':
                $this->exportAction();
                break;
            case 'waiting':
                $this->WaitingAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(DIR_VIEW . 'view-check-in-report.php');
    }

    public function exportAction()
    {
        $data = $this->_model->ReportJoinView();
        export_excel_check_in($data);
    }

    public function WaitingAction()
    {
        if (isPost()) {
            update_option( '_waiting_text', $_POST['txt_waiting'] );
            ToBack();
        } else {
            require_once(DIR_VIEW . 'view-check-in-waiting.php');
        }
    }
}
