<?php

// KIEM TRA  WP_List_Table CO TON TAI CHUA NEU CHUA SE INCLUSE VAO
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php ';
}

class Model_Check_In extends WP_List_Table
{

    private $_pre_page = 30;
    private $_sql;
    private $_tbl_check_in_event;
    private $_tbl_check_in;
    private $_tbl_guests;
    private $_event_id;

    public function __construct($args = array())
    {
        $args = array(
            'plural' => 'ID', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'singular' => 'ID', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'ajax' => FALSE,
            'screen' => null,
        );
        parent::__construct($args);

        global $wpdb;
        $this->_tbl_guests = $wpdb->prefix . 'guests';
        $this->_tbl_check_in = $wpdb->prefix . 'guests_check_in';
        $this->_tbl_check_in_event = $wpdb->prefix . 'guests_check_in_event';
        $sql = "SELECT ID FROM $this->_tbl_check_in_event WHERE status = 1";
        $row = $wpdb->get_row($sql, ARRAY_A);
        $this->_event_id = $row['ID'];
    }

    // HAM NAY BAT BUOT PHAI CO QUAN TRONG DE SHOW LIST RA
    //  CAC THONG SO VA DU LIEU CAN  CUNG CAP DE HIEN THI GIRDVIEW
    public function prepare_items()
    {
        $columns = $this->get_columns();  // NHUNG GI CAN HIEN THI TREN BANG 
        $hidden = $this->get_hidden_columns(); // NHUNG COT TA SE AN DI
        $sorttable = $this->get_sortable_columns(); // CAC COT DC SAP XEP TANG HOAC GIAM DAN

        $this->_column_headers = array($columns, $hidden, $sorttable); //DUA 3 GIA TRI TREN VAO DAY DE SHOW DU LIEU
        $this->items = $this->table_data(); // LAY DU LIEU TU DATABASE

        $total_items = $this->total_items(); // TONG SO DONG DA LIEU
        $per_page = $this->_pre_page; // SO TRANG 
        $total_pages = ceil($total_items / $per_page); // TONG SO TRANG
        // PHAN TRANG
        $args = array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => $total_pages
        );
        $this->set_pagination_args($args);
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM NHAT DINH  PHAI CO CHO LIST NAY
    //---------------------------------------------------------------------------------------------
    // LAY CAC COT TUONG UNG TRONG DATABASE DAN VAO CAC COT TREN LUOI
    public function get_columns()
    {
        $arr = array(
            'cb' => '<input type="checkbox" />',
            //   'id'            => 'ID',
            'stt' => '編號',
            'img' => '照片',
            'fullname' => '姓名',
            'company' => '公司',
            'position' => '職稱',
            // 'phone' => '電話',
            'barcode' => '條碼',
            'email' => 'email',
            'checkin' => '報到',
            'createDate' => '日期',
        );
        return $arr;
    }

    // KHIA BAO CAC COT BI AN DI TREN GRIDVIEW
    public function get_hidden_columns()
    {
        return array('country', 'email', 'img');
    }

