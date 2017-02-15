<body>
<div class="venue-ordered-cstmr float-100">
    	<div class="page-container-booking">
            <div class="float-100 cstmr-booking-table">
                <form>
                    <label for="selecting-table">Select Table</label>
                    <select id="table_select">
                      <option value="table-no">--- Select Table ---</option>
                      <option value="G1 Normal Table">G1 Normal Table</option>
                      <option value="G2 Challenge Table">G2 Challenge Table</option>
                      <option value="Slap Cup / Flip Cup">Slap Cup / Flip Cup</option>
                      <option value="VIP Table">VIP Table</option>
                    </select>
                    <label for="cstmr-name">Name</label>
                    <input type="text" name="cstmr" id="cstmr-name" >
                    <label for="table-no">Table number</label>
                    <input type="text" name="table" id="table-no">
                    <input type="button" name="table" id="add-table" value="Add">      
                </form>
            </div>    
            <div class="float-100 cstmr-queue-block">
                    	
            </div>
        </div>
    </div>
    
     <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">EDIT PLAYER</h4>
        </div>
        <div class="modal-body">
		<div style="margin-left:20%">
			EDIT NAME
          <input type="text" id="edit_name" value=""> 
          <br>
          EDIT  NUMB
          <input type="text" id="edit_number" value=""> 
          <input type="hidden" id="edit_id" value="">
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default edit_done" data-dismiss="modal">edit</button>
        </div>
      </div>
    </div>
  </div>
    <script>
	 jQuery(document).ready(function(){ 
        jQuery('#add-table').click(function(){
	    var table = $('#table_select option:selected').val();
	    if(table == "table-no"){
			sweetAlert("Oops...", "SELECT TABLE !", "error");
			}
        var user_name = $('#cstmr-name').val();
        var table_no = $('#table-no').val();
         if (!(table_no)){
			 sweetAlert("Oops...", "SELECT TABLE NUMBER!", "error");
			 }
		 if (!(user_name)){
			 sweetAlert("Oops...", "ENTER NAME!", "error");
			 }
		 if (!(table)){
			 sweetAlert("Oops...", "SELECT TABLE !", "error");
			 }	 	 
            if((table) && (user_name) && (table_no) && (table != 'table-no')){
			$.ajax({
         type: "POST",
         url: "index.php/admin/ajax_data_submit_admin", 
         data: {table_no:table_no ,user_name:user_name,table:table },
          dataType: 'json',
                   success: function (data) {
					   $('.cstmr-queue-block').html('');  
					var htmlText = ' ';

            for ( var key in data ) {
                htmlText += ' <h1>'+ data[key].player_name +'</h1> ' ;
                htmlText += ' <input type="button"  class="option-button up" value = "up" data-up = " ' + data[key].id + ' "> ' ;
                htmlText += ' <input type="button"  class="option-button down" value = "down" data-down = " ' + data[key].id + ' "> ' ;
                htmlText += ' <input type="button"  class="option-button edit btn btn-info btn-lg" value = "edit" data-toggle="modal" data-target="#myModal" data-name = " ' + data[key].player_name + ' " data-seatno = " ' + data[key].seat_no + ' " data-id = " ' + data[key].id + ' " > ';
                htmlText += ' <input type="button"  class="option-button cancel" value = "cancel" data-cancel = " ' + data[key].id + ' ">';
                
            }

            $('.cstmr-queue-block').append(htmlText);
		}
          });
        }
   });
   });
    </script>
    <script>
         $(document).ready(function(){
	       	$('#table_select').on('change',function(){
				 var table = $('#table_select option:selected').val();
				 
				   $.ajax({
                   type: "POST",
                   url: "index.php/admin/ajax_get_table_selected_list", 
                   data: {table:table },
                   dataType: 'json',
                   success: function (data) {
					 $('.cstmr-queue-block').html('');   
                    var htmlText = '';

            for ( var key in data ) {
                htmlText += '<h1>'+ data[key].player_name +'</h1>';
                htmlText += ' <input type="button"  class="option-button up" value = "up" data-up = " ' + data[key].id + ' ">';
                htmlText += ' <input type="button"  class="option-button down" value = "down" data-down = " ' + data[key].id + ' "> ';
                htmlText += ' <input type="button"  class="option-button edit btn btn-info btn-lg" value = "edit" data-toggle="modal" data-target="#myModal" data-name = " ' + data[key].player_name + ' " data-seatno = " ' + data[key].seat_no + ' " data-id = " ' + data[key].id + ' " > ';
                htmlText += ' <input type="button"  class="option-button cancel" value = "cancel" data-cancel = " ' + data[key].id + ' ">';
                
            }

            $('.cstmr-queue-block').append(htmlText);
            }
          });	
				});
	     	});
    </script>
    <script>
		$(document).ready(function(){ 
        $(document).on('click','.up',function(){
			var up_id = $(this).data("up");
			$.ajax({
         type: "POST",
         url: "index.php/admin/ajax_data_up_position", 
         data: {id:up_id},
           dataType: 'json',
                   success: function (data) {
					   
					 $('.cstmr-queue-block').html(' ');   
                    var htmlText = '';
            for ( var key in data ) {
                htmlText += ' <h1>'+ data[key].player_name +'</h1>';
                htmlText += ' <input type="button"  class="option-button up" value = "up" data-up = " ' + data[key].id + ' ">';
                htmlText += ' <input type="button"  class="option-button down" value = "down" data-down = " ' + data[key].id + ' "> ';
                htmlText += ' <input type="button"  class="option-button edit btn btn-info btn-lg" value = "edit" data-toggle="modal" data-target="#myModal" data-name = " ' + data[key].player_name + ' " data-seatno = " ' + data[key].seat_no + ' " data-id = " ' + data[key].id + ' " > ';
                htmlText += ' <input type="button"  class="option-button cancel" value = "cancel" data-cancel = " ' + data[key].id + ' ">';
                
            }

            $('.cstmr-queue-block').append(htmlText);
            }
         });
	     });
	     });		
	</script>	
    <script>
		$(document).ready(function(){ 
        $(document).on('click','.down',function(){
		var down_id = $(this).data("down");
	     $.ajax({
         type: "POST",
         url: "index.php/admin/ajax_data_down_position", 
         data: {id:down_id},
             dataType: 'json',
                   success: function (data) {
					 $('.cstmr-queue-block').html(' ');   
                    var htmlText = '';

            for ( var key in data ) {
                htmlText += ' <h1>'+ data[key].player_name +'</h1>';
                htmlText += ' <input type="button"  class="option-button up" value = "up" data-up = " ' + data[key].id + ' ">';
                htmlText += ' <input type="button"  class="option-button down" value = "down" data-down = " ' + data[key].id + ' "> ';
                htmlText += ' <input type="button"  class="option-button edit btn btn-info btn-lg" value = "edit" data-toggle="modal" data-target="#myModal" data-name = " ' + data[key].player_name + ' " data-seatno = " ' + data[key].seat_no + ' " data-id = " ' + data[key].id + ' " > ';
                htmlText += ' <input type="button"  class="option-button cancel" value = "cancel" data-cancel = " ' + data[key].id + ' ">';
                
            }

            $('.cstmr-queue-block').append(htmlText);
            }
         });
	     });
	     });
	</script>
	<script>
		$(document).ready(function(){ 
        $(document).on('click','.edit', function(){
		var name = $(this).data("name");
		var seat_no = $(this).data("seatno");
		var edit_id = $(this).data("id");
		$('#edit_name').val(name);
	    $('#edit_number').val(seat_no); 
	    $('#edit_id').val(edit_id);
	     });
	     });
	</script>
	<script>
		$(document).ready(function(){ 
        $(document).on('click','.cancel', function(){
			var cancel_id = $(this).data("cancel");
	     swal({
  title: "Are you sure?",
  text: "You will not be able to recover this record!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, delete it!",
  closeOnConfirm: false
},
function(){
		     $.ajax({
         type: "POST",
         url: "index.php/admin/ajax_data_cancel", 
         data: {id:cancel_id},
             dataType: 'json',
                   success: function (data) {
					 $('.cstmr-queue-block').html(' ');   
                    var htmlText = '';

           for ( var key in data ) {
                htmlText += ' <h1>'+ data[key].player_name +'</h1>';
                htmlText += ' <input type="button"  class="option-button up" value = "up" data-up = " ' + data[key].id + ' ">';
                htmlText += ' <input type="button"  class="option-button down" value = "down" data-down = " ' + data[key].id + ' "> ';
                htmlText += ' <input type="button"  class="option-button edit btn btn-info btn-lg" value = "edit" data-toggle="modal" data-target="#myModal" data-name = " ' + data[key].player_name + ' " data-seatno = " ' + data[key].seat_no + ' " data-id = " ' + data[key].id + ' " > ';
                htmlText += ' <input type="button"  class="option-button cancel" value = "cancel" data-cancel = " ' + data[key].id + ' ">';
                
            }
             swal("Deleted!", "Player has been removed", "success");
            $('.cstmr-queue-block').append(htmlText);
            }
         });
	
         });
	     });
	     });
	</script>
	<script>
	$(document).ready(function(){
		$(document).on('click','.edit_done', function(){
		var name = $('#edit_name').val();
	    var seat_no = $('#edit_number').val();
	    var edit_id = $('#edit_id').val(); 
		     $.ajax({
         type: "POST",
         url: "index.php/admin/ajax_data_edit", 
         data: {id:edit_id,seat_no:seat_no,name:name},
             dataType: 'json',
                   success: function (data) {
					 $('.cstmr-queue-block').html(' ');   
                    var htmlText = '';

           for ( var key in data ) {
                htmlText += ' <h1>'+ data[key].player_name +'</h1>';
                htmlText += ' <input type="button"  class="option-button up" value = "up" data-up = " ' + data[key].id + ' ">';
                htmlText += ' <input type="button"  class="option-button down" value = "down" data-down = " ' + data[key].id + ' "> ';
                htmlText += ' <input type="button"  class="option-button edit btn btn-info btn-lg" value = "edit" data-toggle="modal" data-target="#myModal" data-name = " ' + data[key].player_name + ' " data-seatno = " ' + data[key].seat_no + ' " data-id = " ' + data[key].id + ' " > ';
                htmlText += ' <input type="button"  class="option-button cancel" value = "cancel" data-cancel = " ' + data[key].id + ' ">';
                
            }
            $('.cstmr-queue-block').append(htmlText);
            }
         });			
			});
		
		});	
		
	</script>	
</body>
</html>
