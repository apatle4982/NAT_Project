<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesQcData[]|\Cake\Collection\CollectionInterface $FilesQcData
  */
?> 
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
	<?= $this->Form->create($FilesQcData, ['horizontal'=>true]) ?>
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins"> 
				<?php 
					echo $this->element('searchall_template'); 
				?> 
				<div class="card"> 
					<div class="card-body">
						<div class="live-preview"> 
						<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
						<!---Using helper here--->
						<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
						<?php } ?>
					
						<?php echo $this->element('common_records_list'); ?>
						</div> 
					</div> 
				</div>

            </div>
        </div>
    <?= $this->Form->end() ?>

		 
	
	</div>
</div> 
<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'Y'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' } }],
			"ajax": {
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListRejection"]) ?>',
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
			order: [[ 2 ,"asc" ]],
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
 
        $("#OKbtn, #RTPbtn, #RIHbtn").click(function(){
			if(!$('.checkSingle:checkbox').is(':checked')){
				alert("Please select at least one record");
				return false;
			}
        });
		
		
    });
</script>
<?php $this->end() ?>