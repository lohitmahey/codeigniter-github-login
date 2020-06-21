<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" action="<?php echo site_url('user/GET_gitlogin'); ?>">
					<span class="login100-form-title p-b-33">
						Account Login 
					</span>
                    
<?php
                    if( isset( $login_error ) ) {
?>
                        <p class="err-msg-p"><?php echo $login_error ?></p>
<?php
                    }
?>
					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn">
							Sign in with GitHub
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>