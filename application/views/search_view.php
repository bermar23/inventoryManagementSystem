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

<!-- ace scripts -->

<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>


	
<!-- Search Autocomplete script-->
<script type="text/javascript">
	$(document).ready(function(){
	function split( val ) {
		return val.split( /,\s*/ );
	}
	
	function extractLast( term ) {
		return split( term ).pop();
	}
	
	$( "#itemName" )
		.autocomplete({
			source: function( request, response ) {
				$.getJSON( "<?php echo site_url();?>/reports/itemName",{
					term: extractLast( request.term )
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
		
		$( "#itemCode" )
		.autocomplete({
			source: function( request, response ) {
				$.getJSON( "<?php echo site_url();?>/reports/itemCode",{
					term: extractLast( request.term )
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
	<li class="active">Report</li>
	</ul><!-- .breadcrumb -->
	</div>

	<div class="page-content">
		<div class="page-header">
			<h1>Report</h1>			
		</div>
			
		<div class="row">			
			<div class="col-sm-6">			
				<?php echo validation_errors(); ?>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="itemName">Item Name:</label>
						<div class="col-sm-9">
						<input id="itemName" name="itemName" class="col-sm-6" type="text" placeholder="Item Name"/>
						</div>
						<div class="space-24"></div>
						<label class="col-sm-3 control-label no-padding-right" for="itemCode">Item Code:</label>
						<div class="col-sm-9">
						<input id="itemCode" name="itemCode" class="col-sm-6" type="text" placeholder="Item Code"/>
						<button id="submit_search" name="submit_search" class="btn btn-sm btn-primary pull-right" type="button"><i class="icon-search"></i> Search</button>
						</div>
					</div>
				</form>
			</div>
			
			<div class="col-sm-12">
				<table id="search-results"></table>
				<div id="search-results-pager"></div>
			</div>
			<script type="text/javascript">	
				var grid_details_data = <?php echo json_encode(array());?>;	
				jQuery(function($) {
				var grid_selector = "#search-results";
				var pager_selector = "#search-results-pager";
					jQuery(grid_selector).jqGrid({
						//direction: "rtl",
					
						data: grid_details_data,
						datatype: "local",						
						height: 700,			
							colNames:['Item Code', 'Item Name', 'Location ID', 'Qty Consigned', 'Location Name', 'Location Code','Client Name'],
							colModel:[
								{name:'itemCode',index:'transactionID', width:100,editable: false},
								{name:'itemName',index:'itemName', width:200,editable: false},
								{name:'locationID',index:'locationID', width:100,editable: false},
								{name:'qtyConsigned',index:'qtyConsigned', width:100,editable: false},
								{name:'locationName',index:'locationName', width:200,editable: false},
								{name:'locationCode',index:'locationCode', width:100,editable: false},
								{name:'clientName',index:'clientName', width:200,editable: false}
								
							],	 
						viewrecords : true,
						rowNum:-1,
						//rowList:[5,10,20,30],
						//pager : pager_selector,
						altRows: true,			
						sortname: 'itemCode',
						sortorder: 'asc',
						multiselect: false,								
						multiboxonly: false,
						
						onSelectRow: function () {
							//var myGrid = $('#grid-table-details'),
							//selRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
							//celValue = myGrid.jqGrid ('getCell', selRowId, 'transactionID'),
							//selected_transaction_id = celValue;
							//alert(selected_transaction_id);				
						},
						//editurl: "<?php echo site_url();?>/edit_details",
						caption: 'Search Results',
						autowidth: true
					});
					
					
					//
					
					//
					
				});
			</script>
		</div>
	
		
</div><!--/.page-content-->	
</div><!-- /.main-content -->
	
<script type="text/javascript">
$(document).ready(function()
{
	$("#submit_search").click(function()
	{	
		$.post('<?php echo site_url();?>/reports/search', {'itemName' : jQuery("#itemName").val(), 'itemCode' : jQuery("#itemCode").val()},
		function(data){
			var result = data.result;
			var response = data.response;
			if (response == 'Success') {			
				//Reset data
				//alert(result);
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
	function grid_set_data(grid_data){		
	//Reset Data
	alert(grid_data);
	jQuery("#search-results")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:'',						
	})				
	.trigger("reloadGrid");
	
	//Set Data
	jQuery("#search-results")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:grid_data,				
	})
	.trigger("reloadGrid");
}
</script>
	



