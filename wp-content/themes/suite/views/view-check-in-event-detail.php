<?php
require_once DIR_MODEL . 'model-check-in-report.php';
$model = new Model_Check_In_Report();
$id = getParams('id');
$actionEvent = $model->getActionEventById($id);
$data = $model->ReportJoinViewByID($id);
?>
<div class="check-in-event-title">
    <?php echo $actionEvent['title'] ?>
</div>
<div class="check-in-head">
    <div>
        <a class="button button-primary" href="<?php echo "admin.php?page=check_in_event_page&action=export&id=$id" ?>">導出記錄</a>
    </div>

    <div>
        <div class="check-in-total">
            <?php echo __('總數') . ' : ' . count($data); ?>
        </div>
    </div>
</div>
<div class="check-in-content">
    <div class="check-in-content-row header-style">
        <div></div>
        <div><?php _e('會員編碼'); ?></div>
        <div><?php _e('公司名稱'); ?></div>
        <div><?php _e('Full Name') ?></div>
        <div><?php _e('Phone') ?></div>
        <div><?php _e('日期') ?></div>
        <div><?php _e('時間') ?></div>
    </div>
    <?php foreach ($data as $key => $val) { ?>
        <div class="check-in-content-row">
            <div><?php echo $key + 1 ?></div>
            <div><?php echo $val['stt'] ?></div>
            <div><?php echo $val['company'] ?></div>
            <div><?php echo $val['full_name'] ?></div>
            <div><?php echo $val['phone'] ?></div>
            <div><?php echo $val['date'] ?></div>
            <div><?php echo $val['time'] ?></div>
        </div>
    <?php } ?>
</div>