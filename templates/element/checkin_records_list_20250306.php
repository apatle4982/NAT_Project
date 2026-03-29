<?php

if(isset($csvFileName) && !empty($csvFileName)) { ?>
	<!---Using helper here -->
	<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
<?php } ?>
<!-----Using helper here----->
<?php if($this->request->getParam('controller') == "FilesQcData") {  if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
	<?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks) ?>
<?php  } 
	} // Qc controller
?>
<!---------------------------->

 <div class="ibox-content">
 	<?php if($this->request->getParam('controller') == "FilesVendorAssignment" && $this->request->getParam('action') == "index") {
		if($user_Gateway){
	?>
			<?php //$this->Form->button(__('Generate Sheet'), ['name'=>'checkinDataSheet', 'class'=>'btn btn-primary dreceived']) ?>
		<?php } else{ ?>
			<div >
				<input Type="button" value="Assign Vendor" onclick="getBarcode1()" class="btn btn-primary assign_vendor" />
				<!--<?= $this->Form->button(__('Assign Vendor'), ['type'=>'button','class'=>'btn btn-primary dreceived','onclick'=>'getBarcode1()']) ?> -->
				<!--<?= $this->Form->button(__('Document Not Received, Generate Sheet'), ['class'=>'btn btn-primary dnreceived']) ?> -->
			</div>
	<?php 	}  } ?>
    <?php if($this->request->getParam('controller') == "FilesVendorAssignment" && $this->request->getParam('action') == "attindex") {
		if($user_Gateway){
	?>
		<?php } else{ ?>
			<div >
				<input Type="button" value="Assign Attorney" onclick="getBarcode1()" class="btn btn-primary assign_att" />
			</div>
	<?php 	}  } ?>
    <?php if($this->request->getParam('controller') == "FilesVendorAssignment" && $this->request->getParam('action') == "essindex") {
		if($user_Gateway){
	?>
		<?php } else{ ?>
			<div >
				<input Type="button" value="Assign Escrow Service" onclick="getBarcode1()" class="btn btn-primary assign_vess" />
			</div>
	<?php 	}  } ?>
	
	<!--------------------Township records ------------------------------->
	<?php if(!empty($townshipRecordsTable)) { ?>

		<div class="m-t m-b">
			<div onclick="this.classList.add('hidden');" class="message error myerrorClass">
				<ul>
					<li><?= __('ERROR: Please select township/division for below records. The County has multiple township/division. Township/division must be select to save below records. Rest of the records are saved successfully.') ?>
					</li>
				</ul>
			</div>
			
			<table class="table dataTable order-column stripe table-striped table-bordered">
				<thead>
					<tr>
						<th><input type="checkbox" name="checkedAll" id="checkedAll" /></th>

						<?php if($user_Gateway == 0){ ?>
						<th><?= __(isset($partnerMapField['mappedtitle']['NATFileNumber'])? $partnerMapField['mappedtitle']['NATFileNumber']: 'FileNo') ?></th>
						<?php } ?>

						<th><?= __(isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'PartnerFileNumber') ?></th>
						
						<th><?= __(isset($partnerMapField['mappedtitle']['TransactionType'])? $partnerMapField['mappedtitle']['TransactionType']: 'Transaction Type') ?></th>
						
						<th><?= __(isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantors') ?></th>
						
						<th><?= __(isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'StreetName') ?></th>
						
						<th ><?= __(isset($partnerMapField['mappedtitle']['State'])? $partnerMapField['mappedtitle']['State']: 'State') ?></th> 
						
						<th><?= __(isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></th> 
						<th ><?= __('Township/Division') ?></th>
						<th ><?= __('ECapable') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php echo $townshipRecordsTable; ?>
				</tbody>
			</table>
		</div>
	<?php } else{  ?>
	<!--------------------Township records ------------------------------->
    <?php if($this->request->getParam('action') == "aolindex") { ?>
	<div class="accountList">
		<table class="table dataTable order-column stripe table-striped table-bordered" id="datatable_example">
			<thead>
				<tr>
					<th>
					<?php echo ($is_index=='Y' || ($user_Gateway)) ? '<input type="checkbox" name="checkedAll" id="checkedAll" />' : 'Sr No.'; ?>
					</th>

					<?php if($user_Gateway == 0){ ?>
					<th><?= __(isset($partnerMapField['mappedtitle']['NATFileNumber'])? $partnerMapField['mappedtitle']['NATFileNumber']: 'FileNo') ?></th>
					<?php } ?>

					<th><?= __(isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'Partner File Number') ?></th>

					<?php if($this->request->getParam('controller') == "NotRequired") { ?>
					<th><?= __(isset($partnerMapField['mappedtitle']['Extension'])? $partnerMapField['mappedtitle']['Extension']: 'Extension') ?></th>
					<?php } ?>

					<th><?= __(isset($partnerMapField['mappedtitle']['TransactionType'])? $partnerMapField['mappedtitle']['TransactionType']: 'Transaction Type') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantor(s)') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'Street Name') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></th>
					<th ><?= __(isset($partnerMapField['mappedtitle']['State'])? $partnerMapField['mappedtitle']['State']: 'State') ?></th>

					<?php if($this->request->getParam('controller') == "FilesQcData") { ?>
					<th ><?= __('Status') ?></th>
					<?php } else{ ?>
					<th ><?= __('Pre AOL') ?></th>
					<th ><?= __('Final AOL') ?></th>
					<?php } ?>
					<!--<th ><?= __('ECapable') ?></th>-->
					<?php if($this->request->getParam('controller') == "FilesVendorAssignment" || $this->request->getParam('controller') == "FilesExamReceipt" || $this->request->getParam('controller') == "FilesRecordingData") { ?>
					<th ><?= __('FileStartDate Timestamp') ?></th>
					<?php } ?>
					<?php if($this->request->getParam('controller') == "FilesQcData") { ?>
					<th ><?= __('StatusReason') ?></th>
					<th ><?= __('Note') ?></th>
					<th ><?= __('ProcDate') ?></th>
					<?php } ?>


					<?php if($is_index=='Y' || ($user_Gateway)){ ?>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
					<?php } ?>
				</tr>
			</thead>
		</table>
	</div>
	<?php }else{  ?>
    <div class="accountList">
		<table class="table dataTable order-column stripe table-striped table-bordered" id="datatable_example">
			<thead>
				<tr>
					<th>
					<?php echo ($is_index=='Y' || ($user_Gateway)) ? '<input type="checkbox" name="checkedAll" id="checkedAll" />' : 'Sr No.'; ?>
					</th>

					<?php if($user_Gateway == 0){ ?>
					<th><?= __(isset($partnerMapField['mappedtitle']['NATFileNumber'])? $partnerMapField['mappedtitle']['NATFileNumber']: 'FileNo') ?></th>
					<?php } ?>

					<th><?= __(isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'Partner File Number') ?></th>

					<?php if($this->request->getParam('controller') == "NotRequired") { ?>
					<th><?= __(isset($partnerMapField['mappedtitle']['Extension'])? $partnerMapField['mappedtitle']['Extension']: 'Extension') ?></th>
					<?php } ?>

					<th><?= __(isset($partnerMapField['mappedtitle']['TransactionType'])? $partnerMapField['mappedtitle']['TransactionType']: 'Transaction Type') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantor(s)') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'Street Name') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></th>
					<th ><?= __(isset($partnerMapField['mappedtitle']['State'])? $partnerMapField['mappedtitle']['State']: 'State') ?></th>

					<?php if($this->request->getParam('controller') == "FilesQcData") { ?>
					<th ><?= __('Status') ?></th>
					<?php } else{ ?>
					<th ><?= __('AssignedStatus') ?></th>
					<?php } ?>
					<!--<th ><?= __('ECapable') ?></th>-->
					<?php if($this->request->getParam('controller') == "FilesVendorAssignment" || $this->request->getParam('controller') == "FilesExamReceipt" || $this->request->getParam('controller') == "FilesRecordingData") { ?>
					<th ><?= __('FileStartDate Timestamp') ?></th>
					<?php } ?>
					<?php if($this->request->getParam('controller') == "FilesQcData") { ?>
					<th ><?= __('StatusReason') ?></th>
					<th ><?= __('Note') ?></th>
					<th ><?= __('ProcDate') ?></th>
					<?php } ?>


					<?php if($is_index=='Y' || ($user_Gateway)){ ?>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
					<?php } ?>
				</tr>
			</thead>
		</table>
	</div>
	<?php }
    } // else for township   ?>
	
	<?php 
		if($this->request->getParam('controller') == "FilesVendorAssignment" && $this->request->getParam('action') == "index") {
			if($user_Gateway){
	?>
			<?php //$this->Form->button(__('Generate Sheet'), ['name'=>'checkinDataSheet', 'class'=>'btn btn-primary dreceived']) ?>
		<?php } else{ ?>
			<div class="col-lg-12 m-t">
				<input Type="button" value="Assign Vendor" onclick="getBarcode1()" class="btn btn-primary assign_vendor" />
				<!--<?= $this->Form->button(__('Assign Vendor'), ['class'=>'btn btn-primary dreceived']) ?>-->
				<!--<?= $this->Form->button(__('Document Not Received, Generate Sheet'), ['class'=>'btn btn-primary dnreceived']) ?>-->
			</div>
		
	<?php 	
			} 
		}
		
		if($this->request->getParam('controller') == "FilesQcData") { ?>
		<div class="m-t">
		<?php if($is_index=='Y'){ ?>
			<?= $this->Form->button(__('Ok'), ['type'=>'submit','class'=>'btn btn-primary dreceived block','id'=>'OkBtn', 'name'=>'saveQCdata']) ?>
		<?php } else{ ?>
			<?= $this->Form->button(__('Generate Rejection Sheet'), ['name'=>'qcDataSheet', 'class'=>'btn btn-primary']) ?>
		<?php } ?>
			
		</div>
	<?php } ?>
	<div>&nbsp;<br/></div>

	<div>
		 
		<!--- use helper to show Help---->
		<?php if(!empty($partnerMapField['help'])){ 
			echo $this->Lrs->showMappingHelp($partnerMapField['help']);
		 } ?>
		
	</div>
	
	
</div>

<script>
function getBarcode1(){
		
          var val1 = 584498;
		  var val2 = 9;
		  //alert('okkss');
		  jQuery('#myModal').modal('show');
		  return;  
		  
		  
			$.ajax({
				type: "POST",
				//url: '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" =>  "generateBarcode"]) ?>',
				url: '<?= $this->Url->build(["controller"=> "FilesCheckinData", "action" => "generateBarcode"]) ?>',
				data: {"fileno": val1, "doctype": val2},
				success: function(data){
					$('#printThis').html(data);
					jQuery('#myModal').modal('show');
				},
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
			});
		
	} 
</script>