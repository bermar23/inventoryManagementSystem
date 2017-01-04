
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

	<li><a href="<?php echo site_url();?>/transaction">Transaction Approval</a></li>
	
	<li class="active"><?php echo $transaction_title;?></li>
	</ul><!-- .breadcrumb -->
	</div>
					
	<div class="page-content">
		<div class="page-header">
			<h1><?php echo $transaction_title;?></h1>			
		</div>
			
		<div class="row">			
			<div class="col-sm-12">			
				<table id="grid-table-summary"></table>
				<div id="grid-pager-summary"></div>
				
				<script type="text/javascript">
				var $path_base = "/";//this will be used in gritter alerts containing images
				</script>
				
<style type="text/css">
#loading {
    position:relative;
    width:100%;
    height:100%;
}

#loading img {
    margin-top: -12px;
    margin-left: -12px;
    position:absolute;
    top:50%;
    left:50%;
	width:24px;
}
</style>
<div id="loading">
<img src="<?php echo base_url();?>assets/img/loading.gif" alt="Loading" />
</div>
			
			
<!-- basic scripts -->

<!--[if !IE]> -->

<script type="text/javascript">
		window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->
</div>			
</div>

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

<script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jqGrid/i18n/grid.locale-en.js"></script>

<!-- ace scripts -->

