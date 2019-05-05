<div class="login-page">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $title; ?></h3>
                </div>
 
            <div class="panel-body">
  
					<?php 
					$this->load->helper('form');
					$attributes = array('class' => '', 'id' => 'form_password_update');
					echo form_open('user/change-password', $attributes); 
					?>
                        <fieldset>
                            <div class="form-group"  >
                                <input data-validation="required" class="form-control" placeholder="Old Password" name="old_password" id="old_password" type="password" autofocus>
                            </div>
                            <div class="form-group"  >
                                <input data-validation="required" class="form-control" placeholder="New Password" name="new_password" id="new_password" type="password">
                            </div>
                            <div class="form-group"  >
                                <input data-validation="required" class="form-control" placeholder="Confirm Password" name="confirm_password" type="password">
                            </div>
                            <div class="form-group"  >
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Submit" name="login" />
                            </div>

                        </fieldset>
                
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/plugins/jquery-1.11.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/plugins/jquery.validate.min.js')?>"></script>

 <script type="text/javascript">
 
 $(function(){
	
	$('#form_password_update').validate({
		"rules": {
		  "old_password": {
			 "required": true,
		  },
		  "new_password": {
			 "required": true
		  },
		  "confirm_password": {
       "required": true,
       "equalTo": '#new_password'
		  }
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
	
 });
 
</script>