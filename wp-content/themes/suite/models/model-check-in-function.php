<?php

class Model_Check_In_Function
{
    private $_guests;
    private $_check_in;
    private $_event;

    public function __construct()
    {
        global $wpdb;
        $this->_guests = $wpdb->prefix . 'guests';
        $this->_check_in = $wpdb->prefix . 'guests_check_in';
        $this->_event = $wpdb->prefix . 'guests_check_in_event';
    }

    //CAC FUNCTION XU LY DATA  
    public function get_item($arrData = array(), $option = array())
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_guests WHERE ID = " . $arrData['id'];
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function trashItem($arrData = array(), $option = array())
    {
        global $wpdb;
        if ($arrData['action'] == 'trash') {
            $trash = 0;
        } elseif ($arrData['action'] == 'restore') {
            $trash = 1;
        }

        if (!is_array($arrData['id'])) {
            $data = array('status' => $trash);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($this->_guests, $data, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_guests SET `status` =  $trash   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function checkInItem($arrData = array(), $option = array())
    {
        global $wpdb;
        $sql = "SELECT ID FROM $this->_event WHERE status = 1";
        $row = $wpdb->get_row($sql, ARRAY_A);
        // echo '<pre>'; print_r($arrData); echo '</pre>';
        // die();
        // CHECK IN
        if ($arrData['check'] == '1') {
            $data = array(
                'member_id' => $arrData['id'],
                'event_id' => $row['ID'],
                'time' => date('H:i:s'),
                'date' => date('m-d-Y'),
            );
            // echo '<pre>'; print_r($data); echo '</pre>';
            // die();
            $wpdb->insert($this->_check_in, $data);
        } elseif ($arrData['check'] == '0') {
            $where = array(
                'member_id' => $arrData['id'],
                'event_id'  => $row['ID']
            );
            // echo '<pre>'; print_r($where); echo '</pre>';
            // die();
            $wpdb->delete($this->_check_in, $where);
        }
    }

    public function deleteItem($arrData = array(), $option = array())
    {
        global $wpdb;
        if (!is_array($arrData['id'])) {
            $this->del_img(absint($arrData['id']));
            // XOA TRONG CSDL
            $where = array('ID' => absint($arrData['id']));
            $wpdb->delete($this->_guests, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            foreach ($arrData['id'] as $item) {
                $this->del_img($item);
            }
            $ids = join(',', $arrData['id']);
            $sql = "DELETE FROM $this->_guests  WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    private function del_img($id)
    {
        global $wpdb;

        $sql = "SELECT * FROM $this->_guests WHERE ID =" . $id;
        $row = $wpdb->get_row($sql, ARRAY_A);
        $img = $row['img'];
        $barcode = $row['barcode'] . '.png';
        // XOA HINH DAI DIEN
        if (is_file(DIR_IMAGES . 'guests/' . $img)) {
            unlink(DIR_IMAGES . 'guests/' . $img);
        }
        // XOA HINH QRCODE
        if (is_file(DIR_IMAGES . 'qrcode/' . $barcode)) {
            unlink(DIR_IMAGES . 'qrcode/' . $barcode);
        }
    }

    public function saveItem($arrData = array(), $option = array())
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        if (isset($arrData['hidden_barcode']) and empty($arrData['hidden_barcode'])) {
            // TAO BARCODE
            $serial = trim($arrData['txt_stt']);
            $stringLenth =  strlen($serial);
            $t = time();
            if ($stringLenth == 3) {
                $cc = substr($t, -9);
            } elseif ($stringLenth == 4) {
                $cc = substr($t, -8);
            }
            $bar = $serial . $cc;

            create_QRCode_Img($bar, $arrData['txt_stt'] . '-' . $arrData['txt_fullname'], 0);
            $barcode = $bar;
        } else {
            $barcode = $arrData['hidden_barcode'] ?? null;
        }



        $data1 = array(
            'full_name' => trim($arrData['txt_fullname'] ?? null),
            'position' => $arrData['txt_position'] ?? null,
            'email' => trim($arrData['txt_email'] ?? null),
            'phone' => trim($arrData['txt_phone'] ?? null),
            'note' => $arrData['txt_note'] ?? null,
            'company' => $arrData['txt_company'] ?? null
        );

        $data2 = array(
            'barcode' => $barcode,
            'full_name' => trim($arrData['txt_fullname'] ?? null),
            'position' => $arrData['txt_position']  ?? null,
            'email' => trim($arrData['txt_email']  ?? null),
            'phone' => trim($arrData['txt_phone'] ?? null),
            'stt' => trim($arrData['txt_stt'] ?? null),
            'company' => $arrData['txt_company'] ?? null,
            'note' => $arrData['txt_note'] ?? null,
            'create_date' => date('d-m-Y'),
            'check_in' => '0',
            'status' => '1',
        );

        if (!empty($arrData['hidden_ID'])) {
            $where = array('ID' => absint($arrData['hidden_ID']));
            $wpdb->update($table, $data1, $where);
        } else {
            $wpdb->insert($table, $data2);
        }
    }

    public function checkStt($stt)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table WHERE stt = %d", $stt);
        $count = $wpdb->get_var($sql);
        return $count > 0;
    }
}
