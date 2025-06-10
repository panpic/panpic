<?php 
$this->load->view('header'); 
$this->load->view('sidebar'); 
$base_url_admin = $this->config->item("base_url_admin");
?>

<div id="content">

    <?php 
        $this->load->view('sidebar_header'); 
        $this->load->view('breadcrumb'); 
    ?>

    <div class="innerLR">

         <?php if($alert != '') { $this->load->view('notes'); } ?>

        <link href="<?php echo $this->config->item("base_tlp_admin");?>/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

        <div class="widget">
            <div class="widget-head">
                <h4 class="heading"><?php echo $this->lable['list_items'];?></h4>
            </div>
            <div class="widget-body innerAll inner-2x">
                <table class="table table-bordered table-condensed" id="dataTables-lang">
                    <thead>
                        <tr>
                            <th><?php echo $this->lable['variable'];?></th>
                            <th><?php echo $this->lable['value_of_variable'];?></th>								
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->lable as $key => $vl): ?>
                        <tr>
                            <td><a href="<?php echo $base_url_admin;?>/language/?id=<?php echo $key;?>&option=edit" title="Chinh sửa"><?php echo $key;?></a></td>
                            <td><input class="form-control" type="text" name="value" value="<?php echo stripslashes($vl);?>" /></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
               </table>
            </div>
        </div><!-- .widget--> 	

    </div>    
</div>

<?php $this->load->view('footer'); ?>

<script src="<?php echo $this->config->item("base_tlp_admin");?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo $this->config->item("base_tlp_admin");?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<script language="javascript">
$(document).ready(function() { 
    $('#dataTables-lang').dataTable();
});
</script>