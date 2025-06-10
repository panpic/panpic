<div class="clearfix"></div>   
<div class="hidden-print">
    <!--id="footer" <div class="copy">&nbsp;</div>-->
</div>
</div><!-- // Main Container Fluid END -->

<script data-id="App.Config">
    {literal}
    var App = {};
    var basePath = '',
            commonPath = base_tpl_admin + '/assets/',
            rootPath = '../',
            DEV = false,
            componentsPath = base_tpl_admin + '/assets/components/';
    var primaryColor = '#3695d5',
            dangerColor = '#b55151',
            successColor = '#609450',
            infoColor = '#4a8bc2',
            warningColor = '#ab7a4b',
            inverseColor = '#45484d';
    var themerPrimaryColor = primaryColor;
    {/literal}
</script>
<script>
var base_url_admin = "{$base_url_admin}"; 
var base_tlp_admin = "{$base_tlp_admin}"; 
var current_control = "{$control}";
var current_method  = "{$action}";
</script>

<script src="{$base_tlp_admin}/assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/plugins/breakpoints/breakpoints.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/plugins/preload/pace/pace.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/plugins/preload/pace/preload.pace.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/core/js/animations.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-switch/assets/lib/js/bootstrap-switch.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-switch/assets/custom/js/bootstrap-switch.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/fuelux-checkbox/fuelux-checkbox.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/modules/admin/modals/assets/js/bootbox.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/modules/admin/modals/assets/js/modals.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/modules/admin/notifications/gritter/assets/lib/js/jquery.gritter.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/modules/admin/notifications/gritter/assets/custom/js/gritter.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/editors/wysihtml5/assets/lib/js/wysihtml5-0.3.0_rc2.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/editors/wysihtml5/assets/lib/js/bootstrap-wysihtml5-0.0.2.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/editors/wysihtml5/assets/custom/wysihtml5.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/wizards/assets/lib/jquery.bootstrap.wizard.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/wizards/assets/custom/js/form-wizards.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/fuelux-radio/fuelux-radio.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/jasny-fileupload/assets/js/bootstrap-fileupload.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/button-states/button-loading/assets/js/button-loading.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>

<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-select/assets/lib/js/bootstrap-select.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-select/assets/custom/js/bootstrap-select.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/select2/assets/lib/js/select2.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/select2/assets/custom/js/select2.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/multiselect/assets/lib/js/jquery.multi-select.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/multiselect/assets/custom/js/multiselect.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>

<script src="{$base_tlp_admin}/assets/components/common/forms/elements/inputmask/assets/lib/jquery.inputmask.bundle.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/inputmask/assets/custom/inputmask.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-datepicker/assets/lib/js/bootstrap-datepicker.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-datepicker/assets/custom/js/bootstrap-datepicker.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-timepicker/assets/lib/js/bootstrap-timepicker.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/bootstrap-timepicker/assets/custom/js/bootstrap-timepicker.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/colorpicker-farbtastic/assets/js/farbtastic.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
<script src="{$base_tlp_admin}/assets/components/common/forms/elements/colorpicker-farbtastic/assets/js/colorpicker-farbtastic.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/core/js/sidebar.main.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/core/js/sidebar.collapse.init.js?v=v1.0.3-rc2"></script>
<script src="{$base_tlp_admin}/assets/components/core/js/core.init.js?v=v1.0.3-rc2"></script>

</body>
</html>