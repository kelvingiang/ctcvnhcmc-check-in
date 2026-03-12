<?php
require_once ( DIR_MODEL . 'model-check-in-report.php' );
$model = new Model_Check_In_Report();
//$list = $model->ReportView();
$page = getParams('page');

$list = $model->ReportjoinView();
$signUp = $model->RegisterTotal();

?>
<div class="report_head">
   <div>
       <label>登記總數 : <?php echo $signUp['count']; ?></label>
       <label>出席總數 : <?php echo count($list); ?></label> 
   </div> 
   <div>
       <a class="btn my_button" href="<?php echo "admin.php?page=$page&action=export" ?>"> 導出細節</a>
       <a class="btn my_button" href="<?php echo "admin.php?page=$page&action=waiting" ?>">刷卡時間</a>
    </div>
</div>
<div class="report_content">
        <div class="report_list">
            <div class="report_row report_title">
                <div>編號</div>
                <div>姓名</div>
                <div>職稱</div>
                <div>電話</div>
                <div>公司名稱</div>
                <div>時間</div>
                <div>日期</div>
            </div>
            <?php foreach ($list as $key => $val) { ?>
                <div class="report_row">
                    <div> <?php echo $val['stt'] ?></div>
                    <div> <?php echo $val['full_name'] ?></div>  
                    <div> <?php echo $val['position'] ?></div>  
                    <div> <?php echo $val['phone'] ?></div>  
                    <div> <?php echo $val['company'] ?></div>   
                    <div> <?php echo $val['time'] ?> </div>  
                    <div> <?php echo $val['date']?> </div>  
                </div> 
            <?php } ?>
        </div>
    </div>
</div>