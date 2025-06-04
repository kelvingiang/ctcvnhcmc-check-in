<?php

class Admin_Check_In_Setting_Controler
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'CheckInReportAdminMenu'));
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function CheckInReportAdminMenu()
    {
        $parent_slug = 'tw_checkin';
        $page_title = '報到設定';
        $menu_title = '報到設定';
        $capability = 'manage_categories';
        $menu_slug = 'checkinsetting';
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'));
    }

    public function dispatchActive()
    {
        //        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'report':
                $this->exportAction();
                break;
            case 'guests':
                $this->guestsAction();
                break;
            case 'member':
                $this->memberAction();
                break;
            case 'import':
                $this->importAction();
                break;
            case 'qrcode':
                $this->createQRCodeAction();
                break;
            case 'modify':
                $this->modifyFileNameAction();
                break;
            case 'reset':
                $this->resetCheckInAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(HCM_DIR_VIEW . 'check_in_setting_view.php');
    }

    public function exportAction()
    {
        require_once(HCM_DIR_MODEL . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExportToExcel();
    }

    public function guestsAction()
    {
        require_once(HCM_DIR_MODEL . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExportToGuests();
    }

    public function memberAction()
    {
        require_once(HCM_DIR_MODEL . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExportToMember();
        // ExportToMember();
        exit;
    
    }

    public function importAction()
    {
        require_once(HCM_DIR_VIEW . 'check_in_import_view.php');
        if (isPost()) {
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);
            //$name = $_SESSION['login'];
            // $cus_name = 'avatar-'.$name . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = HCM_DIR_FILE;
                move_uploaded_file($file_tmp, ($path . $file_name));

                // $excelList = $path . $file_name;
                // $model = new Admin_Model_Check_In_Setting();
                // $model->ImportMember($excelList);

                $paged = max(1, getParams('paged'));
                $url = 'admin.php?page=' . 'checkinsetting' . '&paged=' . $paged . '&msg=1';
                //$url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
                wp_redirect($url);
            }
        }
    }

    public function createQRCodeAction()
    {
        require_once(HCM_DIR_MODEL . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->BatchCreateQRCode();

        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

    public function modifyFileNameAction()
    {
        require_once(HCM_DIR_MODEL . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ModifyQRCodeFileName();

        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=2';
        wp_redirect($url);
    }

    public function resetCheckInAction()
    {
        require_once(HCM_DIR_MODEL . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ResetCheckIn();

        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=3';
        wp_redirect($url);
    }
}
