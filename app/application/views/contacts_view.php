<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phonebook::Contacts</title>
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
    <h1>Welcome to Phonebook App</h1>
	<a href="<?php echo site_url('user/logout');?>" class="btn btn-success"><i class="glyphicon glyphicon-log-out"></i> Logout </a>
	</div>
	
	<div class="content-main">
    <h3>Contacts</h3>
    <br />
    <button class="btn btn-success" onclick="add_contact()"><i class="glyphicon glyphicon-plus"></i> Add New Record</button>
    <button class="btn btn-warning" onclick="clear_search()" style="float:right"><i class="glyphicon glyphicon-remove"></i> Clear Search</button>
    <br />
    <br />
	
	<div class="row">
	<form action="" id="form_search_filter">
	<div class="col-sm-6">
	<div class="dataTables_length" id="table_contacts_length"><label>Show <select name="show" class="form-control input-sm"><option value="10">10</option><option value="25" <?php echo ((isset($limit) && $limit==25)? 'selected':'');?>>25</option><option value="50" <?php echo ((isset($limit) && $limit==50)? 'selected':'');?>>50</option><option value="100" <?php echo ((isset($limit) && $limit==100)? 'selected':'');?>>100</option></select> entries</label></div>
	</div>
	
	<div class="col-sm-6">
	
	<div id="table_contacts_filter" class="dataTables_filter">
	<label>Search:<input name="query" type="text" class="form-control input-sm" value="<?php echo (isset($query)?$query:'');?>" />
	<button type="submit" class="btn btn-info" ><i class="glyphicon glyphicon-search"></i></button></label></div>
		
	</div>
	
	</form>
	
	</div>
	
	
	
    <table id="table_contacts" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
			<th>ID</th>
			<th>Name</th>
			<th style="width:20%;">Phone Number</th>
			<th style="width:20%;">Date Of Adding</th>
			<th>Additional Notes</th>
          <th style="width:125px;">Actions</th>
        </tr>
      </thead>
      <tbody>
		<?php
			if(empty($contacts)){
				echo '<tr><td colspan=6>No Record Found!</td> </tr>';
			}
			else{
				foreach($contacts as $contact){?>
				<tr>
					<td><?php echo $contact->contact_id;?></td>
					<td><?php echo $contact->contact_name;?></td>
					<td><?php echo $contact->contact_number;?></td>
					<td><?php echo date('Y-m-d', strtotime($contact->created_at));?></td>
					<td><?php echo $contact->contact_note;?></td>
					<td>
						<button class="btn btn-info" onclick="edit_contact(<?php echo $contact->contact_id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
						<button class="btn btn-danger" onclick="delete_contact(<?php echo $contact->contact_id;?>)"><i class="glyphicon glyphicon-remove"></i></button>
					</td>
				</tr>
		<?php }
			}?>
      </tbody>
      
    </table>
	<!-- START: Pagination  -->
	<div class="col-sm-12">
	<div class="dataTables_paginate paging_simple_numbers">
	
	<?php echo $this->pagination->create_links(); ?>
	
	</div></div> <!-- END: Pagination  -->
	 
 </div>
  </div>
 
  <script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
 
  <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>

  <!-- custom js -->
  <script src="<?php echo base_url('assets/js/custom/contacts.js')?>"></script>

	
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_addContact" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Create Record</h3>
      </div>
	  
	  	<?php 
			$this->load->helper('form');
			$attributes = array('class' => 'form-horizontal', 'id' => 'form_addContact');
			echo form_open('contacts/add', $attributes); 
		?>
		
		<div class="modal-body form">
			
          <input type="hidden" value="" name="contact_id"/>
		  <div class="alert alert-danger error-message"></div>
		  
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Name</label>
              <div class="col-md-9">
                <input name="contact_name" data-validation="required" placeholder="Name" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Phone Number</label>
              <div class="col-md-9">
                <input name="contact_number" data-validation="required" placeholder="Phone Number" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Additional Notes</label>
              <div class="col-md-9">
					<input name="contact_note" placeholder="Additional Notes" class="form-control" type="text">
              </div>
            </div>
 
          </div>
       
        </div>
		<div class="modal-footer">
		<button type="submit" id="btnSave" onclick="save(event);" class="btn btn-primary">Save</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		</div>
		<?php echo form_close(); ?>
		  
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
 <script>
 
  var baseUrl = '<?php echo site_url().'/'; ?>';
  
</script>


 <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/jquery.form.js');?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/validate.js');?>"></script>
 
  <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/additional-methods.min.js');?>"></script>

 
  </body>
</html>