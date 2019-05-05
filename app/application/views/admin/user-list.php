 <h3>Users List</h3>
    <br />
    <button class="btn btn-warning" onclick="clear_search('admin/user-list')" style="float:right"><i class="glyphicon glyphicon-remove"></i> Clear Search</button>
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
			<th>Sr. No.</th>
			<th style="width:20%;">Employee Name</th>
			<th style="width:20%;">Employee Address</th>
			<th>Username</th>
			<th>Created At</th>
        </tr>
      </thead>
      <tbody>
		<?php
			if(empty($user_list)){
				echo '<tr><td colspan=6>No Record Found!</td> </tr>';
			}
			else{
				foreach($user_list as $key=>$value){?>
				<tr>
					<td><?php echo $offset+$key+1;?></td>
					<td><?php echo $value->fullname;?></td>
					<td><?php echo $value->address;?></td>
					<td><?php echo $value->username;?></td>
					<td><?php echo date( 'm/d/Y H:i:s', strtotime($value->created_at) );?></td>
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


<script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>

<!-- custom js -->
<script src="<?php echo base_url('assets/js/custom/admin/user_expense.js')?>"></script>