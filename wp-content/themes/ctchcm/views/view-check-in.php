<?php
require_once(DIR_MODEL.'model-check-in.php');
$data = new Model_Check_In();
$data->prepare_items();
$lbl = '';
$page =  getParams('page');
$linkAdd  = admin_url('admin.php?page=' . $page . '&action=add');  // TAO LINH CHO ADD NEW
$lblAdd    = '新增名單';
if(getParams('msg') == 1){
    $msg = '<div class="updated notice notice-success is-dismissible"><p> 資料調整成功 </p></div>';
}

?>
<style type="text/css">
    .column-title {
        width: 300px;
    }
</style>
 <div class="wrap">
     <h2 style="font-weight: bold">
         <?php echo esc_html__($lbl); ?>
         <a href ="<?php echo esc_url($linkAdd); ?>"  class ="add-new-h2"><?php  echo esc_html__($lblAdd); ?></a>
     </h2>
     <?php echo @$msg; ?>
     <form action ="" method="post" name="<?php echo $page; ?>" id="<?php echo $page; ?>">
         <?php $data->search_box('search', 'search_id') ?>
         <?php  $data->views(); ?>
         <?php $data->display(); ?>
     </form>
 </div>