<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
	
	var grid_data = <?php echo json_encode($jqgrid_data);?>;
	
	jQuery(function($) {
	var grid_selector = "#grid-table-summary";
	var pager_selector = "#grid-pager-summary";
	
	jQuery(grid_selector).jqGrid({
		
		//direction: "rtl",
	
		data: grid_data,
		datatype: "local",
		height: 200,		
		colNames:['ID', '<?php echo $transaction_type;?> #','Date', 'From Location ID','Location From', 'To Location ID', 'Location To', 'Created By',''],
		colModel:[
			{name:'transactionSummaryID',index:'transactionSummaryID', width:60, sorttype:"int", editable:false, hidden:true},
			{name:'deliveryNo',index:'deliveryNo', width:60, sorttype:"int", editable:false},
			{name:'transactionDate',index:'transactionDate',width:90, editable:false, sorttype:"date",unformat: pickDate},
			{name:'fromLocationID',index:'fromLocationID', width:60, editable:true, hidden:true},
			{name:'locationFrom',index:'locationFrom', width:90,editable: false},
			{name:'toLocationID',index:'toLocationID', width:60, editable:true, hidden:true},
			{name:'locationTo',index:'locationFrom', width:90,editable: false},
			{name:'createdBy',index:'createdBy', width:90,editable: false},//
			{name: "msgAct", align: "center", formatter: function(cellvalue, options, rowobject) {
			return "<button class='btn btn-xs btn-primary' name='view' onclick='view_transaction(" + options.rowId + ");' data-toggle='modal'><i class='icon-pencil'></i> View</button>                <button class='btn btn-xs btn-success' name='approve' onclick='approve_transaction(" + options.rowId + ");'><i class='icon-ok'></i> Approve</button>                <button class='btn btn-xs btn-warning' name='disapprove' onclick='disapprove_transaction(" + options.rowId + ");'><i class='icon-fire'></i> Disapprove</button>" 
			}}
		],
		viewrecords : false,
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,
		//toppager: true,
		sortname: 'transactionDate',
		sortorder: 'asc',
		multiselect: false,					
		//multikey: "ctrlKey",
	multiboxonly: true,
		loadComplete : function() {
			var table = this;
			setTimeout(function(){
				styleCheckbox(table);
				
				updateActionIcons(table);
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},
		onSelectRow: function () {
			var myGrid = $('#grid-table-summary');
			selRowId = myGrid.jqGrid ('getGridParam', 'selrow');
			transaction_id = myGrid.jqGrid ('getCell', selRowId, 'transactionSummaryID');
			transaction_from = myGrid.jqGrid ('getCell', selRowId, 'locationFrom');
			transaction_to = myGrid.jqGrid ('getCell', selRowId, 'locationTo');
			
		},
		editurl: $path_base+"/dummy.html",//nothing is saved
		//editurl: <?php echo base_url();?>+"/dummy.html",//nothing is saved
		caption: 'Summary',

		autowidth: true

	}).navGrid('#grid-pager-summary',{edit:false,add:false,del:false});//disable delete and edit
		
	//enable search/filter toolbar
	//jQuery(grid_selector).jqGrid('filterToolbar',{defaultSearch:true,stringResult:true})

	//switch element when editing inline
	function aceSwitch( cellvalue, options, cell ) {
		setTimeout(function(){
			$(cell) .find('input[type=checkbox]')
					.wrap('<label class="inline" />')
				.addClass('ace ace-switch ace-switch-5')
				.after('<span class="lbl"></span>');
		}, 0);
	}
	//enable datepicker
	function pickDate( cellvalue, options, cell ) {
		setTimeout(function(){
			$(cell) .find('input[type=text]')
					.datepicker({format:'yyyy-mm-dd' , autoclose:true}); 
		}, 0);
	}

	//navButtons
	jQuery(grid_selector).jqGrid('navGrid',pager_selector,
		{ 	//navbar options
			edit: true,
			editicon : 'icon-pencil blue',
			add: true,
			addicon : 'icon-plus-sign purple',
			del: true,
			delicon : 'icon-trash red',
			search: true,
			searchicon : 'icon-search orange',
			refresh: true,
			refreshicon : 'icon-refresh green',
			view: true,
			viewicon : 'icon-zoom-in grey',
		},
		{
			//edit record form
			//closeAfterEdit: true,
			recreateForm: true,
			beforeShowForm : function(e) {
				var form = $(e[0]);
				form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
				style_edit_form(form);
			}
		},
		{
			//new record form
			closeAfterAdd: true,
			recreateForm: true,
			viewPagerButtons: false,
			beforeShowForm : function(e) {
				var form = $(e[0]);
				form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
				style_edit_form(form);
			}
		},
		{
			//delete record form
			recreateForm: true,
			beforeShowForm : function(e) {
				var form = $(e[0]);
				if(form.data('styled')) return false;
				
				form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
				style_delete_form(form);
				
				form.data('styled', true);
			},
			onClick : function(e) {
				alert(1);
			}
		},
		{
			//search form
			recreateForm: true,
			afterShowSearch: function(e){
				var form = $(e[0]);
				form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
				style_search_form(form);
			},
			afterRedraw: function(){
				style_search_filters($(this));
			}
			,
			multipleSearch: true,
			/**
			multipleGroup:true,
			showQuery: true
			*/
		},
		{
			//view record form
			recreateForm: true,
			beforeShowForm: function(e){
				var form = $(e[0]);
				form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
				
			}
		}
	)
	
	function style_edit_form(form) {
		//enable datepicker on "sdate" field and switches for "stock" field
		form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
			.end().find('input[name=stock]')
				  .addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');

		//update buttons classes
		var buttons = form.next().find('.EditButton .fm-button');
		buttons.addClass('btn btn-sm').find('[class*="-icon"]').remove();//ui-icon, s-icon
		buttons.eq(0).addClass('btn-primary').prepend('<i class="icon-ok"></i>');
		buttons.eq(1).prepend('<i class="icon-remove"></i>')
		
		buttons = form.next().find('.navButton a');
		buttons.find('.ui-icon').remove();
		buttons.eq(0).append('<i class="icon-chevron-left"></i>');
		buttons.eq(1).append('<i class="icon-chevron-right"></i>');		
	}

	function style_delete_form(form) {
		var buttons = form.next().find('.EditButton .fm-button');
		buttons.addClass('btn btn-sm').find('[class*="-icon"]').remove();//ui-icon, s-icon
		buttons.eq(0).addClass('btn-danger').prepend('<i class="icon-trash"></i>');
		buttons.eq(1).prepend('<i class="icon-remove"></i>')
	}
	
	function style_search_filters(form) {
		form.find('.delete-rule').val('X');
		form.find('.add-rule').addClass('btn btn-xs btn-primary');
		form.find('.add-group').addClass('btn btn-xs btn-success');
		form.find('.delete-group').addClass('btn btn-xs btn-danger');
	}
	function style_search_form(form) {
		var dialog = form.closest('.ui-jqdialog');
		var buttons = dialog.find('.EditTable')
		buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'icon-retweet');
		buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'icon-comment-alt');
		buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'icon-search');
	}
	
	function beforeDeleteCallback(e) {
		var form = $(e[0]);
		if(form.data('styled')) return false;
		
		form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		style_delete_form(form);
		
		form.data('styled', true);
	}
	
	function beforeEditCallback(e) {
		var form = $(e[0]);
		form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
		style_edit_form(form);
	}



	//it causes some flicker when reloading or navigating grid
	//it may be possible to have some custom formatter to do this as the grid is being created to prevent this
	//or go back to default browser checkbox styles for the grid
	function styleCheckbox(table) {
	/**
		$(table).find('input:checkbox').addClass('ace')
		.wrap('<label />')
		.after('<span class="lbl align-top" />')


		$('.ui-jqgrid-labels th[id*="_cb"]:first-child')
		.find('input.cbox[type=checkbox]').addClass('ace')
		.wrap('<label />').after('<span class="lbl align-top" />');
	*/
	}
	

	//unlike navButtons icons, action icons in rows seem to be hard-coded
	//you can change them like this in here if you want
	function updateActionIcons(table) {
		/**
		var replacement = 
		{
			'ui-icon-pencil' : 'icon-pencil blue',
			'ui-icon-trash' : 'icon-trash red',
			'ui-icon-disk' : 'icon-ok green',
			'ui-icon-cancel' : 'icon-remove red'
		};
		$(table).find('.ui-pg-div span.ui-icon').each(function(){
			var icon = $(this);
			var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
			if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
		})
		*/
	}
	
	//replace icons with FontAwesome icons like above
	function updatePagerIcons(table) {
		var replacement = 
		{
			'ui-icon-seek-first' : 'icon-double-angle-left bigger-140',
			'ui-icon-seek-prev' : 'icon-angle-left bigger-140',
			'ui-icon-seek-next' : 'icon-angle-right bigger-140',
			'ui-icon-seek-end' : 'icon-double-angle-right bigger-140'
		};
		$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
			var icon = $(this);
			var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
			
			if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
		})
	}

	function enableTooltips(table) {
		$('.navtable .ui-pg-button').tooltip({container:'body'});
		$(table).find('.ui-pg-div').tooltip({container:'body'});
	}
	
	});
