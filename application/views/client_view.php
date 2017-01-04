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

	<li class="active">Client</li>
	</ul><!-- .breadcrumb -->
	</div>
		
	<div class="page-content">
		<div class="page-header">
			<h1>Client</h1>
		</div>
		<div class="row">			
			<!--PAGE CONTENT BEGINS-->
			<div class="col-xs-12">
				<table id="grid-table-details"></table>
				<div id="grid-pager-details"></div>
			</div>
			<!--PAGE CONTENT ENDS-->			
		</div><!--/.row-->	
	</div><!--/.page-content-->
</div><!-- /.main-content -->

<script type="text/javascript">	
var grid_details_data = [ 
			{client_id:"1",client_code:"1",client_name:"Cleint 1"},
			{client_id:"2",client_code:"2",client_name:"Cleint 2"},
			];

jQuery(function($) {
	var grid_selector = "#grid-table-details";
	var pager_selector = "#grid-pager-details";	
	
	jQuery(grid_selector).jqGrid({
		url: "<?php echo site_url();?>/client_data",
		datatype: "json",
		mtype:'POST',
		loadonce: true,					
		height: 400,			
		colNames:['Actions', 'Client ID', 'Client Code', 'Client Name'],
		colModel:[
			{name:'myac',index:'', width:100, fixed:true, sortable:false, resize:false, search:false,
					formatter:'actions', 
					formatoptions:{ 
						keys:true,
						delbutton:true,							
					}
			},			
			{name:'clientID',index:'clientID',key:true, width:100, align: 'center', editable: false, search:false, sortable:false, hidden:true},						
			{name:'clientCode',index:'clientCode', width:100, align: 'center', editable: false, search:false, sortable:false},
			{name:'clientName',index:'clientName', width:500, editable:true, editrules: { required: true }, hidden:false, sortable:true},
		],	 
		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,		
		gridview: true,
		rownumbers: true,	
		sortname: 'clientName',
		sortorder: 'asc',		
		multiselect: false,								
		multiboxonly: true,
		loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
			}, 0);
		},		
		editurl: "<?php echo site_url();?>/client/action",
		caption: 'Clients',
		autowidth: true
		}).navGrid('#grid-pager-details', 
		{edit: false,add: true,addicon : 'icon-plus-sign purple',del: false,search: true,searchicon : 'icon-search orange',searchtext:'Find',refresh: true,refreshicon : 'icon-refresh green'},/*Options*/
		{closeAfterAdd: true,reloadAfterSubmit:true},/*Edit Options*/ 
		{closeAfterAdd: true,reloadAfterSubmit:true,afterSubmit:function(response,postdata)
			 {
			 $("#grid-table-details").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
			 return [true,"",''];
			 }
 		},/*Add Options*/		 
		{closeAfterAdd: true,reloadAfterSubmit:true}/*Delete Options*/			
		);
		
		
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
	
	

});
</script>