<?php
/**
  * @var \App\View\AppView $this
  */
//  pr($FilesRecordingData);

?>


<div class="card" style="margin-top:15px">
	<?= $this->Form->create($FilesRecordingData, ['type' => 'file','horizontal' => true]) ?>
	<div class="row">
		<div class="col-xxl-4 col-md-4 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<h4><?= __('Recording File for '.$FilesRecordingData['PartnerFileNumber']) ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Recording Entry')?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<?php if($pageType != 'keynoImage'){ ?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['File'])) ? $partnerMapFields['mappedtitle']['File']: 'File') ?></label>
                                <?php echo ((isset($FilesRecordingData->frd['File'])) ? $FilesRecordingData->frd['File'].' ': '') ?>
								
								<?php
									if(!empty($FilesRecordingData->frd['File'])){
										//echo $this->html->link(['<i class="fa fa-file-pdf-o" aria-hidden="true"></i>'],['controller' => 'MasterData','action' => 'viewpdf','?'=>['filename'=>$FilesRecordingData->frd['File']]], ['title'=>'View file', 'target'=>'_blank','escape'=>false]);
									}
								?>							
							</div>
						</div> 
                        <?php 	}  ?>
						
						<?php 
							if(isset($partnerMapFields['fieldsvalsRE'])){
							foreach($partnerMapFields['fieldsvalsRE'] as $fieldsvalsRE) { ?>
								<?php if($fieldsvalsRE['cfm_maptitle'] == 'ExecutedDate'){ ?>
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">	
										<label class="form-label mb-0"><?php echo ((isset($fieldsvalsRE['cfm_maptitle'])) ? $fieldsvalsRE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '') ?></label>
										<?php echo ((isset($FilesRecordingData[$fieldsvalsRE['fm']['fm_title']]))? date('m/d/Y', strtotime($FilesRecordingData[$fieldsvalsRE['fm']['fm_title']])): '') ?>
									</div>
								</div> 
								<?php } else { ?>
								
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">	
										<label class="form-label mb-0"><?php echo ((isset($fieldsvalsRE['cfm_maptitle'])) ? $fieldsvalsRE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '') ?></label>
										<?php echo ((isset($FilesRecordingData[$fieldsvalsRE['fm']['fm_title']]))? $FilesRecordingData[$fieldsvalsRE['fm']['fm_title']]: '') ?>
									</div>
								</div>
							<?php	}	?>
						<?php  } } ?>
						
							
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['RecordingDate'])) ? $partnerMapFields['mappedtitle']['RecordingDate'] : 'RecordingDate') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['RecordingDate'])) ? date('m/d/Y', strtotime($FilesRecordingData->frd['RecordingDate'])): '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['RecordingTime'])) ? $partnerMapFields['mappedtitle']['RecordingTime'] : 'RecordingTime') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['RecordingTime'])) ? date('H:i', strtotime($FilesRecordingData->frd['RecordingTime'])): '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['DocumentNumber'])) ? $partnerMapFields['mappedtitle']['DocumentNumber'] : 'DocumentNumber') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['DocumentNumber'])) ? $FilesRecordingData->frd['DocumentNumber']: '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['Book'])) ? $partnerMapFields['mappedtitle']['Book'] : 'Book') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['Book'])) ? $FilesRecordingData->frd['Book']: '') ?>
							</div>
						</div>
								
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['Page'])) ? $partnerMapFields['mappedtitle']['Page'] : 'Page') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['Page'])) ? $FilesRecordingData->frd['Page']: '') ?>
							</div>
						</div>

						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['EffectiveDate'])) ? $partnerMapFields['mappedtitle']['EffectiveDate'] : 'EffectiveDate') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['EffectiveDate'])) ? date('m/d/Y', strtotime($FilesRecordingData->frd['EffectiveDate'])): '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __('APN/Parcel Number') ?></label>
								<?php echo ((isset($FilesRecordingData['apn_parcel_number'])) ? $FilesRecordingData['apn_parcel_number']: '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __('Legal Description (Short Legal)') ?></label>
								<?php echo ((isset($FilesRecordingData['LegalDescriptionShortLegal'])) ? $FilesRecordingData['LegalDescriptionShortLegal']: '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['RecordingNotes'])) ? $partnerMapFields['mappedtitle']['RecordingNotes'] : 'RecordingNotes') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['RecordingNotes'])) ? $FilesRecordingData->RecordingNotes: '') ?>
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __('Processing Date') ?></label>
								<?php echo ((isset($FilesRecordingData->frd['RecordingProcessingDate'])) ? date('m/d/Y',strtotime($FilesRecordingData->frd['RecordingProcessingDate'])): '') ?>
							</div>
						</div>
								
								
								
					</div>
					<!--end row-->
				</div> 
			</div>
	    </div>
		
		<div class="col-xxl-4 col-md-4 col-sm-12">
			
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Address') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['StreetNumber'])) ? $partnerMapFields['mappedtitle']['StreetNumber'] : 'StreetNumber') ?></label>
                               <?php echo ((isset($FilesRecordingData['StreetNumber'])) ? $FilesRecordingData['StreetNumber'] : '') ?>						
							</div>
						</div> 
                       
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['StreetName'])) ? $partnerMapFields['mappedtitle']['StreetName'] : 'StreetName') ?></label>
								<?php echo ((isset($FilesRecordingData['StreetName'])) ? $FilesRecordingData['StreetName'] : '') ?>				
							</div>
						</div>
					   
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['City'])) ? $partnerMapFields['mappedtitle']['City'] : 'City') ?></label>
								<?php echo ((isset($FilesRecordingData['City'])) ? $FilesRecordingData['City'] : '') ?>		
							</div>
						</div>
						
						
						
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['State'])) ? $partnerMapFields['mappedtitle']['State'] : 'State') ?></label>
								<?php echo ((isset($FilesRecordingData['State'])) ? $FilesRecordingData['State'] : '') ?>
							</div>
						</div>
					 
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapFields['mappedtitle']['County'])) ? $partnerMapFields['mappedtitle']['County'] : 'County' ?></label>
								<?php echo ucfirst(strtolower($FilesRecordingData['County'])); ?>
							</div>
						</div>
					
						
						
						
						
						
					</div>
					<!--end row-->
				</div> 
			</div>
			
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?php if(isset($partnerMapFields['mappedtitle']['Grantors'])) echo $partnerMapFields['mappedtitle']['Grantors']; ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['Grantors'])) ? $partnerMapFields['mappedtitle']['Grantors'] : 'Grantor(s)') ?></label>
								<?php echo ((isset($FilesRecordingData['Grantors'])) ? $FilesRecordingData['Grantors'] : '') ?>
							</div> 
						</div> 
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['GrantorFirstName1'])) ? $partnerMapFields['mappedtitle']['GrantorFirstName1'] : 'First Name (1)') ?></label>
								<?php echo ((isset($FilesRecordingData['GrantorFirstName1'])) ? $FilesRecordingData['GrantorFirstName1'] : '') ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['GrantorFirstName2'])) ? $partnerMapFields['mappedtitle']['GrantorFirstName2'] : 'First Name (2)') ?></label>
								<?php echo ((isset($FilesRecordingData['GrantorFirstName2'])) ? $FilesRecordingData['GrantorFirstName2'] : '') ?>
							</div> 
						</div>
					   
					   <?php
							if(isset($partnerMapFields['fieldsvalsMGR'])){
								foreach($partnerMapFields['fieldsvalsMGR'] as $fieldsvalsMGR){ ?>
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">	
										<label class="form-label mb-0"><?php echo ((isset($fieldsvalsMGR['cfm_maptitle'])) ? $fieldsvalsMGR['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '') ?></label>
										<?php echo ((isset($FilesRecordingData[$fieldsvalsMGR['fm']['fm_title']])) ? $FilesRecordingData[$fieldsvalsMGR['fm']['fm_title']]: '') ?>
									</div> 
								</div>
						<?php } } ?>
						
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?php if(isset($partnerMapFields['mappedtitle']['Grantees'])) echo $partnerMapFields['mappedtitle']['Grantees']; ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['Grantees'])) ? $partnerMapFields['mappedtitle']['Grantees'] : 'Grantees') ?></label>
								<?php echo ((isset($FilesRecordingData['Grantees'])) ? $FilesRecordingData['Grantees'] : '') ?>
							</div> 
						</div> 
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['GranteeFirstName1'])) ? $partnerMapFields['mappedtitle']['GranteeFirstName1'] : 'First Name (1)') ?></label>
								<?php echo ((isset($FilesRecordingData['GranteeFirstName1'])) ? $FilesRecordingData['GranteeFirstName1'] : '') ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['GranteeFirstName2'])) ? $partnerMapFields['mappedtitle']['GranteeFirstName2'] : 'First Name (2)') ?></label>
								<?php echo ((isset($FilesRecordingData['GranteeFirstName2'])) ? $FilesRecordingData['GranteeFirstName2'] : '') ?>
							</div> 
						</div>
						
						
										
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<!-- Mortgagor Grantor(s) -->
			<div class="card-header align-items-center d-flex">
				
				<label class="card-title"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantors'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantors'] : 'Mortgagor Grantor(s)'); ?></label> 
				
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['MortgagorGrantors'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantors'] : 'Grantor(s)') ?></label>
								<?php echo ((isset($FilesRecordingData['MortgagorGrantors'])) ? $FilesRecordingData['MortgagorGrantors'] : '') ?>
							</div> 
						</div> 
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['MortgagorGrantorFirstName1'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantorFirstName1'] : 'First Name (1)') ?></label>
								<?php echo ((isset($FilesRecordingData['MortgagorGrantorFirstName1'])) ? $FilesRecordingData['MortgagorGrantorFirstName1'] : '') ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['MortgagorGrantorFirstName2'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantorFirstName2'] : 'First Name (2)') ?></label>
								<?php echo ((isset($FilesRecordingData['MortgagorGrantorFirstName2'])) ? $FilesRecordingData['MortgagorGrantorFirstName2'] : '') ?>
							</div> 
						</div>
						
						
										
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<!-- Mortgagor Grantor(s) end-->
			
			
			<!-- Mortgagee -->
			<div class="card-header align-items-center d-flex">
				
				<!--<label class="card-title"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantors'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantors'] : 'Mortgagee'); ?></label> -->
				
				<label class="card-title">Mortgagee</label> 
				
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['MortgageeLenderCompanyName'])) ? $partnerMapFields['mappedtitle']['MortgageeLenderCompanyName'] : 'Lender/Company Name') ?></label>
								<?php echo ((isset($FilesRecordingData['MortgageeLenderCompanyName'])) ? $FilesRecordingData['MortgageeLenderCompanyName'] : '') ?>
							</div> 
						</div> 
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['MortgageeFirstName1'])) ? $partnerMapFields['mappedtitle']['MortgageeFirstName1'] : 'First Name (1)') ?></label>
								<?php echo ((isset($FilesRecordingData['MortgageeFirstName1'])) ? $FilesRecordingData['MortgageeFirstName1'] : '') ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['MortgageeFirstName2'])) ? $partnerMapFields['mappedtitle']['MortgageeFirstName2'] : 'First Name (2)') ?></label>
								<?php echo ((isset($FilesRecordingData['MortgageeFirstName2'])) ? $FilesRecordingData['MortgageeFirstName2'] : '') ?>
							</div> 
						</div>
						
						
										
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<!-- Mortgagee  end-->
			
			
	    </div>
		
        <div class="col-xxl-4 col-md-4 col-sm-12"> 
           <div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('File') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['PartnerFileNumber'])) ? $partnerMapFields['mappedtitle']['PartnerFileNumber'] : 'PartnerFileNumber') ?></label>
								<?php echo ((isset($FilesRecordingData['PartnerFileNumber']))?  $FilesRecordingData['PartnerFileNumber']: '') ?>						
							</div>
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['CenterBranch'])) ? $partnerMapFields['mappedtitle']['CenterBranch'] : 'Center/Branch') ?></label>
								<?php echo ((isset($FilesRecordingData['CenterBranch']))?  $FilesRecordingData['CenterBranch']: '') ?>				
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?php echo ((isset($partnerMapFields['mappedtitle']['LoanAmount'])) ? $partnerMapFields['mappedtitle']['LoanAmount'] : 'LoanAmount') ?></label>
								<?php echo ((isset($FilesRecordingData['LoanAmount'])) ? $FilesRecordingData['LoanAmount']: '') ?>
							</div>
						</div>
						<?php 
							$StatusOptions = ['OK'=>'OK','OH'=>'On Hold (Waiting for client response)','HW'=>'On Hold (With walk up resource)','RI'=>'Rejected In Hand','RR'=>'Rejected Returned'];
						?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __('Status') ?></label>
								<?php echo ((isset($FilesRecordingData->fqcd['Status']))?  $StatusOptions[$FilesRecordingData->fqcd['Status']]: '') ?>				
							</div>
						</div>
						
						<?php 
							if(isset($partnerMapFields['fieldsvalsFL'])){
								foreach($partnerMapFields['fieldsvalsFL'] as $fieldsvalFL){ ?>
								
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">	
										<label class="form-label mb-0"><?php echo ((isset($fieldsvalFL['cfm_maptitle'])) ? $fieldsvalFL['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '') ?></label>
										<?php echo ((isset($FilesRecordingData[$fieldsvalFL['fm']['fm_title']]))? $FilesRecordingData[$fieldsvalFL['fm']['fm_title']]: '') ?>			
									</div>
								</div>	
						<?php } } ?>
					</div>
				</div>
			</div>
        </div>
	</div> 
	<!-- row1 close -->
	
	<?php if($layoutShow) { ?>
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<?php
								if(($pageType == 'index') && !empty($FilesRecordingData->frd['RecordingProcessingDate']) && !empty($FilesRecordingData->frd['File'])){
									echo $this->Form->button(__('Recording Confirmation Coversheets'), ['name'=>'coversheetsSave', 'class'=>'btn btn-primary' ,'escape'=>false]);
								}
								?>
								<?php
								//echo $this->Form->button(__('Send Email'), ['name'=>'recordSendEmail', 'class'=>'btn btn-primary m-l' ,'escape'=>false]);
								?>
								<?= $this->Html->link(__('Go back'), $this->request->referer(), ['class'=>'btn btn-danger', 'role'=>'button','escape'=>false]) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- row2 close -->
	<?= $this->Form->end() ?>
</div>