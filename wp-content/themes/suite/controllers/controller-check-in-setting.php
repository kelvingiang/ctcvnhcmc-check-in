<?php
class Controller_Check_In_Setting
{
    private $_model;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'cerate'));
        require_once(DIR_MODEL . 'model-check-in-setting.php');
        $this->_model = new Model_Check_In_Setting();
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function cerate()
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
        // echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'guests':
                $this->guestsAction();
                break;
            case 'import':
                $this->importGuestsAction();
                break;
            case 'additional':
                $this->importGuestsAdditionalAction();
                break;
            case 'qrcode':
                $this->createQRCodeAction();
                break;
            case 'qrcode-has-name':
                $this->createQRCodeHasCodeAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(DIR_VIEW . 'view-check-in-setting.php');
    }

    public function guestsAction()
    {
        $this->_model->ExportToGuests();
    }

    public function importGuestsAction()
    {
        require_once(DIR_VIEW . 'view-check-in-import.php');
        if (isPost()) {
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = DIR_FILE;
                move_uploaded_file($file_tmp, ($path . $file_name));
                $this->_model->ImportMember($path . $file_name);
                ToBack();
            }
        }
    }

    public function importGuestsAdditionalAction()
    {
        require_once(DIR_VIEW . 'view-check-in-import.php');

        if (isPost()) {
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = DIR_FILE;
                move_uploaded_file($file_tmp, ($path . $file_name));
                $this->_model->ImportAdditionalMember($path . $file_name);
                ToBack();
            }
        }
    }

    public function createQRCodeAction()
    {
        $this->_model->BatchCreateQRCode();
        ToBack();
    }

    public function createQRCodeHasCodeAction()
    {
        $this->_model->BatchCreateQRCodeHasName();
        ToBack();
    }
}
