<?php
$id = trim(getParams('id'));
$sttError   = "";
$stt = '';
$fullName = '';
$company = '';
$position = '';
$email = '';
$phone = '';
$note = '';

if ($id !== '' && $id !== null && $id !== false) {
    require_once(DIR_MODEL . 'model-check-in-function.php');
    $model = new Model_Check_In_Function();
    $data = $model->get_item(getParams());
}

$getAction = getParams('action');
?>
<?php
if (getParams('msg') == 3) {
    $arrPost = explode("~", getParams('txt'));
    $sttError   = "會員編號已存在";
    $stt        = $arrPost[0];
    $fullName   = $arrPost[1];
    $company    = $arrPost['2'];
    $position   = $arrPost['3'];
    $email      = $arrPost['4'];
    $phone      = $arrPost['5'];
    $note       = $arrPost['6'];
} else {
    $sttError   = "";
    $stt      = $data['stt'] ?? null;
    $fullName = $data['full_name'] ?? null;
    $company  = $data['company'] ?? null;
    $position = $data['position'] ?? null;
    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $note = $data['note'] ?? null;
}
?>
<div>

</div>


<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests">
    <div class="form-row" style=" height: 10px; padding-top: 50px">
        <div class="cell-one "><label class="label-admin"> <?php // _e('Picture'); 
                                                            ?> </label></div>
        <div class="cell-two">
            <input type='hidden' id='hidden_barcode' name='hidden_barcode' value='<?php echo $data['barcode'] ?? null; ?>' />
            <input type='hidden' id='hidden_ID' name='hidden_ID' value='<?php echo $data['ID'] ?? null; ?>' />
            <input type='hidden' id='hidden_img' name='hidden_img' value='<?php echo $data['img'] ?? null; ?>' />
        </div>
    </div>

    <?php if ($getAction != 'add') { ?>
        <div class="form-row">
            <div class="form-row-columns">
                <div class="column">
                    <div class="cell-text"> <?php _e('Barcode'); ?> </div>
                    <div class="cell-input">
                        <?php echo $data['barcode']; ?>
                    </div>
                </div>
                <div class="column">
                    <div class="cell-text"> </div>
                    <div class="cell-input">
                        <a href="<?php echo get_barcode_img($data['barcode']); ?>" download="<?php echo $data['stt'] . '-' . $data['barcode'] . '.png' ?>">
                            <img id="img_barcode" name="img_barcode" src='<?php echo get_barcode_img($data['barcode']); ?>'>
                            按下載QRCode檔案
                        </a>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="form-row">
        <div class="form-row-columns">

            <div class="column">
                <div class="cell-text">
                    會員編號 <i id="error-stt" class="error"></i>
                </div>
                <?php if ($getAction == 'add') { ?>
                    <div class="cell-input">
                        <input type="text" id="txt_stt" name="txt_stt"
                            class="type-number" maxlength="4" required />
                    </div>
                <?php } else { ?>
                    <label style="font-weight: bold;"><?php echo $stt ?></label>
                <?php } ?>
            </div>

            <div class="column">
                <div class="cell-text">姓名</div>
                <div class="cell-input">
                    <input type="text" 
                           id="txt_fullname" 
                           name="txt_fullname" 
                           required 
                           value="<?php echo $fullName ?>" />
                </div>

            </div>

            <div class="column">
                <div class="cell-text">職稱</div>
                <div class="cell-input">
                    <input type="text" 
                           id="txt_position" 
                           name="txt_position" 
                           value="<?php echo $position ?>" />
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-row-columns">
            <div class="column">
                <div class="cell-text">公司名稱</div>
                <div class="cell-input">
                    <input type="text" 
                           id="txt_company" 
                           name="txt_company" 
                           value='<?php echo $company ?>' />
                </div>
            </div>

            <div class="column">
                <div class="cell-text">E-mail <i class="error" id="error_email"></i></div>
                <div class="cell-input">
                    <input type="text" 
                           id="con_email" 
                           name="txt_email" 
                           class='type_email' 
                           required value='<?php echo $email ?>' />
                </div>
            </div>

            <div class="column">
                <div class="cell-text "><?php _e('Phone'); ?></div>
                <div class="cell-input">
                    <input type="text" 
                           id="txt_phone"
                           name="txt_phone" 
                           required 
                           class='type_phone_more' 
                           value='<?php echo $phone; ?>' />
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-row-columns">
            <div class="column">
                <div class="cell-text"><?php _e('Note'); ?> </label></div>
                <div class="cell-input">
                    <textarea id="txt_note" name="txt_note" style="width: 97%;" rows="6"><?php echo $note ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row-button">
        <div class="cell-button">
            <input type="submit" name="btn-submit" id="btn-submit" class="btn my_button" value="發 表">
        </div>
    </div>
</form>

<script type="text/javascript">
    jQuery(document).ready(function() {
        // kiem tra so serial co ton tai chua =====
        jQuery('#txt_stt').blur(function() {
            var serial = jQuery(this).val();
            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/check-serial.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post',
                data: {
                    serial: serial
                },
                dataType: 'json',
                success: function(data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'done') {
                        jQuery('#error-stt').html('');
                        jQuery('#btn-submit').prop('disabled', false);
                    } else if (data.status === 'has') {
                        jQuery('#error-stt').html('這會員編號已存在！');
                        jQuery('#btn-submit').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.reponseText);
                    //console.log(data.status);
                }
            });
            e.preventDefault();
        });
    });
  
</script>