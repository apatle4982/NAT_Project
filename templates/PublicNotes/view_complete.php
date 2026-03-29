<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FieldsMst[]|\Cake\Collection\CollectionInterface $fieldsMst
  */
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<?= $this->element('view_complete') ?>
		
		<?php if($layoutShow) { ?>
		
		<div class="col-xxl-12 col-md-12 col-sm-12">
 
			<div class="card">	 
					
				<div class="card-body">
					<div class="live-preview ">
						<h2><?= __("Notes") ?></h2>
						<div class="row">
							<div class="col-xxl-12 col-md-12 col-sm-12">
							<table class="table dataTable order-column stripe table-striped table-bordered" id="dataTables-internal" >
							  	<thead>
									<tr>
										<th> <?= __('Date') ?></th>
										<th> <?= __('Time') ?></th>
										<th> <?= __('Type') ?></th>
										<th> <?= __('Regarding') ?></th>
										<th> <?= __('Section/Module') ?></th>
										<!--<th> <?= __('Rejection Mail') ?></th>-->
										<th> <?= __('Record Manager') ?></th>
									</tr>
								</thead>
								
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		 
		
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="card">	 
				<div class="card-body">
					<div class="live-preview ">
						<div class="row">
							<div class="col-xxl-12 col-md-12 col-sm-12 detail-list">
								<!--- use helper to show Help---->
								<?php if(!empty($partnerMapFields['help'])){ 
									echo $this->Lrs->showMappingHelp($partnerMapFields['help']);
								 } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php }  ?>
	</div>
</div>


<?php $this->append('script') ?>
<script type="text/javascript">
$(document).ready(function () {

	var formdata = {'formdata':<?php echo json_encode($formpostdata);?>};
	var columndata =<?php echo $dataJson;?>;
 
	$('#dataTables-internal').DataTable({
		"processing": true,
		"pageLength": false,
		"serverSide": true,
		"searching":false,
		"dom": 'Blfrtip',  
 
		"paging":false,
		"info":false,
		"buttons": [{ extend: 'csv', text: 'Export CSV'}],
 
		"ajax": {
			url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListIndex",'?'=>['tabletype'=>'I']]) ?>',
			data: formdata,
			type: 'POST',
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
		},
		"columns": columndata	
	});
});
</script>
<?php $this->end() ?>