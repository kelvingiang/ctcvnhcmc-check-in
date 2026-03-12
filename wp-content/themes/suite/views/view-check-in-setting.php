<?php
require_once(DIR_MODEL . 'model-check-in-report.php');
$model = new Model_Check_In_Report();
//$list = $model->ReportView();
$page = getParams('page');
$msg = getParams('msg');

$list = $model->ReportjoinView();
?>

<?php
$mess = '';
if (!empty($msg)) {
    switch ($msg) {
        case "1":
            $mess = '批次重新產生QRCode檔案成功!';
            break;
        case "2":
            $mess = '批次取QRCode檔案,檔名是會員編號-條碼成功!';
            break;
        case "3":
            $mess = '刪除所有報到記錄成功!';
            break;
        default:
            $mess = '';
    }
    if (!empty($mess)) {
?>
        <div id="mess">
            <div class="close">X</div>
            <div class="mess_text">
                <h3><?php echo $mess ?></h3>
            </div>
        </div>
<?php
    }
}
?>
<div id="setting_check_in">
    <div>
        <a class="my_button" href="<?php echo "admin.php?page=$page&action=guests" ?>">導出會員</a>
    </div>

    <div>
        <a class="my_button" href="" onclick="myConfirm('您確定產生新的QRCode,舊的會被刪除','qrcode')">批次產生 QRCode </a>
    </div>

     <div>
        <a class="my_button" href="" onclick="myConfirm('您確定產生新的QRCode含姓名,舊的會被刪除','qrcode-has-name')">批次產生 QRCode 含姓名 </a>
    </div>
    
    <hr>
    <div>
        <a class="my_button my_button_warning" href="<?php echo "admin.php?page=$page&action=import" ?>" >導入會員</a> <i>會刪除目前的會員</i>
    </div>

      <div>
        <a class="my_button my_button_warning" href="<?php echo "admin.php?page=$page&action=additional" ?>" >導入補充會員</a>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.close').click(function() {
            jQuery(this).parent('#mess').hide(200);
        });

    });

    function myConfirm(title, action) {
        if (confirm(title)) {
            location.href = "<?php echo "admin.php?page=" . $page . "&action=" ?>" + action;
        } else {
            window.stop();
        }
    }
</script>