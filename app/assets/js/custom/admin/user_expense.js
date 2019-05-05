
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
 
	function clear_search($uri){
		
		window.location.href = baseUrl + $uri;		
	}
	
    function addExpenseFile()
    {
      save_method = 'add';
      $('#form_addExpense')[0].reset(); // reset form on modals
	  hideFormError();
	  
	  $('#modal_addExpense .modal-title').text('Upload File'); // Set title to Bootstrap modal title
      $('#modal_addExpense').modal('show'); // show bootstrap modal
    
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
