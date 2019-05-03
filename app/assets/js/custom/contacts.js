
	var save_method; //for save method string
	var table;

	$(document).ready( function () {
	/* 	  
		var table = $('#table_contacts').DataTable({
			serverSide: true,
			ajax: {
				url: baseUrl+ '/contacts',
				type: 'POST'
			}
			
		}); */
		
		/* var table = $('#table_contacts').DataTable(); */
 
    // Sort by columns 1 and 2 and redraw
   /*  table
    .order( [[ 1, 'asc' ], [ 2, 'asc' ]] )
    .draw(); */
		
		
		$('select[name="show"]').on('change',function(){
		
			$('#form_search_filter').submit();
		});
		
	}); 
 
	function clear_search(){
		
		window.location.href = baseUrl + "contacts";		
	}
	
    function add_contact()
    {
      save_method = 'add';
      $('#form_addContact')[0].reset(); // reset form on modals
	  hideFormError();
	  
	  $('#modal_addContact .modal-title').text('Create Record'); // Set title to Bootstrap modal title
      $('#modal_addContact').modal('show'); // show bootstrap modal
    
    }
 
    function edit_contact(id)
    {
		save_method = 'update';
		$('#form_addContact')[0].reset(); // reset form on modal
		hideFormError();
		
      //Ajax Load data from ajax
      $.ajax({
        url : baseUrl+"contacts/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
			if('FALSE' == response.status)
			{
				showFormError(response.data.error_message);
				
			}else if('TRUE' == response.status){
				var data = response.data;
				
				$('[name="contact_name"]').val(data.contact_name);
				$('[name="contact_number"]').val(data.contact_number);
				$('[name="contact_note"]').val(data.contact_note);
				$('[name="contact_id"]').val(data.contact_id);
		  
				$('#modal_addContact').modal('show'); // show bootstrap modal
				$('#modal_addContact .modal-title').text('Edit Record'); // Set title to Bootstrap modal title
			
			}
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }
 
 var form = $( "#form_addContact" );
    function save(e)
    {
		e.preventDefault();
		//if(!form.valid()) return;
		
		var url;
		if(save_method == 'add')
		{
			url = $('#form_addContact').attr('action');
		}
		else
		{
			url = baseUrl+"contacts/update";
		}
 
       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_addContact').serialize(),
            dataType: "JSON",
            success: function(response)
            {
				if('FALSE' == response.status)
				{
					showFormError(response.data.error_message);
					
					updateCsrfHash(response.data.csrf.token_hash);
					
				}else if('TRUE' == response.status){
					//if success close modal and reload ajax table
					$('#modal_addContact').modal('hide');
					location.reload();// for reload a page
				}
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }
 
    function delete_contact(id)
    {
        Confirm('Delete Contact', 'Are you sure you want to delete this Id: '+id+'?', 'Yes', 'Cancel', function () {
            $('[name="contact_id"]').val(id);

            // ajax delete data from database
            $.ajax({
                url : baseUrl+"contacts/delete-contact",
                type: "POST",
                data: $('#form_addContact').serialize(),
                dataType: "JSON",
                success: function(response)
                {
                    updateCsrfHash(response.data.csrf.token_hash);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        });

    }
	
	function updateCsrfHash(token_hash){
		$('#form_addContact [name="ci_csrf_token"]').val(token_hash);
	}
	
	function showFormError(error_message){
		$('#form_addContact .error-message').html(error_message);
		$('#form_addContact .error-message').show();
		
		setTimeout(function(){hideFormError()},10*1000);
	}
	
	function hideFormError(){
		$('#form_addContact .error-message').html('');
		$('#form_addContact .error-message').hide();
	}


    function Confirm(title, msg, $true, $false, callback) { /*change*/
        var $content =  "<div class='dialog-ovelay'>" +
            "<div class='dialog'><header>" +
            " <h3> " + title + " </h3> " +
            "<i class='fa fa-close'></i>" +
            "</header>" +
            "<div class='dialog-msg'>" +
            " <p> " + msg + " </p> " +
            "</div>" +
            "<footer>" +
            "<div class='controls'>" +
            " <button class='button button-danger doAction'>" + $true + "</button> " +
            " <button class='button button-default cancelAction'>" + $false + "</button> " +
            "</div>" +
            "</footer>" +
            "</div>" +
            "</div>";
        $('body').prepend($content);
        $('.doAction').click(function () {

            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
            });

            callback();

        });
        $('.cancelAction, .fa-close').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
            });
            return false;
        });

    }
