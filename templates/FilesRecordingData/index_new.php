<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesQcData[]|\Cake\Collection\CollectionInterface $FilesQcData
  */
?>
<?php $this->append('css') ?> 
<style>
@media screen and (max-width: 1400px) {
div#datatable_example_wrapper {
    overflow: auto;
}
}
</style>
<?php $this->end() ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
	    <?= $this->Form->create($FilesRecordingData, ['horizontal'=>true]) ?>
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins"> 
				<?php 
					$widgets = ['RecordsAdded','ShippingStatus', 'Research'];
					echo $this->element('searchall_template',['widgets'=>$widgets]);
				?>
                 
				<div class="card"> 
					<div class="card-body">
						<div class="live-preview"> 
                            <?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
                            <!---Using helper here--->
                            <?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
                            <?php } ?>
							<?php if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
								<?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks) ?>
							<?php  } ?>
                        
                            <?php echo $this->element('common_records_list', ['datatblHerader'=>$datatblHerader, 'firstCol'=>'SrNo']); ?>
						</div> 
					</div> 
				</div>

            </div>
        </div>
        <?= $this->Form->end() ?>

		<?php if(!empty($partnerMapField['help'])){ ?>
			<div class="col-lg-12"> 
				<div class="card" style="margin-top:15px">
					<div class="card-body">
						<?php 
						echo $this->Lrs->showMappingHelp($partnerMapField['help']);
						?>
					</div>
				</div>
			</div>
		<?php } ?>
	
	</div>
</div> 
<?php $this->append('script') ?>
<script type="text/javascript">
	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'<?= $pageType ?>'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',  
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' } }],
			"ajax": {
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListIndexNew"]) ?>',
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
			order: [[ 1 ,"asc" ]],
			createdRow: function( row, data, dataIndex ) {
				if ( data['ECapable'] == "Both SF & CSC" ) {
					$(row).addClass( 'bothColor' );
				} else if( data['ECapable'] == "SF" ) {
					$(row).addClass( 'sfColor' );
				} else if(data['ECapable'] == 'CSC') {
					$(row).addClass( 'cscColor' );
				} else if ( data['lock_status'] == 1 ) {
					$(row).addClass( 'disabledColor' );
				}  
			}
		});
    });
</script>
<?php $this->end() ?>