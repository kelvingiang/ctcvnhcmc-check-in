<?php
require_once(DIR_MODEL . 'model-check-in-event-function.php');
$model = new Model_Check_In_Event_Function();
$event = $model->getActiveItem();
?>
<div id="check_in">
    <div class="check_in_header">
        <img class="logo-space" src="<?php echo get_img('ctcvnhcmc_logo.png') ?>" />
        <div>
            <h1>胡志明市台灣商會</h1>
            <h2><?php echo $event['title'] ?></h2>
        </div>
    </div>

    <div class="check_in_content">
        <div class="check_from">

            <div class="check-form-input">
                <input type="text" id="txt-barcode" />
                <button id="btn-submit" class="btn-submit-barcode"> 提交 </button>
            </div>
            <div id="last-check-in"> </div>
            <div class="digiwin_space">
                <img src="<?php echo get_img('digiwin_logo.png'); ?>" /> </br>
                <label>鼎捷軟件維護製作</label>
            </div>
        </div>

        <div class="check_result">
            <div id="waiting-main">
                <h3><?php echo get_option('_waiting_text') ?>開始報到</h3>
            </div>
            <div id="barcode-error">條碼不正確!</div>
            <div id="barcode-not-active">會員還沒啟動!</div>
            <div id="guest-main">
                <div id="info">
                    <div class="name-space">
                        <div id="guest_company"></div>
                    </div>
                    <div class="guest-info">
                        <div>編號 : </div>
                        <div id="guest_stt"></div>
                    </div>

                    <div class="guest-info">
                        <div>姓名 : </div>
                        <div id="guest_name"></div>
                    </div>

                    <div class="guest-info">
                        <div>職稱 : </div>
                        <div id="guest_position"></div>
                    </div>

                    <div class="guest-info">
                        <div>電郵 : </div>
                        <div id="guest_email"></div>
                    </div>
                    <div class="guest-info">
                        <div>電話 : </div>
                        <div id="guest_phone"></div>
                    </div>
                    <div class="guest-info">
                        <div>備註 : </div>
                        <div id="guest_note"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="my-waiting">
    <img src="<?php echo get_img('loading_pr2.gif') ?>" />
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#txt-barcode").focus();

        jQuery('#btn-submit').click(function(e) {
            submitAction()
            e.preventDefault();
        });

        jQuery('#txt-barcode').keydown(function(e) {
            if (e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault(); // 避免表單自動提交
                submitAction();
            }
        });

        function submitAction() {
            var barcode = jQuery('#txt-barcode').val().trim();
            var eventID = '<?php echo $event['ID'] ?>';
            jQuery('.my-waiting').css('display', 'block');
            jQuery('#waiting-main').css('display', 'none');
            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/updata-checkin.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post',
                data: {
                    barcode: barcode,
                    eventID: eventID
                },
                dataType: 'json',
                success: function(data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'done') {
                        jQuery("#txt-barcode").val('');
                        jQuery('#barcode-error, #barcode-not-active').css('display', 'none');
                        jQuery('#guest-main, #last-check-in').css('display', 'block');
                        jQuery('#last-check-in').children().remove();
                        if (data.info.TotalTimes != 0) {
                            jQuery('#last-check-in').append("<h5>次數 : " + data.info.TotalTimes + " 次, 時間 ： " + data.info.LastCheckIn + " </h5>");
                        }
                        jQuery('#guest_name').text(data.info.FullName);
                        jQuery('#guest_stt').text(data.info.MemberCode);
                        jQuery('#guest_position').text(data.info.Position);
                        jQuery('#guest_company').text(data.info.Company);
                        jQuery('#guest_email').text(data.info.Email);
                        jQuery('#guest_phone').text(data.info.Phone);
                        jQuery('#guest_note').text(data.info.Note);
                        jQuery('#guest-pic').remove();
                        jQuery('#guest-pictrue').append(data.info.Img);
                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);

                    } else if (data.status === 'not') {
                        jQuery('#guest-main, #last-check-in, #barcode-error').css('display', 'none');
                        jQuery('#barcode-not-active').css('display', 'block');
                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    } else if (data.status === 'error') {
                        jQuery('#guest-main, #last-check-in, #barcode-not-active').css('display', 'none');
                        jQuery('#barcode-error').css('display', 'block');
                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.reponseText);
                }
            });
        }
    });
</script>