</script>

		<style type="text/css">
		.modal.modal-wide .modal-dialog {
		  width: 90%;
		}
		.modal-wide .modal-body {
		  overflow-y: auto;
		}
		</style>
		
			
		<script type="text/javascript">
		$('#view-details-modal').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({width:'auto',
		height:'auto', 
		'max-height':'100%'});
		});
		</script>
		
		<div class="row">
				
				
			<div class="col-sm-6" id="transaction_details_group">
			<h3 class="header smaller lighter blue" id="transaction_details_id">Transaction Details</h3>
				
			<form class="form-horizontal" role="form">
				<!--Correction-->
				<input id="row_id_selected" class="col-xs-10 col-sm-5" type="text" placeholder="#" disabled="disabled" hidden/>
				<div class="form-group">						
				<label class="col-sm-3 control-label no-padding-right" for="delivery_number"><?php echo $transaction_type;?> #:</label>
				<div class="col-sm-9">
					<input id="delivery_number" class="col-xs-10 col-sm-5" type="text" placeholder="#" disabled="disabled"/>
				</div>
				</div>
				
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="delivery_date"><?php echo $transaction_type;?> Date:</label>
				<div class="col-sm-9">
					<input id="delivery_date" class="col-xs-10 col-sm-5" type="text" placeholder="DATE" disabled="disabled"/>
				</div>
				</div>
				
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="location_from">Location From:</label>
				<div class="col-sm-9">
					<input id="location_from" class="col-xs-10 col-sm-5" type="text" placeholder="FROM" disabled="disabled"/>
				</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="location_to">Location To:</label>
					<div class="col-sm-9">
						<input id="location_to" class="col-xs-10 col-sm-5" type="text" placeholder="TO" disabled="disabled"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="account_manager">Account Manager:</label>
					<div class="col-sm-9">
						<input id="account_manager" class="col-xs-10 col-sm-5" type="text" placeholder="Account Manager" disabled="disabled"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="comments">Comments:</label>
					<div class="col-sm-9">
						<textarea id="comments" class="autosize-transition form-control" placeholder="Comments" maxlength="450"></textarea>
					</div>
				</div>

				<table id="grid-table-details"></table>
				<div id="grid-pager-details"></div>
				
				<div class="col-sm-9">
					<button id="approve_transaction_button" class='btn btn-lg btn-success'><i class='icon-ok'></i> Approve</button>
					<button id="disapprove_transaction_button" class='btn btn-lg btn-warning'><i class='icon-fire'></i> Disapprove</button>
				</div>
				
				<script type="text/javascript">
				var $path_base = "/";//this will be used in gritter alerts containing images
				</script>
				
				<script type="text/javascript">
						jQuery(function($) {
								
					$("#approve_transaction_button").click(function(){						
						approve_transaction($("#row_id_selected").val());
					});
					$("#disapprove_transaction_button").click(function(){
						alert('Deleting '+$("#row_id_selected").val());
						disapprove_transaction($("#row_id_selected").val());
					});
					
						});
				</script>
			
			
			</form>
			</div>
		</div>
		
	<script type="text/javascript">	
		var grid_details_data = <?php echo json_encode(array());?>;
		
		jQuery(function($) {
		var grid_selector = "#grid-table-details";
		var pager_selector = "#grid-pager-details";
		//var selected_transaction_id;
		
		jQuery(grid_selector).jqGrid({
			//direction: "rtl",
		
			data: grid_details_data,
			datatype: "local",						
			height: 600,			
				colNames:['', '', 'Item Code', '', 'Item Name', 'From Location ID', 'To Location ID', 'Quantity Consigned', '', 'Actual Quantity'],
				colModel:[
					{name:'myac',index:'', width:80, fixed:true, sortable:false, resize:false,
							formatter:'actions', 
							formatoptions:{ 
								keys:true,
								delbutton:false,
								//delOptions:{recreateForm: false},
								//editformbutton:false,
								//editOptions:{recreateForm: true}
							}
					},					
					//ask to hide {name:'transactionID',index:'transactionID', width:100,editable: false},
					{name:'transactionID',index:'transactionID', width:0,editable: true, hidden:true},
					{name:'itemCode',index:'itemCode', width:250,editable: false},
					{name:'itemCode',index:'itemCode', width:0,editable: false, editable:true, hidden:true},
					{name:'itemName',index:'itemCode', width:250,editable: false},
					
					{name:'fromLocationID',index:'fromLocationID', width:100, editable:true, hidden:true},
					{name:'toLocationID',index:'toLocationID', width:100, editable:true, hidden:true},
					
					{name:'qtyConsigned',index:'qtyConsigned', align: "center", width:200, sorttype:"int", editable: false},
					{name:'qtyConsigned',index:'qtyConsigned', align: "center", width:0, sorttype:"int", editable: true, hidden:true},					
					{name:'adjustment', index:'adjustment', width:150, editable: true,
                                editrules:{number: true, custom:true, custom_func: function(value){
										if (value >= 0) {
												return [true];
										}
										else{
												return [false, "Invalid Adjustment value."];
										}
								} 
								},
								
					}
				],	 
			viewrecords : true,
			rowNum:-1,
			rowList:[10,20,30],
			//pager : pager_selector,
			altRows: true,			
			sortname: 'transactionID',
			sortorder: 'asc',
			multiselect: false,								
			multiboxonly: true,
			//url: "<?php echo site_url();?>/edit_details",
			//postData: {
				//transID: function() { return $("#transaction_number").val(); },    
			//},
			/*loadComplete : function() {
				var table = this;
				setTimeout(function(){
					styleCheckbox(table);
					
					updateActionIcons(table);
					updatePagerIcons(table);
					enableTooltips(table);
				}, 0);
			},*/
			//mtype: "POST",
			//serializeGridData: function(postData) { return JSON.stringify(postData); },		
			//postdata: { trans_id: 'bermar' },
			onSelectRow: function () {
				var myGrid = $('#grid-table-details'),
				selRowId = myGrid.jqGrid ('getGridParam', 'selrow'),
				celValue = myGrid.jqGrid ('getCell', selRowId, 'transactionID'),
				selected_transaction_id = celValue;
				//alert(selected_transaction_id);				
			},
			editurl: "<?php echo site_url();?>/edit_details",
			//editurl: $path_base+"/dummy.html",//nothing is saved			
			caption: 'Items',
			autowidth: true
		}).navGrid('#grid-pager-details',{edit:true,add:false,del:false},{afterSubmit:function (response, postdata) {			
				if (response.responseText == 'Success') {
					//alert(response.responseText);					
					return [true, response.responseText]
				}
				else if (response.responseText == 'Input Error') {						
					return [false, 'Adjustment should be whole number. please try again..'];
				}
				else{
					return[false, response.responseText]					
				}
			}
			,closeAfterAdd: true,closeAfterEdit: true,closeAfterSubmit: true});
			
		});
	</script>
		
