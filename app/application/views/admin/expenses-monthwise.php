 <h3>Expenses Monthwise</h3>
    <br />
		<div class="row filters">
			<form action="" id="form_search_filter">
				<div class="col-sm-6">
				<div class="dataTables_length" id="table_contacts_length"><label>Show <select name="show" class="form-control input-sm"><option value="10">10</option><option value="25" <?php echo ((isset($limit) && $limit==25)? 'selected':'');?>>25</option><option value="50" <?php echo ((isset($limit) && $limit==50)? 'selected':'');?>>50</option><option value="100" <?php echo ((isset($limit) && $limit==100)? 'selected':'');?>>100</option></select> entries</label></div>
				</div>
				<div class="col-sm-6">
				<div class="dataTables_filter">
				<label>From:</label>
				<select name="from_month">
				<option value=''>Month</option>
				<?php
					for($month=1;$month<=12;$month++){
						$selected = (isset($_GET['from_month']) && $month == $_GET['from_month']) ? 'selected' : '';
						echo "<option value='$month' $selected>$month</option>";
					}
				?>
				</select>
				<select name="from_year">
				<option value=''>Year</option>
				<?php
					for($year=date('Y');$year>=date('Y')-30;$year--){
						$selected = (isset($_GET['from_year']) && $year == $_GET['from_year']) ? 'selected' : '';
						echo "<option value='$year' $selected>$year</option>";
					}
				?>
				</select>
				<label>To:</label>
				<select name="to_month">
				<option value=''>Month</option>
				<?php
					for($month=1;$month<=12;$month++){
						$selected = (isset($_GET['to_month']) && $month == $_GET['to_month']) ? 'selected' : '';
						echo "<option value='$month' $selected>$month</option>";
					}
				?>
				</select>
				<select name="to_year">
				<option value=''>Year</option>
				<?php
					for($year=date('Y');$year>=date('Y')-30;$year--){
						$selected = (isset($_GET['to_year']) && $year == $_GET['to_year']) ? 'selected' : '';
						echo "<option value='$year' $selected>$year</option>";
					}
				?>
				</select>
				<button type="submit" class="btn btn-info" ><i class="glyphicon glyphicon-search"></i></button>
				<button type="button" class="btn btn-warning" onclick="clear_search('admin/monthwise-expense')" style="float:right"><i class="glyphicon glyphicon-remove"></i> Clear Filter</button>
				</div>
				</div>
			</form>
		</div>
 	<table id="table_contacts" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
			<th>Sr. No.</th>
			<th>Date</th>
			<th >Pre Tax Amount</th>
			<th>Tax Amount</th>
          	<th>Total</th>
        </tr>
      </thead>
      <tbody>
		<?php
			if(empty($expenses)){
				echo '<tr><td colspan=5>No Record Found!</td> </tr>';
			}
			else{
				foreach($expenses as $key=>$value){?>
				<tr>
					<td><?php echo $offset+$key+1;?></td>
					<td><?php echo date( 'm/Y', strtotime($value->expense_year_month) );?></td>
					<td><?php echo $value->pre_tax_amount;?></td>
					<td><?php echo $value->tax_amount;?></td>
					<td><?php echo ($value->pre_tax_amount + $value->tax_amount);?></td>
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

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_addExpense" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Upload File</h3>
      </div>
	  
	  	<?php 
			$this->load->helper('form');
			$attributes = array('class' => 'form-horizontal', 'id' => 'form_addExpense');
			echo form_open_multipart('admin/upload-expense-file', $attributes); 
		?>
		
		<div class="modal-body form">
		  
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Attach File</label>
              <div class="col-md-9">
                <input name="expense_file" data-validation="required"  class="form-control" type="file" required>
              </div>
            </div>
 
          </div>
       
        </div>
		<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Save</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		</div>
		<?php echo form_close(); ?>
		  
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

<script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>

<script src="//cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>

<!-- custom js -->
<script src="<?php echo base_url('assets/js/custom/admin/user_expense.js')?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/jquery.form.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/validate.js');?>"></script>
 
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/additional-methods.min.js');?>"></script>