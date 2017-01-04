<!-- basic scripts -->
		
<!--[if !IE]> -->

<script type="text/javascript">
	window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
		
<script type="text/javascript">
window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
if("ontouchend" in document) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->
<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.3.full.min.js"></script>

<script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jqGrid/i18n/grid.locale-en.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url();?>assets/select2/select2.min.js"></script>

<!-- ace scripts -->

<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/select2/select2.css" />
	
<!-- Search Autocomplete script-->
<script type="text/javascript">
	$(document).ready(function(){
	function split( val ) {
		return val.split( /,\s*/ );
	}
	
	function extractLast( term ) {
		return split( term ).pop();
	}
	
	function set_location_details(location_code) {		
		$.getJSON( "<?php echo site_url();?>/transaction/get_location_details", { 'location_code': location_code} )
		.done(function( json ) {
			$('#location_code').val(json[0].location_code);
			$('#location_id').val(json[0].location_id);			
			$('#location_name').val(json[0].location_name);
			$('#client_name').val(json[0].client_name);			
		});		
	}
	
	function reset_location_details() {
		$('#location_code').val('');
		$('#location_id').val('');
		$('#location_name').val('');
		$('#itemCode').val('');
	}
	
	$( "#locationName" ).autocomplete({
			source: function( request, response ) {
				$.getJSON( "<?php echo site_url();?>/transaction/location_name",{
					term: extractLast( request.term )
				},response );
			},
			search: function() {
				// custom minLength
				reset_location_details();
				var term = extractLast( this.value );
				if ( term.length < 1 ) {
					return false;
				}
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.value );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( "" );
				
				set_location_details(this.value);
				return false;
			}
		});
		
		$( "#itemCode" ).autocomplete({
			source: function( request, response ) {
				$.getJSON( "<?php echo site_url();?>/transaction/item_code",{
					term: extractLast( request.term ),
					location_id: extractLast( $( "#location_id" ).val() )
				},response );
			},
			search: function() {
				// custom minLength
				var term = extractLast( this.value );
				if ( term.length < 1 ) {
					return false;
				}
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.value );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( "" );
				return false;
			}
		});
	});
</script>

<div class="main-content">
	<div id="breadcrumbs" class="breadcrumbs">		
	<script type="text/javascript">
	try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	
	<ul class="breadcrumb">
	<li>
	<i class="icon-home home-icon"></i>
	<a href="<?php echo site_url();?>/home">Home</a>
	</li>	
	<li class="active">Add Adjustment</li>
	</ul><!-- .breadcrumb -->
	</div>

	<div class="page-content">
		<div class="page-header">
			<h1>Add Adjustment</h1>			
		</div>
			
		<div class="row">			
			<div class="col-sm-12">			
				<?php echo validation_errors(); ?>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="itemName">Location:</label>
						<div class="col-sm-9">
							<input id="locationName" name="locationName" class="col-xs-10 col-sm-5" type="text" placeholder="Location Name"/>
							&nbsp;<button class="btn btn-sm btn-success" id="add-adjust-transaction" type="button"><i class="icon-pencil"></i> Select</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div id="add_transaction_item">
				<div class="col-sm-12">
				<h3 class="header smaller lighter blue" id="transaction_details_id">Location Inventory Details</h3>
					<form class="form-horizontal" role="form">
						<!--Correction-->
						<div class="form-group">						
							<label class="col-sm-3 control-label no-padding-right" for="transaction_id">Transaction ID</label>
							<div class="col-sm-9">
								<input id="transaction_id" class="col-xs-10 col-sm-5" type="text" placeholder="Transaction ID" disabled="disabled"/>
							</div>
						</div>
						
						<div class="form-group">						
							<label class="col-sm-3 control-label no-padding-right" for="location_id">Location ID</label>
							<div class="col-sm-9">
								<input id="location_id" class="col-xs-10 col-sm-5" type="text" placeholder="Location ID" disabled="disabled"/>
							</div>
						</div>
						
						
						<div class="form-group">						
							<label class="col-sm-3 control-label no-padding-right" for="location_code">Location Code</label>
							<div class="col-sm-9">
								<input id="location_code" class="col-xs-10 col-sm-5" type="text" placeholder="Location Code" disabled="disabled"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="location_name">Location Name</label>
							<div class="col-sm-9">
								<input id="location_name" class="col-xs-10 col-sm-5" type="text" placeholder="Location Name" disabled="disabled"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="client_name">Client Name</label>
							<div class="col-sm-9">
								<input id="client_name" class="col-xs-10 col-sm-5" type="text" placeholder="Client Name" disabled="disabled"/>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="itemCode">Item Code:</label>
							<div class="col-sm-9">
							<input id="itemCode" name="itemCode" class="col-xs-10 col-sm-5" type="text" placeholder="Item Code"/>&nbsp;
							<button id="submit_search" name="submit_search" class="btn btn-app btn-primary btn-xs" type="button"><i class="icon-search"></i> View</button>							
							<a href="#add_item_modal" role="button" class="btn btn-app btn-default btn-xs" data-toggle="modal"><i class="icon-plus bigger-160"></i> Add Item </a>					
							</div>
						</div>
					</form>
				</div>
				
				<div class="col-sm-12">					
					<table id="item-results"></table>
					<div id="item-results-pager"></div>
				</div>
				<div class="col-sm-12">					
					<hr/>					
					<button id="submit_adjustment_transaction" class="btn btn-app btn-success btn-xs pull-right" type="button"><i class="icon-save bigger-160"></i> Submit</button>
					<button id="submit_adjustment_transaction" class="btn btn-app btn-danger btn-xs pull-right" type="button"><i class="icon-trash bigger-160"></i> Cancel</button>					
					
				</div>
				
			</div>
		</div>
	</div>
	
		