</div><!--/.page-content-->	
</div><!-- /.main-content -->


<script>
		$('#transaction_details_group').hide();
		$('#loading').hide();
</script>


<script type="text/javascript">		
function view_transaction(row_id){
		$('#transaction_details_group').hide();
		$('#loading').show();
	var transaction_type = "<?php echo strtolower($transaction_type);?>";

		if (transaction_type == '') {
		//code
		alert('Please select transaction!');
		}
	
	var myGrid = $('#grid-table-summary'),
	transaction_id = myGrid.jqGrid ('getCell', row_id, 'transactionSummaryID'),
	transaction_from = myGrid.jqGrid ('getCell', row_id, 'locationFrom'),
	transaction_to = myGrid.jqGrid ('getCell', row_id, 'locationTo');	
	//var transaction_number = $(item).parent().parent().find('td:first-child').text();
	
	$.post('<?php echo site_url();?>/details', {'transaction_id' : transaction_id, 'transaction_type' : transaction_type},
	function(data){
		var transaction_info = data.info;
		var transaction_items = data.items;
		var transaction_response = data.response;
		if (transaction_response != 'Error') {			
			//Reset data			
			transaction_details_data(transaction_items);
			
			$("#delivery_number").val(transaction_info[0].deliveryNo);
			$("#delivery_date").val(transaction_info[0].dtCreated);
			$("#location_from").val(transaction_info[0].locationFrom);
			$("#location_to").val(transaction_info[0].locationTo);
			$("#account_manager").val(transaction_info[0].accountManager);
			$("#row_id_selected").val(row_id);
			
			$('#transaction_details_group').show();
			$('#loading').hide();
		}
		else{
			alert(transaction_response);
			$('#transaction_details_group').hide();
			$('#loading').hide();
		}		
	}, "json");	
}

