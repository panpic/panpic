{include file="login/header.tpl"}
<div class="container">
<!-- Main Container Fluid -->
<div class="container-fluid menu-hidden">
<!-- Content -->
<div id="content">

<div class="container">
<!-- row-application -->
<div class="row row-app">
<!-- col -->
<!-- col-separator.box -->
<div class="col-separator col-unscrollable box">
<!-- col-table -->
<div class="col-table">
	<h4 class="innerAll margin-none border-bottom text-center"><i class="fa fa-lock"></i> Login to your Account</h4>
	<!-- col-table-row -->
	<div class="col-table-row">
		<!-- col-application -->
		<div class="col-app col-unscrollable">
			<!-- col-application -->
			<div class="col-app">
				<div class="login">
					<div class="placeholder text-center"><i class="fa fa-lock"></i>
					</div>
					
					<div class="panel panel-default col-md-4 col-sm-6 col-sm-offset-3 col-md-offset-4">
						<div class="panel-body">
						{if $error neq ''} {include file="error.tpl"} {/if}
							<form role="form" method="post" action="{$base_url_admin}/login/">
								<div class="form-group">
									<label for="exampleInputEmail1">Username</label>
									<input type="text" name="username" id="username" class="form-control" placeholder="Enter username">
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-primary btn-block">Login</button>
								<div class="checkbox">
									<label>
										<input name="remember" type="checkbox" value="1">Remember me
									</label>
								</div>
							</form>
						</div>
					</div>
					
					<!--
					<div class="col-sm-4 col-sm-offset-4 text-center">
						<div class="innerAll">
							<a href="signup.html?lang=en" class="btn btn-info">Create a new account? <i class="fa fa-pencil"></i> </a>
							<div class="separator"></div>
						</div>
					</div>
					-->
					
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- // END col-application -->
		</div>
		<!-- // END col-application.col-unscrollable -->
	</div>
	<!-- // END col-table-row -->
</div>
<!-- // END col-table -->
</div>
<!-- // END col-separator.box -->
</div>
<!-- // END row-application -->

{include file="login/footer.tpl"}