</div><!--/.page-content-->	
</div><!-- /.main-content -->

<div id="add_item_modal" class="modal fade">
	<form class="form-horizontal" role="form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add item</h4>
      </div>
      <div class="modal-body overflow-visible">
        <div class="row">
			<div class="col-xs-12 col-sm-12">				
				<div class="form-group">
					<label class="col-sm-4" for="new_item_location_id">Location ID</label>
					<div class="col-sm-8">
					<input class="form-input col-sm-9" type="text" id="new_item_location_id" name="new_item_location_id" disabled="disabled" placeholder="Location ID" required/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4" for="new_item_location_name">Location Code</label>
					<div class="col-sm-8">
					<!--<input class="form-input col-sm-9" type="text" id="new_item_location_code" name="new_item_location_code" placeholder="Location Code" required/>-->
						<select id="new_item_location_code" class="form-input col-sm-9" name="new_item_location_code" required>
							<option>&nbsp;</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4" for="new_item_location_name">Location Name</label>
					<div class="col-sm-8">
					<input class="form-input col-sm-9" type="text" id="new_item_location_name" name="new_item_location_name" disabled="disabled" placeholder="Location Name" required/>
					</div>
				</div>
				
				<div class="form-group">					
					<label class="col-sm-4" for="new_item_item_code">Item Code</label>
					<div class="col-sm-8">
					<!--<input class="form-input col-sm-9" type="text" id="new_item_item_code" name="new_item_item_code" placeholder="Item Code" required/>-->
						<select id="new_item_item_code" class="form-input col-sm-9" name="new_item_item_code" required>
							<option>&nbsp;</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">					
					<label class="col-sm-4" for="new_item_item_code">Item Name</label>
					<div class="col-sm-8">
					<input class="form-input col-sm-9" type="text" id="new_item_item_name" name="new_item_item_name" disabled="disabled" placeholder="Item Name" required/>
					</div>
				</div>
				
				<div class="form-group">					
					<label class="col-sm-4" for="new_item_quantity">Quantity</label>
					<div class="col-sm-8">
					<input class="form-input col-sm-9" type="text" id="new_item_quantity" name="new_item_quantity" placeholder="Quantity" required/>
					</div>
				</div>
				
				<div class="form-group">					
					<label class="col-sm-4" for="new_item_quantity">Reason</label>
					<div class="col-sm-8">
					<textarea class="form-input col-sm-9" type="text" id="new_item_reason" name="new_item_reason" placeholder="Reason" required></textarea>
					</div>
				</div>				
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		<button class="btn btn-success" id="new_item_save">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div><!-- /.modal -->

<script type="text/javascript">
	//JqGrid
	function grid_set_data(grid_data){		
		//Reset Data
		jQuery("#item-results")
			.jqGrid('setGridParam',
			{ 
				datatype: 'local',
				data:'',						
		})				
		.trigger("reloadGrid");
		
		//Set Data
		jQuery("#item-results")
			.jqGrid('setGridParam',
			{ 
				datatype: 'local',
				data:grid_data,				
		})
		.trigger("reloadGrid");	
	}

	function refresh_item_data(){
		$.post('<?php echo site_url();?>/transaction/adjust_search', {'location_id' : $('#location_id').val(), 'item_code' : $('#itemCode').val() },
		function(data){
			var result = data.result;
			var response = data.response;
			if (response == 'Success') {			
				//Reset data				
				grid_set_data(result);
				
			}
			else{
				alert(response);
			}		
		}, "json");		
	}
</script>
	
<script type="text/javascript">
	//Select Location
	//$('#add_transaction_item').hide();//Hide add item details
		
	$(document).ready(function()
	{
		$("#add-adjust-transaction").click(function(){
			//Add transaction and fetch transaction ID
			$.post('<?php echo site_url();?>/adjustment/add_transaction',  {'location_id' : $('#location_id').val()},
			function(data){
				var transaction_response = data.transaction_result;
				if (transaction_response != 'Error') {			
					echo ('Success: '+transaction_response);
				}
				else{
					echo ('Error: '+transaction_response);
				}		
			}, "json");
			
			//
			$('#add_transaction_item').show();			
		});
		
		$("#submit_search").click(function()
		{	
			$.post('<?php echo site_url();?>/transaction/adjust_search', {'location_id' : $('#location_id').val(), 'item_code' : $('#itemCode').val() },
			function(data){
				var result = data.result;
				var response = data.response;
				if (response == 'Success') {			
					//Reset data				
					grid_set_data(result);					
				}
				else{
					alert(response);
				}		
			}, "json");		
		});
	
	});
