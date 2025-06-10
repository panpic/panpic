<script src="{$base_tlp_admin}/assets/components/modules/admin/modals/assets/js/modals.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/modules/admin/notifications/gritter/assets/lib/js/jquery.gritter.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/modules/admin/notifications/gritter/assets/custom/js/gritter.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>

<div id="modal-confirm-delete" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myDangerModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
    <div class="modal-header" style="background-color:#cc3a3a;color:#fff;background-image:none;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title" id="dangerModalLabel">{$lable.alert}</h4>
    </div>
    <div class="modal-body" id="content-confirm">
    	{$lable.are_you_sure_delete}
    </div>
    <div class="modal-footer">
        <a href="#" id="confirm-footer" class="btn btn-default" data-dismiss="modal">{$lable.btn_delete}</a>
    </div>
</div>
</div>
</div>