    // COLUMN SAP XEP THU TANG HOAC GIAM DAN
    public function get_sortable_columns()
    {
        return array(
            'stt' => array('stt', true),
            // 'checkin' => array('check_in', true),
            'country' => array('country', true),
            'id' => array('id', true),
        );
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM GET DATA TU DATABASE
    //---------------------------------------------------------------------------------------------
    // GET DATA TRONG DATABASE 
    private function table_data()
    {
        $data = array();
        global $wpdb;
        // LAY GIA TRI SAP XEP DU LIEU TREN COT
        $orderby = (getParams('orderby') == ' ') ? 'ID' : $_GET['orderby'];
        $order = (getParams('order') == ' ') ? 'DESC' : $_GET['order'];
        $sql = 'SELECT m.* FROM ' . $this->_tbl_guests . ' AS m ';
        $whereArr = array();  // TAO MANG WHERE

        if (getParams('customvar') == 'trash') {
            $whereArr[] = "(status = 0)";
        } else {
            $whereArr[] = "(status = 1)";
        }

        if (getParams('s') != ' ') {
            $s = esc_sql(getParams('s'));
            $whereArr[] = "(m.full_name  LIKE '%$s%' OR m.stt LIKE '%$s%' OR m.barcode = '$s' )";
        }

        // CHUYEN CAC GIA TRI where KET VOI NHAU BOI and
        if (count($whereArr) > 0) {
            $sql .= " WHERE " . join(" AND ", $whereArr);
        }

        // orderby
        $sql .= 'ORDER BY m.' . esc_sql($orderby) . ' ' . esc_sql($order);

        $this->_sql = $sql;


        //LAY GIA TRI PHAN TRANG PAGEING
        $paged = max(1, @$_REQUEST['paged']);
        $offset = ($paged - 1) * $this->_pre_page;

        $sql .= ' LIMIT  ' . $this->_pre_page . ' OFFSET ' . $offset;

        // LAY KET QUA  THONG QUA CAU sql
        $data = $wpdb->get_results($sql, ARRAY_A);

        return $data;
    }

    // TINH TONG SO DONG DU LIEU  DE AP DUNG CHO VIEC PHAN TRANG
    public function total_items()
    {
        global $wpdb;
        return $wpdb->query($this->_sql);
    }

    // SO TONG ITEM DUNG DE PHAN TRANG
    public function total_list()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->_tbl_guests");
    }

