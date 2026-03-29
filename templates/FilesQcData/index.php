<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesQcData[]|\Cake\Collection\CollectionInterface $FilesQcData
  */
?> 
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
	<?= $this->Form->create($FilesQcData, ['id'=>'search-files-qc-data', 'horizontal'=>true]) ?>
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins"> 
				<?php 
					echo $this->element('searchall_template'); 
				?>
				<div class="card">
					<div class="card-body"> 
						<div class="row gy-4">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row gy-4">
									  
									<div class="col-xxl-12 col-md-12 col-sm-12">
										<div class="submit" style="text-align:left!important;">
											<?= $this->Form->button(__('OK'), ['type'=>'submit','class'=>'btn btn-primary block m-r', 'name'=>'OKbtn', 'id'=>'OKbtn']) ?>
											<?= $this->Form->button(__('RTP'), ['name'=>'RTPbtn', 'class'=>'btn btn-primary', 'id'=>'RTPbtn']) ?>
											<?= $this->Form->button(__('RIH'), ['name'=>'RIHbtn', 'class'=>'btn btn-primary', 'id'=>'RIHbtn']) ?>
											&nbsp;&nbsp;(OK = Clears Rejection)
										</div> 
									</div> 		
									
								</div>
							</div> 
						
						</div>
						<!-- Qc Processing end -->
					</div>
				</div>

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
		let search_form_data = getSerializeFormData('#search-files-qc-data');
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'Y'};
		formdata.formdata = {...formdata.formdata, ...search_form_data}

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