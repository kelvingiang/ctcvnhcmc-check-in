<?php
$id = $_GET['id']??null;
if ($id !== null) {
    include_once HCM_DIR_MODEL . 'vote_model.php';
    $model = new Admin_Vote_Model();
    $item = $model->getItem($id);
}

$action = $_GET['action'];
$title = $action == 'add' ? '新增候選' : '修改-更新';
?>
<style>
    .err {
        color: red;
        font-size: 12px;
        font-style: italic;
    }
</style>
<div style="padding-top: 20px">
    <div style=" margin:  0 30px;">
        <h2 style="color:  #0364c5;  letter-spacing: 5px"><?php echo $title ?></h2>
    </div>
    <form action="" method="post" enctype="multipart/form-data" id="f-vote" name="f-vote">
        <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $item['ID'] ?? null ?>">
        <input type="hidden" id="hid_img" name="hid_img" value="<?php echo $item['img'] ?? null ?>">
        <div class="content" style=" margin-bottom: 70px ">
            <div class="cell-one "><label class="label-admin"> <?php _e('Picture') ?> </label></div>
            <div class="cell-two">
                <?php
                if (empty($item['img'])) {
                    $vote_img = 'no-image.jpg';
                } else {
                    $vote_img = $item['img'];
                }
                ?>
                <div id="show-img" style="background-image: url('<?php echo get_vote_img($vote_img); ?>')"></div>
                <input type="file" id="vote_img" name="vote_img" accept=".png, .jpg, .jpeg, .bmp" />
            </div>
        </div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin">候選類別</label></div>
    <div class="cell-two">
        <select id="sel_kid" name="sel_kid">
            <option value="0">選類別</option>
            <option value="1" <?php echo $item['kid'] ?? null == 1 ? 'selected' : '' ?>>理事</option>
            <option value="2" <?php echo $item['kid'] ?? null == 2 ? 'selected' : '' ?>>監事</option>
        </select>
        <label id="err_kid" class="err"></label>
    </div>
</div>

<div class="content">
    <div class="cell-one ">
        <label class="label-admin">姓名</label>
        <label id="err_name" class="err"></label>
    </div>
    <div class="cell-two">
        <input type="text" id="txt_name" name="txt_name" value="<?php echo $item['name'] ?? null ?>" />
    </div>
</div>
<div class="content">
    <div class="cell-one "><label class="label-admin">公司名稱</label></div>
    <div class="cell-two"><input type="text" id="txt_company" name="txt_company" value="<?php echo $item['company']??null ?>" /></div>
</div>
<div class="content">
    <div class="cell-one "><label class="label-admin">編號</label></div>
    <div class="cell-two">
        <input type="text" id="txt_number" name="txt_number" maxlength="2" value="<?php echo $item['number'] ?? null ?>" />
    </div>
</div>
<div class="content">
    <div class="cell-one "><label class="label-admin">票數</label></div>
    <div class="cell-two"><input type="text" id="txt_vote" name="txt_vote" value="<?php echo $item['vote_total'] ?? null ?>" /></div>
</div>


<div class="content" style="padding-top: 20px; text-align: right; margin-bottom: 20px">
    <div class="cell-one "><label class="label-admin"></label></div>
    <div class="cell-submit ">
        <button type="button" id="submitBtn" class="button button-primary"> 發 佈</button>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#submitBtn').on("click", function() {
            var err = [];
            jQuery('#err_kid').html('');
            jQuery('#err_name').html('');

            if (jQuery("#sel_kid").val() === "0") {
                err[1] = "請選上候選者職稱";
            }
            if (jQuery("#txt_name").val() === '') {
                err[2] = '姓名不能為空';
            }
            if (err.length > 0) {
                jQuery('#err_kid').html(err[1]);
                jQuery('#err_name').html(err[2]);
                // err.splice();
            } else {
                jQuery('#f-vote').submit();
            }
        });
    });



   // show hinh anh truoc khi up len
    jQuery(function() {
        jQuery("#vote_img").on("change", function() {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return;

            if (/^image/.test(files[0].type)) {
                var reader = new FileReader();
                reader.readAsDataURL(files[0]);

                reader.onloadend = function() {
                    jQuery("#show-img").css("background-image", "url(" + this.result + ")");
                };
                console.log(result);
            }
        });
    });
</script>