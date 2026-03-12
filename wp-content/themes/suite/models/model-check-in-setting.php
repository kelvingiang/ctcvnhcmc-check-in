<?php

class Model_Check_In_Setting
{
    private $_guests;
    private $_guests_check_in;
    public function __construct()
    {
        global $wpdb;
        $this->_guests =  $wpdb->prefix . 'guests';
        $this->_guests_check_in =  $wpdb->prefix . 'guests_check_in';
    }

    public function ReportView()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT * FROM $this->_guests WHERE check_in = 1 AND status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    // KET HOP 2 TABLE DE LAY DU LIEU
    public function ReportjoinView()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_guests  LEFT JOIN  $this->_guests_check_in ON $this->_guests.ID  = $this->_guests_check_in.guests_id 
                  WHERE $this->_guests.check_in = 1 AND $this->_guests.status = 1
                      GROUP BY $this->_guests_check_in.guests_id
                  ORDER BY $this->_guests_check_in.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function GuestsInfo()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_guests";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportDetailView($guests_id)
    {
        global $wpdb;
        // LAY GIA TRI CU NHAT TRONG GROUP BY
        $sql = "SELECT * FROM $this->_guests_check_in WHERE guests_id = $guests_id AND ID IN(SELECT MAX(ID) FROM $this->_guests  GROUP BY guests_id)";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }


    public function ExportToGuests()
    {
        $data = $this->GuestsInfo();
        export_excel_guests($data);
    }


    public function ImportMember($filename)
    {
        $data = import_excel_guests($filename);
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE $this->_guests");

        foreach (array_slice($data, 1) as $item) {

            $email = $item[5] == null ? "" : $item[5];
            $phone = $item[6] == null ? "" : $item[6];
            $note = $item[7] == null ? "" : $item[7];
            $data = array(
                'stt' => $item[0],
                'barcode' => $this->createCode($item[0]),
                'company' => $item[2],
                'full_name' => $item[3],
                'position' => $item[4],
                'email' => $email,
                'phone' => $phone,
                'note' => $note,
                'check_in' => 0,
                'status' => 1,
                'create_date' => date('d-m-Y'),
            );
            $wpdb->insert($this->_guests, $data);
        }
    }

    public function ImportAdditionalMember($filename)
    {
       $data = import_excel_guests($filename);
        global $wpdb;
        // $wpdb->query("TRUNCATE TABLE $this->_guests");

        foreach (array_slice($data, 1) as $item) {

            $email = $item[5] == null ? "" : $item[5];
            $phone = $item[6] == null ? "" : $item[6];
            $note = $item[7] == null ? "" : $item[7];
            $data = array(
                'stt' => $item[0],
                'barcode' => $this->createCode($item[0]),
                'company' => $item[2],
                'full_name' => $item[3],
                'position' => $item[4],
                'email' => $email,
                'phone' => $phone,
                'note' => $note,
                'check_in' => 0,
                'status' => 1,
                'create_date' => date('d-m-Y'),
            );
            $wpdb->insert($this->_guests, $data);
        }
    }



    public function BatchCreateQRCode()
    {
        global $wpdb;
        // $table = $wpdb->prefix . 'guests';
        $sql = "SELECT stt, full_name, barcode FROM $this->_guests";
        $row = $wpdb->get_results($sql, ARRAY_A);

        // XOA HET CAC FILE QRCODE .png CO TRONG FOLDER
        $files = glob(DIR_IMAGES . 'qrcode/' . '*.png'); //get all file names
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file); //delete file
        }
        foreach ($row as $item) {
            create_QRCode_Img($item['barcode'], $item['stt'], 0);
        }
    }

    public function BatchCreateQRCodeHasName()
    {
        global $wpdb;
        // $table = $wpdb->prefix . 'guests';
        $sql = "SELECT stt, full_name, barcode FROM $this->_guests";
        $row = $wpdb->get_results($sql, ARRAY_A);

        // XOA HET CAC FILE QRCODE .png CO TRONG FOLDER
        $files = glob(DIR_IMAGES . 'qrcode_name/' . '*.png'); //get all file names
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file); //delete file
        }
        foreach ($row as $item) {
            create_QRCode_Img($item['barcode'], $item['stt'], 1);
        }
    }


    public function createCode($data)
    {
        $serial = trim($data);
        $strLength =  strlen($serial);
        $t = time();
        $cc = '';
        if ($strLength == 3) {
            $cc = substr($t, -9);
        } elseif ($strLength == 4) {
            $cc = substr($t, -8);
        }
        return $serial . $cc;
    }


}
