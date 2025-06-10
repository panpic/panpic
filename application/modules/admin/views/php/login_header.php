<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 "> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 "> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 "> <![endif]-->
<!--[if gt IE 8]> <html class="ie "> <![endif]-->
<!--[if !IE]><!-->
<html class="">
<!-- <![endif]-->
<head>
    <title><?php echo $seo['title'];?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" />
    <!-- 
	**********************************************************
	In development, use the LESS files and the less.js compiler
	instead of the minified CSS loaded by default.
	**********************************************************
	<link rel="stylesheet/less" href="<?php echo $this->config->item("base_tlp_admin");?>/assets/less/admin/module.admin.stylesheet-complete.sidebar_type.collapse.less" />
	-->
    <!--[if lt IE 9]><link rel="stylesheet" href="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/library/bootstrap/css/bootstrap.min.css" /><![endif]-->
    <link rel="stylesheet" href="<?php echo $this->config->item("base_tlp_admin");?>/assets/css/admin/module.admin.stylesheet-complete.sidebar_type.collapse.min.css"
    />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/library/jquery/jquery.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/library/jquery/jquery-migrate.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/library/modernizr/modernizr.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/plugins/less-js/less.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/modules/admin/charts/flot/assets/lib/excanvas.js?v=v1.0.3-rc2"></script>
    <script src="<?php echo $this->config->item("base_tlp_admin");?>/assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script>
	var base_tpl_admin = "<?php echo $this->config->item("base_tlp_admin");?>";
	
    if ( /*@cc_on!@*/ false && document.documentMode === 10)
    {
        document.documentElement.className += ' ie ie10';
    }
	
    </script>
</head>
<body class=" loginWrapper">