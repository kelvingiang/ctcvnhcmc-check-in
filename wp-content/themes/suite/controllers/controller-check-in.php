<?php

class Controller_Check_In
{

    private $model;
    private $params;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'checkInToMenu'));
        require_once(DIR_MODEL . 'model-check-in-function.php');
        $this->model = new Model_Check_In_Function();
        $this->params = $_REQUEST;
    }

    public function do_output_buffer()
    {
        ob_start();
    }

    public function checkInToMenu()
    {
        // THEM 1 NHOM MENU MOI VAO TRONG ADMIN MENU
        $page_title = '報到系統'; // TIEU DE CUA TRANG 
        $menu_title = '報到系統 ';  // TEN HIEN TRONG MENU
        // CHON QUYEN TRUY CAP manage_categories DE role ADMINNITRATOR VÀ EDITOR DEU THAY DUOC
        $capability = 'manage_categories'; // QUYEN TRUY CAP DE THAY MENU NAY
        $menu_slug = 'tw_checkin'; // TEN slug TEN DUY NHAT KO DC TRUNG VOI TRANG KHAC GAN TREN THANH DIA CHI OF MENU
        // THAM SO THU 5 GOI DEN HAM HIEN THI GIAO DIEN TRONG MENU
        $icon = URI_ICON . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 17; // VI TRI HIEN THI TRONG MENU

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    // Phan dieu huong 
    public function dispatchActive()
    {
        $action =   $this->params['action'] ?? null;
        switch ($action) {
            case 'add':
            case 'edit':
                $this->saveAction();
                break;
            case 'trash':
            case 'restore':
                $this->trashAction();
                break;
            case 'delete':
                $this->deleteAction();
                break;
            case 'checkin':
                $this->checkInAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function createUrl()
    {
        $url = 'admin.php?page=' . getParams('page');
        //filter_status
        if (getParams('filter_status') != '0') {
            $url .= '&filter_status=' . getParams('filter_status');
        }

        if (mb_strlen(getParams('s'))) {
            $url .= '&s=' . getParams('s');
        }
        return $url;
    }

    //---------------------------------------------------------------------------------------------
    // Cmt CAC CHUC NANG THEM XOA SUA VA HIEN THI
    //---------------------------------------------------------------------------------------------
    // CAC DISPLAY PAGE
    public function displayPage()
    {
        // LOC DU LIEU KHI action = -1 CO NGHIA LA DANG LOI DU LIEU (CHO 2 TRUONG HOP search va filter)
        if (isset($this->params['action']) && $this->params['action'] == -1) {
            $url = $this->createUrl();
            wp_redirect($url);
        }
        // NEN TACH ROI HTML VA CODE WP RA CHO DE QUAN LY
        require_once(DIR_VIEW . 'view-check-in.php');
    }

    // THEM MOI ITEM
    public function saveAction()
    {
        // KIEM TRA PHUONG THUC GET HAY POST
        if (isPost()) {
            $this->model->saveItem($_POST);
            ToBack();
        }
        require_once(DIR_VIEW . 'from-check-in.php');
    }



    public function checkInAction()
    {
        $this->model->checkInItem($this->params);
        ToBack();
    }

    // XOA DU LIEU
    public function deleteAction()
    {
        $this->model->deleteItem(getParams());
        ToBack();
    }

    public function trashAction()
    {
        $this->model->trashItem(getParams());
        ToBack();
    }
}
