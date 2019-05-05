<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css')?>" media="screen" title="no title">
	
	<style>
	.heading_top h1{display:inline-block}
	.heading_top a{float:right; margin:26px 0;}

	
	</style>
  </head>
  <body>
  		<div class="container">
  			<div class="heading_top">
			    <div><h2>Welcome!</h2> <?php echo $this->session->userdata('user_data')['fullname']; ?> </div>
				<a href="<?php echo site_url('user/logout');?>" class="btn btn-success"><i class="glyphicon glyphicon-log-out"></i> Logout </a>
			</div>
			<?php 
      if ($this->session->userdata('user_data') && 'ADMIN' == $this->session->userdata('user_data')['user_type'])
      {
          $this->load->view('admin/left-nav');
      }else{
         $this->load->view('user/left-nav');
      }

      ?>
			<div class="content-main">

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
				{content}
			</div>

			<div class="clear"></div>
	        <!-- footer content -->
	        <?php $this->load->view('common/footer');?>
	        <!-- /footer content -->

  		</div>	

  		<script type="text/javascript">
  			var baseUrl = '<?php echo base_url(); ?>';
		</script>

  	</body>
</html>