<?php
require_once(DIR_MODEL . 'model-check-in-event-function.php');


class Controller_Check_In_Event
{
    private $_model = null;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'create'));
        $this->_model = new Model_Check_In_Event_Function();
    }

    public function create()
    {
        $page_title = '報到事件';
        $menu_title = '報到事件';
        $capability = 'manage_categories';
        $parent_slug = 'tw_checkin';
        $menu_slug = 'check_in_event_page';
        // $icon = PART_ICON . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18;
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $position);
    }

    // Phan dieu huong 
    public function dispatchActive()
    {
        $action = getParams('action');
        switch ($action) {
            case 'add':
            case 'edit':
                $this->saveAction();
                break;
            case 'delete':
                $this->deleteAction();
                break;
            case 'trash':
            case 'restore':
                $this->trashAction();
                break;
            case 'active':
                $this->activeAction();
                break;
            case 'view':
                $this->viewAction();
                break;
            case 'reset':
                $this->resetAction();
                break;
            case 'export':
                $this->exportAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function createUrl()
    {
        echo $url = 'admin.php?page=' . getParams('page');

        //filter_status
        if (getParams('filter_check-in') != '0') {
            $url .= '&filter_check_in=' . getParams('filter_check_in');
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
        if (getParams('action') == -1) {
            $url = $this->createUrl();
            wp_redirect($url);
        }
        // NEN TACH ROI HTML VA CODE WP RA CHO DE QUAN LY
        require_once(DIR_VIEW . 'view-check-in-event.php');
    }

    public function exportAction()
    {
        $id = getParams('id');
        $this->_model->exportCheckIn($id);
    }

    // THEM MOI ITEM
    public function saveAction()
    {
        // KIEM TRA PHUONG THUC GET HAY POST
        if (isPost()) {
            $option = getParams('action');
            $this->_model->saveItem($_POST, $option);
            ToBack(1);
        }
        require_once(DIR_VIEW . 'from-check-in-event.php');
    }

    // XOA DU LIEU
    public function deleteAction()
    {
        //$arrParam = getParams();
        $this->_model->deleteItem(getParams());
        ToBack();
    }

    public function restoreAction()
    {
        $this->_model->trashItem(getParams());
        ToBack();
    }

     public function resetAction()
    {
        $this->_model->resetItem(getParams());
        ToBack();
    }

    public function trashAction()
    {
        $this->_model->trashItem(getParams());
        ToBack();
    }

    public function activeAction()
    {
        $this->_model->activeItem(getParams());
        ToBack();
    }

    public function viewAction()
    {
        require_once(DIR_VIEW . 'view-check-in-event-detail.php');
    }
}
