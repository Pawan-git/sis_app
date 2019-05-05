<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" media="screen" title="no title">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css')?>" media="screen" title="no title">
      
  </head>
  <body>
 
    <div class="container login-page">
    <div class="row top200">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $title; ?></h3>
                </div>
                <?php
                  $success_msg= $this->session->flashdata('success_msg');
                  $error_msg= $this->session->flashdata('error_msg');
 
                  if($success_msg){
                    ?>
                    <div class="alert alert-success">
                      <?php echo $success_msg; ?>
                    </div>
                  <?php
                  }elseif($error_msg){
                    ?>
                    <div class="alert alert-danger">
                      <?php echo $error_msg; ?>
                    </div>
                    <?php
                  }
                  ?>
 
                <div class="panel-body">
                   
					<?php 
					$this->load->helper('form');
					$attributes = array('class' => '', 'id' => 'formLogin');
					echo form_open('user/login', $attributes); 
					?>
                        <fieldset>
                            <div class="form-group"  >
                                <input data-validation="required" class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input data-validation="required" class="form-control" placeholder="Password" name="user_password" type="password" value="">
                            </div>

                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login" name="login" />
 
                        </fieldset>
                   
                <!--<center><b>Not registered ?</b> <br></b><a href="<?php echo base_url('user/signup'); ?>">Register here</a></center>-->
 
                </div>
            </div>
        </div>
    </div>
</div>
 
<script src="<?php echo base_url('assets/js/plugins/jquery-1.11.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/plugins/jquery.validate.min.js')?>"></script>

 <script type="text/javascript">
 
 $(function(){
	
	$('#formLogin').validate({
		"rules": {
		  "username": {
			 "required": true,
		  },
		  
		  "user_password": {
			 "required": true
		  }
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
	
 });
 

</script>
 
  </body>
</html>