</script>

<script type="text/javascript">
	//Location Code
	jQuery(function($) {
		$( "#new_item_location_code" ).select2({
			placeholder: "Select Location Code",
			width: '300px'
		});
		
		$( "#new_item_item_code" ).select2({
			placeholder: "Select Location Code",
			width: '300px'
		});
	});
	
	$.getJSON("<?php echo site_url();?>/select_data/location_code_select", function(data){
		$.each(data.type_list, function() {
			$.each(this, function(k, v) {				
				$('#new_item_location_code').append($('<option>').text(v).attr('value', k));
			});
		});
	});
	
	$.getJSON("<?php echo site_url();?>/select_data/item_code_select", function(data){
		$.each(data.type_list, function() {
			$.each(this, function(k, v) {				
				$('#new_item_item_code').append($('<option>').text(v).attr('value', k));
			});
		});
	});	
</script>

<script type="text/javascript">
jQuery(function($) {
	
	$("#new_item_save").click(function(data) {
		$.post('<?php echo site_url();?>/transaction/add_item',
		function(data){
			var transaction_response = data.transaction_result;
			if (transaction_response != 'Error') {			
				alert('Item has been added Successfully.');
			}
			else{
				alert(response);				
			}		
		}, "json");	
	});

});
</script>

			<script type="text/javascript">	
				var grid_details_data;
				
				jQuery(function($) {
					
				var grid_selector = "#item-results";
				var pager_selector = "#item-results-pager";
				
					jQuery(grid_selector).jqGrid({
						data: grid_details_data,
						datatype: "local",						
						height: 150,			
							colNames:['', 'ISBN', 'Item Code', 'Description', 'Beginning QTY', 'Adjusted QTY', 'Ending QTY'/**/],
							colModel:[								
								{name:'locationID',index:'locationID', width:100,editable: true, hidden:true},
								{name:'isbn',index:'isbn', width:100,editable: false},
								{name:'itemCode',index:'itemCode', width:200,editable: false},
								{name:'itemName',index:'itemName', width:100,editable: false},
								{name:'qtyConsigned',index:'qtyConsigned', width:100,editable: false, align: "center"},
								{name:'adjustedQty', index:'adjustedQty', align: "center", width:150, editable: true, editrules:{number: true}},
								{name:'endQty', index:'endQty', align: "center", width:150, editable: false}												
							],	 
						viewrecords : true,						
						altRows: true,			
						sortname: 'itemCode',
						sortorder: 'asc',
						multiselect: false,								
						multiboxonly: false,
						//cellEdit: true,
						onSelectRow: function () {
								//alert();	
						},
						//editurl: "<?php echo site_url();?>/transaction/update_item",
						/*cellurl: "<?php echo site_url();?>/adjustement/add_transaction_item",
						beforeSaveCell : function (rowid, cellname, value) {							
							//if (cellname === 'adjustedQty') {
							var $this = $(this);
							var begin_quantity = parseInt($this.jqGrid("getCell", rowid, 'qtyConsigned'));
							var adjust_quantity = parseInt(value);
							var computation;
							if (adjust_quantity === '') {
								alert('Adjust quantity is not set.');
							}							
							if (adjust_quantity < 0) {
								if (begin_quantity === 0) {
									alert('Beginning quantity is 0 nothing to deduct.');
									$this.jqGrid("setCell", rowid, 'endQty', begin_quantity);
								}
								else{
									computation = begin_quantity - (adjust_quantity * -1);
									if (computation < 0) {
										alert('Negative Adjustment is greater than the beginning Quantity.');
										$this.jqGrid("setCell", rowid, 'endQty', begin_quantity);
										
									}
									else{
										$this.jqGrid("setCell", rowid, 'endQty', computation);
										$this.jqGrid("setCell", rowid, cellname, adjust_quantity);
									}
								}
							}
							else{								
								$this.jqGrid("setCell", rowid, 'endQty', begin_quantity + adjust_quantity);
								$this.jqGrid("setCell", rowid, cellname, adjust_quantity);
							}							
						},*/
						/*beforeSubmitCell : function(rowid,celname,value,iRow,iCol) {
							//get locationID and itemCode
							var $this = $(this);
							var itemCode = $this.jqGrid("getCell", rowid, 'itemCode');
							var locationID = $this.jqGrid("getCell", rowid, 'locationID');
							var newQty = $this.jqGrid("getCell", rowid, 'endQty');
							
							return {location_id:locationID, item_code:itemCode, new_quantity:newQty };//add post parameter
						},*/
						caption: 'Items',
						autowidth: true
					});
					
				});
			</script>

