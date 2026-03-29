<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\MasterData[]|\Cake\Collection\CollectionInterface $MasterData
  */

?>

<!-- ================================================================ -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<?= $this->Form->create($MasterData, ['horizontal'=>true]) ?>
		<div class="col-lg-12"> 
			<div class="ibox float-e-margins">

				<!-- Data filter Section -->
				<?php 
					// important array to active/show widgets from search all element will chenge as per page requirment
					$widgets = ['RecordsAdded','ProcessedNot','ShippingStatus', 'Research'];
					echo $this->element('searchall_template',['widgets'=>$widgets,'is_generate'=>true, 'isSearch'=>1]); 
				?>
				 
				<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
					<!---Using helper here--->
					<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
				<?php } ?>
				<!-----Using helper here----->
				<?php if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
					<?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks) ?>
				<?php  } ?>
				 
				<!-- Records Listing -->
				<div class="card"><div class="card-body">
					<?php echo $this->element('common_records_list',$datatblHerader); ?>
				</div></div>
		</div></div>
		<?= $this->Form->end() ?>
		
			
	</div>
</div>
<!-- Barcode Modal helper -->

<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'CR'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',  
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:first-child):not(:last-child)' } }],
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
			"columns": columndata,
			order: [[ 2 ,"asc" ]]
		});
	
		
		$(".dreceived").click(function(){
			if(!$('.checkSingle:checkbox').is(':checked')){
				alert("Please select at least one record");
				return false;
			}
        });

    });

</script>
<?php $this->end() ?>
