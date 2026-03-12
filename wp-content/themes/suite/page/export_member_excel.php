<?php
/* Template Name: Export Member Excel */
require_once(HCM_DIR_CLASS . '/PHPExcel.php');

$exExport = new PHPExcel();
$sheet = $exExport->getActiveSheet()->setTitle("會員");

// 設定欄位標題
$sheet->setCellValue('A1', '公司名稱');
$sheet->setCellValue('B1', '聯絡人');
$sheet->setCellValue('C1', '經營項目');
$sheet->setCellValue('D1', '地址');
$sheet->setCellValue('E1', '電話');
$sheet->setCellValue('F1', '傳真');
$sheet->setCellValue('G1', 'E-mail');
$sheet->setCellValue('H1', 'Web');
//     // set kich thuoc cot  
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setWidth(15);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);

// set chieu cao cua dong
$sheet->getRowDimension('1')->setRowHeight(30);
// set to dam chu
$sheet->getStyle('A')->getFont()->setBold(TRUE);
$sheet->getStyle('A1:H1')->getFont()->setBold(TRUE);
// set nen backgroup cho dong
$sheet->getStyle('A1:H1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0008bdf8');
// set chu canh giua
$sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


// 資料
$args = array(
    'post_type' => 'member',
    'posts_per_page' => -1
);
$members = get_posts($args);

$i = 2;
foreach ($members as $post) {
    $id = $post->ID;
    $sheet->setCellValue('A' . $i, $post->post_title);
    $sheet->setCellValue('B' . $i, get_post_meta($id, '_member_contact', true));
    $sheet->setCellValue('C' . $i, get_post_meta($id, '_member_industry', true));
    $sheet->setCellValue('D' . $i, get_post_meta($id, '_member_address', true));
    $sheet->setCellValue('E' . $i, get_post_meta($id, '_member_phone', true));
    $sheet->setCellValue('F' . $i, get_post_meta($id, '_member_fax', true));
    $sheet->setCellValue('G' . $i, get_post_meta($id, '_member_email', true));
    $sheet->setCellValue('H' . $i, get_post_meta($id, '_member_web', true));
    $i++;
    // phan set border 
    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    //cho tat ca 
    $sheet->getStyle('A1:' . 'H' . ($i - 1))->applyFromArray($styleArray);
    $checkInItem = '';
}

$filename = date("YmdHis") . '_member.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
$objWriter->save('php://output');
exit;
