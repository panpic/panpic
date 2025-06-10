<?php $this->load->view('header'); ?>
<?php $this->load->view('sidebar'); ?>

<div id="content">

    <?php $this->load->view('sidebar_header'); ?>
    <?php $this->load->view('breadcrumb'); ?>
    
    <div class="innerLR">
        
        
        <form class="form-horizontal margin-none" id="frm_data" name="frm_data" method="post" action="<?php echo $this->config->item("base_url_admin");?>/language/add/" accept-charset="utf-8">
        <input type="hidden" name="option" id="option" value="<?php echo $data['option'];?>" />
            
            
            <!-- Widget -->
            <div class="widget">
                <!-- Widget heading -->
                <div class="widget-head">
                    <h4 class="heading"><?php echo $task;?></h4>
                </div>
                <!-- // Widget heading END -->
                <div class="widget-body innerAll inner-2x">
                    <!-- Row -->
                    <div class="row innerLR">
                        <!-- Column -->
                        <div class="col-md-8">
                         
                            <?php 
                            if($alert != '') {
                                $this->load->view('notes');
                            }
                            ?>				
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="primary"><?php echo $this->lable['variable'];?></label>
                                <div class="col-md-8">
                                    <input type="text" name="data[name]" class="form-control" value="<?php echo $data['name'];?>" <?php if ($data['name'] != '') { echo 'readonly="readonly"'; } ?> style="width:300px;" maxlength="80" />
                                    <p class="help-block"><?php echo form_error('name'); ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="lang_value"><?php echo $this->lable['value_of_variable'];?></label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="data[value]" rows="3"><?php echo $data['value'];?></textarea>
                                    <p class="help-block"><?php echo form_error('value'); ?></p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-8">
                                    <div class="form-actions">
                                        <button type="submit" id="btLang" class="btn btn-primary"><i class="fa fa-check-circle"></i> <?php if ($data['option'] == 'edit') {  echo 'Cập nhật'; } else { echo 'Lưu'; } ?></button>
                                    </div>									
                                </div>
                            </div>                           
                            
                        </div>
                        <!-- // Column END -->
                    </div>
                    <!-- // Row END -->
                    
                </div>
                <div class="separator"></div>                    
            </div>
        </div>
        <!-- // Widget END -->
    </form>
    
</div>    
</div>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('script_validator'); ?>