function approve_transaction(row_id){
		
		$('#loading').show();
		var transaction_type = "<?php echo strtolower($transaction_type);?>";
		
		if (transaction_type == '') {
			//code
			alert('Please select transaction!');
		}
		
		var comments = $("#comments").val();
		var myGrid = $('#grid-table-summary'),		
		transaction_id = myGrid.jqGrid ('getCell', row_id, 'transactionSummaryID'),
		from_location_id = myGrid.jqGrid ('getCell', row_id, 'fromLocationID'),
		to_location_id = myGrid.jqGrid ('getCell', row_id, 'toLocationID');
	
		$.post('<?php echo site_url();?>/approve', {'transaction_id' : transaction_id, 'transaction_type' : transaction_type, 'from_location_id' : from_location_id, 'to_location_id' : to_location_id, 'comments' : comments},
		function(data){
			var transaction_response = data.transaction_result;
			if (transaction_response != 'Error') {			
				//Reset data
				transaction_summary_data(transaction_response);
				unset_details_data();
				unset_transaction_info();
				$('#loading').hide();
			}
			else{
				alert(response);
				$('#loading').hide();
			}		
		}, "json");
		$('#transaction_details_group').hide();
}

//Disapprove transaction
function disapprove_transaction(row_id){
		alert('Deleting '+$("#row_id_selected").val());
		
		$('#loading').show();
		var transaction_type = "<?php echo strtolower($transaction_type);?>";
		
		if (transaction_type == '') {
			//code
			alert('Please select transaction!');
		}
		
		var comments = $("#comments").val();
		var myGrid = $('#grid-table-summary'),		
		transaction_id = myGrid.jqGrid ('getCell', row_id, 'transactionSummaryID'),
		from_location_id = myGrid.jqGrid ('getCell', row_id, 'fromLocationID'),
		to_location_id = myGrid.jqGrid ('getCell', row_id, 'toLocationID');
	
		$.post('<?php echo site_url();?>/disapprove', {'transaction_id' : transaction_id, 'transaction_type' : transaction_type, 'from_location_id' : from_location_id, 'to_location_id' : to_location_id, 'comments' : comments},
		function(data){
			var transaction_response = data.transaction_result;
			if (transaction_response != 'Error') {			
				//Reset data
				transaction_summary_data(transaction_response);
				unset_details_data();
				unset_transaction_info();
				$('#loading').hide();
			}
			else{
				alert(response);
				$('#loading').hide();
			}		
		}, "json");
		$('#transaction_details_group').hide();
}

function transaction_summary_data(summary_grid_data){
	//Reset Data
	jQuery("#grid-table-summary")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:'',						
	})				
	.trigger("reloadGrid");
	
	//Set Data
	jQuery("#grid-table-summary")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:summary_grid_data,				
	})
	.trigger("reloadGrid");
}

function unset_details_data(){	
	//Reset Data
	jQuery("#grid-table-details")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:'',						
	})				
	.trigger("reloadGrid");
	
	//Set Data
	jQuery("#grid-table-details")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:<?php echo json_encode(array());?>,				
	})
	.trigger("reloadGrid");
}

function transaction_details_data(grid_data){	
	//Reset Data
	jQuery("#grid-table-details")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:''
	})				
	.trigger("reloadGrid");
	
	//Set Data
	jQuery("#grid-table-details")
		.jqGrid('setGridParam',
		{ 
			datatype: 'local',
			data:grid_data			
	})
	.trigger("reloadGrid");
}

function unset_transaction_info() {
	$("#transaction_number").val("");
	$("#location_from").val("");
	$("#location_to").val("");
}

</script>