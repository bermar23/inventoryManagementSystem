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

	<li class="active">Transaction Approval</li>
	</ul><!-- .breadcrumb -->
	</div>
					
	<div class="page-content">
		<div class="page-header">
			<h1>Transaction Approval</h1>			
		</div>
		<div class="row">
			<div class="span12">
			<!--PAGE CONTENT BEGINS-->
				<div class="col-sm-6">
					<ol class="dd-list">
					<li data-id="14" class="dd-item dd2-item">
					<div class="dd-handle dd2-handle">
					<span class="badge badge-danger"><?php echo $delivery_count;?></span>
					</div>
					<div class="dd2-content">Delivery
					<a id='delivery_trans' href="<?php echo site_url();?>/transaction/delivery" class="pull-right action-buttons">
					<i class="icon-zoom-in bigger-130"></i>
					</a></div>
					</li>
					<li data-id="14" class="dd-item dd2-item">
					<div class="dd-handle dd2-handle">
					<span class="badge badge-danger"><?php echo $pullout_count;?></span>
					</div>
					<div class="dd2-content">Pull-out
					<a id='pullout_trans' href="<?php echo site_url();?>/transaction/pullout" class="pull-right action-buttons">
					<i class="icon-zoom-in bigger-130"></i>
					</a></div>
					</li>
					<li data-id="14" class="dd-item dd2-item">
					<div class="dd-handle dd2-handle">
					<span class="badge badge-danger"><?php echo $adjust_count;?></span>
					</div>
					<div class="dd2-content">Inventory Adjustment
					<a id="adjust_trans" href="<?php echo site_url();?>/transaction/adjust" class="pull-right action-buttons">
					<!--<a id="adjust_trans" href="<?php //echo site_url();?>/transaction" class="pull-right action-buttons">-->
					<i class="icon-zoom-in bigger-130"></i>
					</a></div>	
					</li>
					</ol>
				</div>
			
			<!--PAGE CONTENT ENDS-->
			</div><!--/.span-->
		</div><!--/.row-->
	
</div><!-- /.main-content -->

