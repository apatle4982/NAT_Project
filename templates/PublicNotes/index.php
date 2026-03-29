<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FieldsMst[]|\Cake\Collection\CollectionInterface $fieldsMst
  */
 
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card"> 

				<div class="card-body">
					<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4">
					<div class="dv-frm-left">

						<div class="row gy-4">
						
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= $partnerMapFields['mappedtitle']['PartnerFileNumber']?>: </b></label>
									<?= $filesMainData['PartnerFileNumber']?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= ($partnerMapFields['mappedtitle']['TransactionType'] == 'TransactionType') ? __('Transaction Type') : $partnerMapFields['mappedtitle']['TransactionType']  ?>: </b></label>
									<?= $filesMainData['DocumentTypeMst']['Title']?>
								</div>
							</div>
							<?php if(!$user_Gateway){ ?>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= ($partnerMapFields['mappedtitle']['PartnerID'] == 'PartnerID') ? __('Partner') : $partnerMapFields['mappedtitle']['PartnerID']  ?>: </b></label>
									<?= $filesMainData['CompanyMst']['cm_comp_name'] ?>
								</div>
							</div>
						
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= $partnerMapFields['mappedtitle']['NATFileNumber'] ?>:  </b></label>
									<?= $filesMainData['NATFileNumber']?>
								</div>
							</div>
							<?php } ?>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= $partnerMapFields['mappedtitle']['Grantors']?>:  </b></label>
									<?= $filesMainData['Grantors']?>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= $partnerMapFields['mappedtitle']['StreetName']?>: </b></label>
									<?= $filesMainData['StreetName']?>
								</div>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= $partnerMapFields['mappedtitle']['State']?>: </b></label>
									<?= $filesMainData['State']?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="form-group">
									<label><b><?= $partnerMapFields['mappedtitle']['County']?>: </b></label>
									<?= $filesMainData['County']?>
								</div>
							</div> 
						</div> 
					</div>
				</div>

				<div class="pull-right m-r" style="float: right;">
					<?php
					if($section == 'fsad') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesShiptoCountyData', 'action' => 'index'], ['class' => 'btn btn-danger']);
					}
					else if($section == 'frd') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesRecordingData', 'action' => 'index'], ['class' => 'btn btn-danger']);
					} else if($section == 'frd-noimg') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesRecordingData', 'action' => 'recordingkeyNoImage'], ['class' => 'btn btn-danger']);
					} else if($section == 'fqcd') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesQcData', 'action' => 'index'], ['class' => 'btn btn-danger']);
					} else if($section == 'fad') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesAccountingData', 'action' => 'index'], ['class' => 'btn btn-danger']);
					} else if($section == 'fcd') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesCheckinData', 'action' => 'index'], ['class' => 'btn btn-danger']);
					}else if($section == 'rf2p') {
						echo $this->Html->link('Go Back', ['controller' => 'FilesReturned2partner', 'action' => 'index'], ['class' => 'btn btn-danger']);
					} else { ?>
					<button onclick="history.back()" class="btn btn-danger">Go Back</button>
					<?php }
					?>
					
				</div>
            </div>
        </div>
        </div>
        
 
        <div class="card">
             
            <div class="card-body">
				   
			<div class="panel panel-default">
				 
				<div class="panel-body"> 
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
	 
			<!--- use helper to show Help---->
			<?php if(!empty($partnerMapFields['help'])){ 
				echo $this->Lrs->showMappingHelp($partnerMapFields['help']);
			 } ?> 
			 
            </div>
            
        </div>
    </div>
</div>
 
<?php $this->append('script') ?>
<script type="text/javascript">
$(document).ready(function () {

	var formdata = {'formdata':<?php echo json_encode($formpostdata);?>};
	var columndata =<?php echo $dataJson;?>;
	
	$('#dataTables-internal').DataTable({
		"processing": true,
		"pageLength": 200,
		"searching":false,
		"paging": false, 
		"info": false,
		"serverSide": true,
		"dom": 'Blfrtip',  
		"buttons": [{ extend: 'csv', text: 'Export CSV' }],
		"ajax": {
			url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxList".ucfirst($this->request->getParam('action')),'?'=>['tabletype'=>'I']]) ?>',
			
			data: formdata,
			type: 'POST',
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
		},
		order: [[ 0,"asc"]], 
		"columns": columndata	
	});
});
</script>
<?php $this->end() ?>