    // SO TONG ITEM TRONG TRASH(SO RAC)
    public function total_trash()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->_tbl_guests WHERE status = 0");
    }

    // SO TONG ITEM HIEN HANH
    public function total_publish()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->_tbl_guests WHERE status = 1");
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM CAC SELECT BOX O DAU CUA LIST
    //---------------------------------------------------------------------------------------------
    //
    // PHAN SHOW THONG KE SO ITEM O DAU LIST (tong so item, so item hien hanh, so item trong trash)
    function get_views()
    {
        $views = array();
        $current = (!empty($_REQUEST['customvar']) ? $_REQUEST['customvar'] : 'all');

        //All link
        $class = ($current == 'all' ? ' class="current"' : '');
        $all_url = remove_query_arg('customvar');
        $views['all'] = "<strong>" . __('All') . " (" . $this->total_list() . ")</strong>";

        //Foo link
        $foo_url = add_query_arg('customvar', 'published');
        $class = ($current == 'foo' ? ' class="current"' : '');
        $views['foo'] = "<a href='{$foo_url}' {$class} > " . __('Published') . " (" . $this->total_publish() . ")</a>";

        //Bar link
        $bar_url = add_query_arg('customvar', 'trash');
        $class = ($current == 'bar' ? ' class="current"' : '');
        $views['bar'] = "<a href='{$bar_url}' {$class} >" . __('Trash') . "(" . $this->total_trash() . ")</a>";

        return $views;
    }

    //
    // CAC ITEM TRONG SELECT BOX CHUC NANG 'UNG DUNG'
    public function get_bulk_actions()
    {
        if (isset($_GET['customvar']) && $_GET['customvar'] == 'trash') {
            $actions = array(
                'restore' => '還原',
                'delete' => '永久刪除'
            );
        } else {
            $actions = array(
                'trash' => '回收桶',
                'uncheckin' => '取消報到'
            );
        }
        return $actions;
    }

    // CAC ITEM TRONG SECLETBOX TRONG PHAN FILTER
    public function extra_tablenav($which)
    {
        //        if ($which == 'top') {
        //            $htmlObj = new MyHtml();
        //
        //            $filterVal = @$_REQUEST['filter_status'];
        //            $options['data'] = array(
        //                '0' => 'status filter',
        //                'active' => 'Active',
        //                'inactive' => 'Inactive'
        //            );
        //
        //            $slbFilter = $htmlObj->selectbox('filter_status', $filterVal, array(), $options);
        //            $attr = array('id' => 'filter_action', 'class' => 'button');
        //            $btnFilter = $htmlObj->button('filter_action', 'Filter', $attr);
        //
        //            echo '<div class="alignleft action bulkactions">' . $slbFilter . $btnFilter . '</div>';
        //        }
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM THIET LAP GIA TRI CHO CAC CLOUMN
    //---------------------------------------------------------------------------------------------
    // TAO CAC CHECK BOS O DAU DONG TRONG 
    public function column_stt($item)
    {
        echo $item['stt'];
    }


    public function column_cb($item)
    {
        $singular = $this->_args['singular'];
        $html = '<input type="checkbox" name="' . $singular . '[]" value="' . $item['ID'] . '"/>';
        return $html;
    }

    // THEM CAC PHAN CHINH SUA NHANH TAI COLUMN NAY
    //DAT TEN column_TEN COLUMN CAN TAO CAC CHINH SUA NHANH
    public function column_fullname($item)
    {
        $page = getParams('page');
        $name = 'security_code';
        //        $linkDelete = add_query_arg(array('action' => 'delete', 'id' => $item['id']));
        //        $action = 'delete_id' . $item['id'];
        //        $linkDelete = wp_nonce_url($linkDelete, $action, $name);

        if (isset($_GET['customvar']) && $_GET['customvar'] == 'trash') {
            $actions = array(
                'restore' => '<a href=" ?page=' . $page . '&action=restore&id=' . $item['ID'] . ' " >還原 </a>',
                'delete' => '<a href=" ?page=' . $page . '&action=delete&id=' . $item['ID'] . ' " >永久刪除 </a>',
                // 'view' => '<a href ="#">View</a>'
            );
        } else {
            $actions = array(
                'edit' => '<a href=" ?page=' . $page . '&action=edit&id=' . $item['ID'] . ' " > 編輯 </a>',
                'trash' => '<a href=" ?page=' . $page . '&action=trash&id=' . $item['ID'] . ' " > 回收桶 </a>',
                // 'view' => '<a href ="#">View</a>'
            );
        }
        $html = '<strong> <a href="?page=' . $page . '&action=edit&id=' . $item['ID'] . ' ">' . $item['full_name'] . '</a> </strong>' . $this->row_actions($actions);
        return $html;
    }

    public function column_checkin($item)
    {
        global $wpdb;
        $sql = "SELECT ID FROM $this->_tbl_check_in WHERE member_id = " . $item['ID'] . " AND event_id =" . $this->_event_id;
        $row = $wpdb->get_row($sql, ARRAY_A);
        $paged = max(1, @$_REQUEST['paged']);


        $page = getParams('page');
        if (isset($row['ID']) || !empty($row['ID'])) {
            // $action = 'inactive';
            $src = get_icon('active32x32.png');
            $linkStatus = add_query_arg(array('action' => 'checkin', 'check' => 0, 'id' => $item['ID'], 'paged' => $paged));
        } else {
            // $action = 'active';
            $linkStatus = add_query_arg(array('action' => 'checkin', 'check' => 1, 'id' => $item['ID'], 'paged' => $paged));
            $src = get_icon('inactive32x32.png');
        }


        if (getParams('customvar') != 'trash') {
            $html = '<img alt="" src=" ' . $src . ' " />';
            $html = '<a href ="' . $linkStatus . ' ">' . $html . '</a>';
        } else {
            $html = '<img alt="" src=" ' . $src . ' " />';
            $html = '<a href ="#">' . $html . '</a>';
        }
        return $html;
    }

    // LAY GIA TRI MA THONG QUA QUA HAM get_country SHOW TEN RA
    public function column_position($item)
    {
        echo $item['position'];
    }

    public function column_createDate($item)
    {
        echo $item['create_date'];
    }

    //CAC COLUMN MAC DINH KHI LOAD TRANG SE SHOW LEN 
    public function column_default($item, $column_name)
    {
        return $item[$column_name];
    }
}
