<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesRecordingData[]|\Cake\Collection\CollectionInterface $FilesRecordingData
  */

?>

<!-- ================================================================ -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<?= $this->Form->create($FilesRecordingData, ['horizontal'=>true]) ?>
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				
				<!-- Data filter Section -->
				<?php 
					// implortant array to active/show widgets from search all element will chenge as per page requirment
					$widgets = ['File', 'Property', 'Mortgagor', 'RecordsAdded','shippNrecord','ShippingStatus', 'Research'];
					echo $this->element('searchall_template',['widgets'=>$widgets,'is_generate'=>true]); 
				?>

				<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
					<!---Using helper here--->
					<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
				<?php } ?>
				
				<!-- Records Listing -->
				<?php echo $this->element('common_records_list', ['datatblHerader'=>$datatblHerader]); ?>


				
			</div>
		</div>
		<?= $this->Form->end() ?>
		
			
	</div>
</div>
<!-- Barcode Modal helper -->

<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'<?= $pageType ?>'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' } }],
			"ajax": {
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListIndex"]) ?>',
				data: formdata,
				type: 'POST',
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
			},
			//"deferRender": true,
			"columns": columndata,
			order: [[ 1 ,"asc" ]]
		});

    });
</script>
<?php $this->end() ?>
