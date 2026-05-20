<?php
require_once(DIR_MODEL . 'model-check-in-event-function.php');
$model = new Model_Check_In_Event_Function();
$event = $model->getActiveItem();
?>
<div id="check_in">
    <div class="check_in_header">
        <img class="logo-space" src="<?php echo get_img('ctcvnhcmc_logo.png') ?>" />
        <div class="header-text">
            <label class="header-label-title">胡志明市台灣商會</label>
            <label class="header-label-event"><?php echo $event['title'] ?></label>
        </div>
    </div>

    <div class="check_in_content">
        <div class="check_from">

            <div class="search-box check-form-input">
                <input type="text" id="txt-barcode" id="txt-barcode" placeholder="請輸入條碼" class="search-input">
                <!-- <button type="submit" id="btn-submit"  class="search-btn">提交</button> -->
            </div>


            <div id="last-check-in"> </div>
            <div class="digiwin_space">
                <img src="<?php echo get_img('digiwin_logo.png'); ?>" /> </br>
                <label>鼎捷軟件維護製作</label>
            </div>
        </div>

        <div class="check_result">
            <div id="waiting-main">
                <h2><?php echo get_option('_waiting_text') ?></h2>
                <h3>胡志明市台灣商會</h3>
            </div>

            <div id="barcode-error">條碼不正確!</div>
            <div id="barcode-not-active">您的帳號還沒啟動!</div>
            <div id="guest-main">
                <div id="info">
                    <div class="name-space">
                        <div id="guest_company"></div>
                    </div>
                    <div class="check-in-success">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path d="M320 576C178.6 576 64 461.4 64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576zM438 209.7C427.3 201.9 412.3 204.3 404.5 215L285.1 379.2L233 327.1C223.6 317.7 208.4 317.7 199.1 327.1C189.8 336.5 189.7 351.7 199.1 361L271.1 433C276.1 438 282.9 440.5 289.9 440C296.9 439.5 303.3 435.9 307.4 430.2L443.3 243.2C451.1 232.5 448.7 217.5 438 209.7z" />
                        </svg> 報到成功!
                    </div>

                    <div class="guest-info">
                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M99.7 235.1C52.8 281.1 52.8 358 99.7 404.9L235.6 540.8C281.6 587.7 358.5 587.7 405.4 540.8L541.3 404.9C588.2 358 588.2 281.1 541.3 235.1L405.4 99.2C358.5 52.3 281.6 52.3 235.6 99.2L99.7 235.1zM260 260.5C292.9 227.4 346.4 227.1 379.5 260C412.6 292.9 412.9 346.4 380 379.5C347.1 412.6 293.6 412.9 260.5 380C227.4 347.1 227.1 293.6 260 260.5z" />
                            </svg>編號</div>
                        <div id="guest_stt"></div>
                    </div>

                    <div class="guest-info">
                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z" />
                            </svg>姓名</div>
                        <div id="guest_name"></div>
                    </div>

                    <div class="guest-info">
                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M503.6 128L136.6 128C114.5 128 96 146.5 96 168.6L96 303.8C96 428.5 195.7 528 320.2 528C444.2 528 544 428.5 544 303.8L544 168.6C544 146.2 526.3 128 503.6 128zM341.6 396.5C329.2 408.3 310.2 407.6 299.2 396.5C185.5 287.6 184.3 291.4 184.3 273.3C184.3 256.4 198.1 242.6 215 242.6C232 242.6 231.1 246.4 320.2 331.9C410.8 245 408.8 242.6 425.7 242.6C442.6 242.6 456.4 256.4 456.4 273.3C456.4 291.1 453.5 289 341.6 396.5z" />
                            </svg>職稱</div>
                        <div id="guest_position"></div>
                    </div>

                    <div class="guest-info">
                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M112 128C85.5 128 64 149.5 64 176C64 191.1 71.1 205.3 83.2 214.4L291.2 370.4C308.3 383.2 331.7 383.2 348.8 370.4L556.8 214.4C568.9 205.3 576 191.1 576 176C576 149.5 554.5 128 528 128L112 128zM64 260L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 260L377.6 408.8C343.5 434.4 296.5 434.4 262.4 408.8L64 260z" />
                            </svg>電郵</div>
                        <div id="guest_email"></div>
                    </div>
                    <div class="guest-info">
                        <div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160C544 124.7 515.3 96 480 96L160 96zM248 192.7C257.8 190 268.1 195.1 272 204.5L292.3 253.2C295.7 261.5 293.4 271 286.4 276.7L264.3 294.7C280.5 330.5 308.8 359.7 343.9 377.1L363.2 353.5C368.9 346.6 378.4 344.2 386.7 347.6L435.4 367.9C444.8 371.8 449.8 382.1 447.2 391.9L446.4 394.7C437.6 427 406.3 454.6 368.2 446.5C280.7 428 211.9 359.1 193.3 271.6C185.2 233.5 212.8 202.2 245.1 193.4L247.9 192.6z" />
                            </svg>電話</div>
                        <div id="guest_phone"></div>
                    </div>


                    <!-- <div class="guest-info">
                        <div>備註 : </div>
                        <div id="guest_note"></div>
                    </div> -->

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
            if (barcode === '') {
                return;
            }
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
                        jQuery('#txt-barcode').val('')
                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    } else if (data.status === 'error') {
                        jQuery('#guest-main, #last-check-in, #barcode-not-active').css('display', 'none');
                        jQuery('#barcode-error').css('display', 'block');
                        jQuery('#txt-barcode').val('')
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