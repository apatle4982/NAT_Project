<div class="row">

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<div class="panel panel-default">
	<div class="panel-heading">
	<?= __("Partner Details") ?>
		<div class="panel-tools pull-right">
			<?php if(!($user_Gateway)){ ?>
				<?php echo $this->Html->link(__('<span style="color:red"> <i>(Edit)</i></span>'), ['controller' => 'FilesCheckinData', 'action' => 'edit', $fileCKData['Id'],'complete'],['title'=>'Edit Partner Details', 'escape'=>false]); ?>
			<?php }?>
		</div>
	</div>
	
	<div class="panel-body">
	 
		<fieldset>
			<legend><?= __('File') ?></legend>
			<div class="row">
				<?php if(!$user_Gateway){ ?>
					<div class="col-lg-6">
						<label><b><?= ($partnerMapFields['mappedtitle']['PartnerID'] == 'PartnerID') ? __('Partner') : $partnerMapFields['mappedtitle']['PartnerID']  ?>: </b></label>
						<?= $filesMainData['CompanyMst']['cm_comp_name'] ?>
					</div>
					<div class="col-lg-6">
						<label><b><?= $partnerMapFields['mappedtitle']['NATFileNumber'] ?>: </b></label>
						<?= $filesMainData['NATFileNumber']?>
					</div>
				<?php } ?>
				
				<div class="col-lg-6">
					<label><b><?= $partnerMapFields['mappedtitle']['PartnerFileNumber']?>: </b></label>
					<?= $filesMainData['PartnerFileNumber']?>
				</div>
				<div class="col-lg-6">
					<label><b><?= ($partnerMapFields['mappedtitle']['TransactionType'] == 'TransactionType') ? __('Document Type') : $partnerMapFields['mappedtitle']['TransactionType']  ?>: </b></label>
					<?= $filesMainData['DocumentTypeMst']['Title']?>
				</div>
			
				<div class="col-lg-6">
					<label><b><?= __('Center/Branch') ?>: </b></label>
					<?= $filesMainData['CenterBranch']?>
				</div>
				<div class="col-lg-6">
					<label><b><?= $partnerMapFields['mappedtitle']['LoanAmount'] ?>: </b></label>
					<?= $filesMainData['LoanAmount']?>
				</div>
				<div class="col-lg-6">
					<label><b><?= __('Document Image') ?>: </b></label>
					<?= $filesMainData['DocumentImage']?>
				</div>
				<div class="col-lg-6">
					<label><b><?= __('APN/PPN #') ?>: </b></label>
					<?= $filesMainData['apn_parcel_number']?>
				</div>
				<?php 
				if(isset($partnerMapFields['fieldsvalsFL'])){
				foreach($partnerMapFields['fieldsvalsFL'] as $fieldsvalFL){ ?>
					<div class="col-lg-6">
						<label><b><?= $fieldsvalFL['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?>: </b></label>
						<?= $filesMainData[$fieldsvalFL['fm']['fm_title']] ?>
					</div>
				<?php } } ?>
			</div>
		</fieldset>
		<!-----------Grantors--------------->

		<fieldset>
			<legend><?= __($partnerMapFields['mappedtitle']['Grantors']) ?></legend>
			<div class="row">
				<div class="col-lg-6">
				<label><b><?= $partnerMapFields['mappedtitle']['Grantors']?>: </b></label>
				<?= $filesMainData['Grantors']?>
				</div>
				<div class="col-lg-6">
				<label><b><?= $partnerMapFields['mappedtitle']['GrantorFirstName1']?>: </b></label>
				<?= $filesMainData['GrantorFirstName1']?>
				</div>

				<?php
				if(isset($partnerMapFields['fieldsvalsMGR'])){
				foreach($partnerMapFields['fieldsvalsMGR'] as $fieldsvalsMGR){ ?>
					<div class="col-lg-6">
						<label><b><?= $fieldsvalsMGR['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?>: </b></label>
						<?= $filesMainData[$fieldsvalsMGR['fm']['fm_title']] ?>
					</div>
				<?php }
				} ?>
			</div>
		</fieldset>

		<!-----------Address--------------->
		<fieldset class="complete-fieldset">
			<legend><?= __('Address') ?></legend>
			<div class="row">
				<div class="col-lg-6">
					<label><b><?= $partnerMapFields['mappedtitle']['StreetNumber']?>: </b></label>
					<?= $filesMainData['StreetNumber']?>
					<?php echo '<br>'; ?>
					
					<label><b><?= $partnerMapFields['mappedtitle']['StreetName']?>: </b></label>
					<?= $filesMainData['StreetName']?>
					<?php echo '<br>'; ?>
					
					<label><b><?= $partnerMapFields['mappedtitle']['City']?>: </b></label>
					<?= $filesMainData['City']?>
					<?php echo '<br>'; ?>
					
					<label><b><?= $partnerMapFields['mappedtitle']['County']?>: </b></label>
					<?= $filesMainData['County']?>
					<?php echo '<br>'; ?>
					
					<label><b><?= $partnerMapFields['mappedtitle']['State']?>: </b></label>
					<?= $filesMainData['State']?>
				
				</div>
				
				<div class="col-lg-6">
					<!-----------County Detail--------------->
					<fieldset>
						<legend><?= __('County Detail') ?></legend>
						<div class="row">
								<div class="col-lg-12">
									
									<label><b><?= __('City')?>: </b></label>
									<?= (isset($CountyDetails['cm_City'])) ? $CountyDetails['cm_City'] : '' ?>
									<?php echo '<br>'; ?>
									<label><b><?= __('Zip Code')?>: </b></label>
									<?= (isset($CountyDetails['cm_zip'])) ? $CountyDetails['cm_zip'] : ''?>
									<?php echo '<br>'; ?>
									<label><b><?= __('Checks Payable To')?>: </b></label>
									<?= (isset($CountyDetails['cm_payable'])) ? $CountyDetails['cm_payable'] : '' ?>
								</div>
						</div>
					</fieldset>
				</div>
				
				
			</div>
		</fieldset>
		
		<fieldset>
			<legend><?= __($partnerMapFields['mappedtitle']['Grantees']) ?></legend>
			<div class="row">
				<div class="col-lg-6">
					<label><b><?= $partnerMapFields['mappedtitle']['Grantees']?>: </b></label>
					<?= $filesMainData['Grantees']?>
				</div>
				<div class="col-lg-6">
					<label><b><?= $partnerMapFields['mappedtitle']['GranteeFirstName1']?>: </b></label>
					<?= $filesMainData['GranteeFirstName1']?>
				</div>
				
				<?php
				if(isset($partnerMapFields['fieldsvalsMGE'])){
					foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
					<div class="col-lg-6">
						<label><b><?= $fieldsvalMGE['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?>: </b></label>
						<?= $filesMainData[$fieldsvalMGE['fm']['fm_title']] ?>
					</div>
					<?php }
				} ?>
			</div>
		</fieldset>

	</div>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	<div class="panel panel-default">
		 <div class="panel-heading">
		<?= __("Check In Data") ?>
		</div>
		<div class="panel-body">
			<div class="row">
				 
				<div class="col-lg-6">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['TransactionType'])) ? ($partnerMapFields['mappedtitle']['TransactionType'] == 'TransactionType') ? 'Document Type' : $partnerMapFields['mappedtitle']['TransactionType'] : 'Document Type'; ?>: </b></label>
					<?= $filesMainData['DocumentTypeMst']['Title']?>
				</div>
				<div class="col-lg-6">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['DocumentReceived'])) ? $partnerMapFields['mappedtitle']['DocumentReceived']: 'Record Status'; ?>: </b></label>
					<?php echo ($fileCKData['DocumentReceived'] == 'Y') ? 'Document received' : 'Document not received';?>
				</div>
				<div class="col-lg-6">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CheckInProcessingDate'])) ? $partnerMapFields['mappedtitle']['CheckInProcessingDate']: 'Added Date'; ?>: </b></label>
					<?php echo (isset($fileCKData['CheckInProcessingDate'])) ?   date('Y-m-d', strtotime($fileCKData['CheckInProcessingDate'])) : '';?>
				</div>
				<div class="col-lg-6">
					<!--------check in document save btn-------$layoutShow for email in user setion only------>
					<?php if(!($user_Gateway)){ ?>
						<?php if(!empty($fileCKData) && ($layoutShow)){ ?> 
							<?= $this->Form->create() ?>
							
								<?php echo $this->Form->control('DocumentReceived', ['type'=>'hidden', 'value'=>($fileCKData['DocumentReceived'] == 'Y') ? '' : 'Y']); ?>
								<?php echo $this->Form->control('checkinId', ['type'=>'hidden', 'value'=>$fileCKData['Id']]); ?>
								<?= $this->Form->button(__(($fileCKData['DocumentReceived'] == 'Y') ? 'Document Not Received' : 'Document Received'), ['name'=>'documentSave','class'=>'btn btn-primary']) ?>
								
							<?= $this->Form->end() ?>
						<?php } ?>
					<?php } ?>
					<!--------check in document save btn------------->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	<div class="panel panel-default">
		 <div class="panel-heading">
		<?= __("QC/Rejection Data") ?>
			<div class="panel-tools pull-right">
			<?php if(!($user_Gateway)){ ?>
				<?php 
					if(empty($fileQcData)){ 
						echo '<span style="color:red"> <i>( Pending )</i></span>';
					}else{ 
						echo $this->Html->link(__('<span style="color:red"> <i>(Edit)</i></span>'), ['controller' => 'FilesQcData', 'action' => 'edit','?'=>['fmd'=>$recordMainId,'doctype'=>$doctype],'complete'],['title'=>'Edit QC/Rejection Details', 'escape'=>false]); 
					}
				?>
			<?php } ?>
			</div>
		</div>
		
		<div class="panel-body">
			<div class="row">
			
					<div class="col-lg-4">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['Status'])) ? $partnerMapFields['mappedtitle']['Status']: 'PRR Status'; ?>: </b></label>
					<?php echo (isset($fileQcData['Status'])) ? $fileQcData['Status']: '';?>
					</div>
					<div class="col-lg-8">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['TrackingNo4RR'])) ? $partnerMapFields['mappedtitle']['TrackingNo4RR']: 'Tracking No For RR (PRR)'; ?>: </b></label>
					<?php echo (isset($fileQcData['TrackingNo4RR'])) ? $fileQcData['TrackingNo4RR']: '';?>
					</div>
					<div class="col-lg-4">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CRNStatus'])) ? $partnerMapFields['mappedtitle']['CRNStatus']: 'CRN Status'; ?>: </b></label>
					<?php echo (isset($fileQcData['CRNStatus'])) ? $fileQcData['CRNStatus']: '';?>
					</div>
					<div class="col-lg-8">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CRNTrackingNo4RR'])) ? $partnerMapFields['mappedtitle']['CRNTrackingNo4RR']: 'Tracking No RR (CRN)'; ?>: </b></label>
					<?php echo (isset($fileQcData['CRNTrackingNo4RR'])) ? $fileQcData['CRNTrackingNo4RR']: '';?>
					</div>
					<div class="col-lg-4">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['LastModified'])) ? $partnerMapFields['mappedtitle']['LastModified']: 'Last Modified'; ?>: </b></label>
					<?php echo (isset($fileQcData['LastModified'])) ?  date('Y-m-d', strtotime($fileQcData['LastModified'])) : ''; ?>
					</div>
					<div class="col-lg-8">
					<label><b><?php echo (isset($partnerMapFields['mappedtitle']['QCProcessingDate'])) ? $partnerMapFields['mappedtitle']['QCProcessingDate']: 'QCProcessing Date'; ?>: </b></label>
					<?php echo (isset($fileQcData['QCProcessingDate'])) ?  date('Y-m-d', strtotime($fileQcData['QCProcessingDate'])) : ''; ?>
					</div>
					
					<?php if($layoutShow) { ?>
						<div class="col-lg-12">
						<label><b><?= __('Rejection History:') ?></b></label>
						<?= $this->element('rejection_SH_table')?>
						</div>
					<?php } ?>
			</div>

		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	<div class="panel panel-default">
		 <div class="panel-heading">
		<?= __("Accounting Data") ?>
			<div class="panel-tools pull-right">
			<?php if(!($user_Gateway)){ ?>
				<?php 
					if(empty($fileACData)){ 
						echo '<span style="color:red"> <i>( Pending )</i></span>';
					}else{ 
						echo $this->Html->link(__('<span style="color:red"> <i>(Edit)</i></span>'), ['controller' => 'FilesAccountingData', 'action' => 'edit','?'=>['fmd'=>$recordMainId,'doctype'=>$doctype],'complete'],['title'=>'Edit Accounting Details','escape'=>false]); 
					}
				?>
			<?php } ?>
			</div>
		
		</div>
		
		<div class="panel-body">
			<div class="row">
				
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CountyRecordingFee'])) ? $partnerMapFields['mappedtitle']['CountyRecordingFee']: 'County Recording Fee';?>: </b></label>
						<?php echo (isset($fileACData['CountyRecordingFee'])) ? $fileACData['CountyRecordingFee']: '';?>
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['Taxes'])) ? $partnerMapFields['mappedtitle']['Taxes']: 'Taxes'; ?>: </b></label>
						<?php echo (isset($fileACData['Taxes'])) ? $fileACData['Taxes']: '';?>
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['AdditionalFees'])) ? $partnerMapFields['mappedtitle']['AdditionalFees']: 'Additional Fees'; ?>: </b></label>
						<?php echo (isset($fileACData['AdditionalFees'])) ? $fileACData['AdditionalFees']: '';?>
						
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['Total'])) ? $partnerMapFields['mappedtitle']['Total']: 'Total'; ?>: </b></label>
						<?php echo (isset($fileACData['Total'])) ? $fileACData['Total']: '';?>
						
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CheckNumber1'])) ? $partnerMapFields['mappedtitle']['CheckNumber1']: 'CheckNumber1'; ?>: </b></label>
						<?php echo (isset($fileACData['CheckNumber1'])) ? $fileACData['CheckNumber1']: '';?>
					
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CheckNumber2'])) ? $partnerMapFields['mappedtitle']['CheckNumber2']: 'CheckNumber2'; ?>: </b></label>
						<?php echo (isset($fileACData['CheckNumber2'])) ? $fileACData['CheckNumber2']: '';?>
					
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CheckNumber3'])) ? $partnerMapFields['mappedtitle']['CheckNumber3']: 'CheckNumber3'; ?>: </b></label>
						<?php echo (isset($fileACData['CheckNumber3'])) ? $fileACData['CheckNumber3']: '';?>
					
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['AccountingProcessingDate'])) ? $partnerMapFields['mappedtitle']['AccountingProcessingDate']: 'Accounting Processing Date'; ?>: </b></label>
						<?php echo (isset($fileACData['AccountingProcessingDate'])) ?  date('Y-m-d', strtotime($fileACData['AccountingProcessingDate'])) : ''; ?>
					
					</div>
					<div class="col-lg-6">
						<label><b><?php echo (isset($partnerMapFields['mappedtitle']['AccountingNotes'])) ? $partnerMapFields['mappedtitle']['AccountingNotes']: 'Accounting Notes'; ?>: </b></label>
						<?php echo (isset($fileACData['AccountingNotes'])) ? $fileACData['AccountingNotes']: '';?>
					</div>
					
					<?php
						if(isset($partnerMapFields['fieldsvalsAD'])){
						foreach($partnerMapFields['fieldsvalsAD'] as $fieldsvalsAD){ ?>
						<div class="col-lg-6">
							<label><b><?= $fieldsvalsAD['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?>: </b></label>
							<?= $filesMainData[$fieldsvalsAD['fm']['fm_title']] ?>
						</div>
					<?php }	} ?>

				
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	<div class="panel panel-default">
		 <div class="panel-heading">
		<?= __("Recording Data") ?>
		
			<div class="panel-tools pull-right">
			<?php if(!($user_Gateway)){ ?>
				<?php 
					if(empty($filesRCData)){ 
						echo '<span style="color:red"> <i>( Pending )</i></span>';
					}else{ 
						echo $this->Html->link(__('<span style="color:red"> <i>(Edit)</i></span>'), ['controller' => 'FilesRecordingData', 'action' => 'edit','?'=>['fmd'=>$recordMainId,'doctype'=>$doctype,'pageType'=>'index'],'complete'],['title'=>'Edit Recording Details', 'escape'=>false]);
					}
				?>
			<?php } ?>
			</div>
		</div>
		
		<div class="panel-body">
			<div class="row">
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['RecordingProcessingDate'])) ? $partnerMapFields['mappedtitle']['RecordingProcessingDate']: 'Recording Processing Date'; ?>: </b></label>
				<?php echo (isset($filesRCData['RecordingProcessingDate'])) ?  date('Y-m-d', strtotime($filesRCData['RecordingProcessingDate'])) : ''; ?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['Book'])) ? $partnerMapFields['mappedtitle']['Book']: 'Book'; ?>: </b></label>
				<?php echo (isset($filesRCData['Book'])) ? $filesRCData['Book']: '';?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['Page'])) ? $partnerMapFields['mappedtitle']['Page']: 'Page'; ?>: </b></label>
				<?php //echo $filesRCData['Page'];?><?php echo (isset($filesRCData['Page'])) ? $filesRCData['Page']: '';?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['DocumentNumber'])) ? $partnerMapFields['mappedtitle']['DocumentNumber']: 'Document Number'; ?>: </b></label>
				<?php //echo $filesRCData['DocumentNumber'];?><?php echo (isset($filesRCData['DocumentNumber'])) ? $filesRCData['DocumentNumber']: '';?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['InstrumentNumber'])) ? $partnerMapFields['mappedtitle']['InstrumentNumber']: 'Instrument Number'; ?>: </b></label>
				<?php echo (isset($filesRCData['InstrumentNumber'])) ? $filesRCData['InstrumentNumber']: '';?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['RecordingDate'])) ? $partnerMapFields['mappedtitle']['RecordingDate']: 'Recording Date'; ?>: </b></label>
				<?php echo (isset($filesRCData['RecordingDate'])) ?  date('Y-m-d', strtotime($filesRCData['RecordingDate'])) : ''; ?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['RecordingTime'])) ? $partnerMapFields['mappedtitle']['RecordingTime']: 'Recording Time'; ?>: </b></label>
				<?php echo (isset($filesRCData['RecordingTime'])) ?  date('H:i:s', strtotime($filesRCData['RecordingTime'])) : ''; ?>
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['File'])) ? $partnerMapFields['mappedtitle']['File']: 'File'; ?>: </b></label>
				<?php   echo (isset($filesRCData['File'])) ? $filesRCData['File'].' ' : '';
						if(!empty($filesRCData['File'])){
							echo $this->html->link(['<i class="fa fa-file-pdf-o" aria-hidden="true"></i>'],['controller' => 'MasterData','action' => 'viewpdf','?'=>['filename'=>$filesRCData['File']]], ['title'=>'View file', 'target'=>'_blank', 'escape'=>false]);
						}
				?>
				
				
				</div>
				
				<div class="col-lg-6">
				<label><b><?php echo (isset($partnerMapFields['mappedtitle']['RecordingNotes'])) ? $partnerMapFields['mappedtitle']['RecordingNotes']: 'Recording Notes'; ?>: </b></label>
				<?php echo (isset($filesRCData['RecordingNotes'])) ? $filesRCData['RecordingNotes']: '';?>
				</div>
				
				
				<?php
					if(isset($partnerMapFields['fieldsvalsRE'])){
						foreach($partnerMapFields['fieldsvalsRE'] as $fieldsvalsRE){ ?>
						<div class="col-lg-6">
							<label><b><?= $fieldsvalsRE['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?>: </b></label>
							<?= $filesMainData[$fieldsvalsRE['fm']['fm_title']] ?>
						</div>
				<?php }	} ?>
				
				<div class="col-lg-6">
					<!--------check in document save btn------$layoutShow for email in user setion only------->
					<?php 
						if(!empty($filesRCData) && ($layoutShow)){ ?> 
						<?= $this->Form->create() ?>
						
							<?= $this->Form->button(__('Recording Confirmation Coversheets'), ['name'=>'coversheetsSave','class'=>'btn btn-primary']) ?>
							
						<?= $this->Form->end() ?>
					<?php } ?>
					<!--------check in document save btn------------->
				</div>
					
			</div>
		</div>
	</div>
</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="panel panel-default">
					 <div class="panel-heading">
					<?= __("Ship To County") ?>
						<div class="panel-tools pull-right">
						<?php if(!($user_Gateway)){ ?>
						<?php 
							if(empty($filesS2CData)){ 
								echo '<span style="color:red"> <i>( Pending )</i></span>';
							}else{ 
								echo $this->Html->link(__('<span style="color:red"> <i>(Edit)</i></span>'), ['controller' => 'FilesShiptoCountyData', 'action' => 'edit','?'=>['fmd'=>$recordMainId,'doctype'=>$doctype],'complete'],['title'=>'Edit Shipping Details', 'escape'=>false]); 
							}
						?>
						<?php } ?>
						</div>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<label><b><?php echo (isset($partnerMapFields['mappedtitle']['ShippingProcessingDate'])) ? $partnerMapFields['mappedtitle']['ShippingProcessingDate']: 'Shipping Processing Date'; ?>: </b></label>
								<?php echo (isset($filesS2CData['ShippingProcessingDate'])) ?  date('Y-m-d', strtotime($filesS2CData['ShippingProcessingDate'])) : ''; ?>
								</div><div class="col-lg-6">
								
								<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CarrierName'])) ? $partnerMapFields['mappedtitle']['CarrierName']: 'Carrier Name'; ?>: </b></label>
								<?php echo (isset($filesS2CData['CarrierName'])) ? $filesS2CData['CarrierName']: '';?>
								</div><div class="col-lg-6">
								
								<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapFields['mappedtitle']['CarrierTrackingNo']: 'Carrier Tracking No'; ?>: </b></label>
								<?php echo (isset($filesS2CData['CarrierTrackingNo'])) ? $filesS2CData['CarrierTrackingNo']: '';?>
								
								</div><div class="col-lg-6">
								<label><b><?php echo (isset($partnerMapFields['mappedtitle']['MappingCode'])) ? $partnerMapFields['mappedtitle']['MappingCode']: 'Mapping Code'; ?>: </b></label>
								<?php echo (isset($filesS2CData['MappingCode'])) ? $filesS2CData['MappingCode']: '';?>
								
								</div><div class="col-lg-6">
								<label><b><?php echo (isset($partnerMapFields['mappedtitle']['DeliveryDate'])) ? $partnerMapFields['mappedtitle']['DeliveryDate']: 'Delivery Date/Time'; ?>: </b></label>
								<?php echo (isset($filesS2CData['DeliveryDate'])) ?  date('Y-m-d', strtotime($filesS2CData['DeliveryDate'])) : ''; ?>
								<?php echo (isset($filesS2CData['DeliveryTime'])) ?  date('H:i:s', strtotime($filesS2CData['DeliveryTime'])) : ''; ?>
								
								</div><div class="col-lg-6">
								<label><b><?php echo (isset($partnerMapFields['mappedtitle']['DeliverySignature'])) ? $partnerMapFields['mappedtitle']['DeliverySignature']: 'Delivery Signature'; ?>: </b></label>
								<?php echo (isset($filesS2CData['DeliverySignature'])) ? $filesS2CData['DeliverySignature']: '';?>
						
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="panel panel-default">

					 <div class="panel-heading">
					<?= __("Return to Partner") ?>
						<div class="panel-tools pull-right">
						<?php if(!($user_Gateway)){ ?>
							<?php 
								if(empty($filesR2PData)){ 
									echo '<span style="color:red"> <i>( Pending )</i></span>';
								}else{ 
									echo $this->Html->link(__('<span style="color:red"> <i>(Edit)</i></span>'), ['controller' => 'FilesReturned2partner', 'action' => 'edit','?'=>['fmd'=>$recordMainId,'doctype'=>$doctype],'complete'],['title'=>'Edit Return to Partner Details', 'escape'=>false]); 
								}
							?>
						<?php } ?>
						</div>
					</div>
					
					<div class="panel-body">
					<div class="row">
						 <div class="col-lg-12">
							<label><b><?php echo (isset($partnerMapFields['mappedtitle']['RTPProcessingDate'])) ? $partnerMapFields['mappedtitle']['RTPProcessingDate']: 'RTP Processing Date'; ?>: </b></label>
							<?php echo (isset($filesR2PData['RTPProcessingDate'])) ?  date('Y-m-d', strtotime($filesR2PData['RTPProcessingDate'])) : ''; ?><?php echo (isset($filesR2PData['RTPProcessingTime'])) ?  date('H:i:s', strtotime($filesR2PData['RTPProcessingTime'])) : ''; ?>
							<?php echo '<br>'; ?>
							
							<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CarrierName'])) ? $partnerMapFields['mappedtitle']['CarrierName']: 'Carrier Name'; ?>: </b></label>
							<?php echo (isset($filesR2PData['CarrierName'])) ? $filesR2PData['CarrierName']: '';?>
							
							<?php echo '<br>'; ?>
							<label><b><?php echo (isset($partnerMapFields['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapFields['mappedtitle']['CarrierTrackingNo']: 'Carrier Tracking No'; ?>: </b></label>
							<?php echo (isset($filesR2PData['CarrierTrackingNo'])) ? $filesR2PData['CarrierTrackingNo']: '';?>
						</div>
					</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>