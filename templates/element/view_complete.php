<div class="col-xxl-12 col-md-12 col-sm-12 ">
	<div class="card">	 	
		<div class="card-body">
			<div class="live-preview ">
				<div class="row">
					<div class="col-xxl-12 col-md-12 col-sm-12">											
						<div class="row">
							<div class="col-xxl-4 col-md-4 col-sm-12 bord-rght">
								<div class="row">
									<div class="col-xxl-6 col-md-6 col-sm-12">
										<div class="row">														
											<div class="col-xxl-12 col-md-12">
												<h2>File / Document Detail</h2>
												<?php if(!$user_Gateway){ ?>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= ($partnerMapFields['mappedtitle']['PartnerID'] == 'PartnerID') ? __('Partner') : $partnerMapFields['mappedtitle']['PartnerID']  ?> :</label>
													<div class="input-value"><?= $filesMainData['CompanyMst']['cm_comp_name'] ?></div> 
												</div>
												
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['NATFileNumber'] ?> :</label>
													<div class="input-value"><?= $filesMainData['NATFileNumber']?></div> 
												</div>
												<?php } ?>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['PartnerFileNumber']?> :</label>
													<div class="input-value"><?= $filesMainData['PartnerFileNumber']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= ($partnerMapFields['mappedtitle']['TransactionType'] == 'TransactionType') ? __('Transaction Type') : $partnerMapFields['mappedtitle']['TransactionType']  ?>:</label>
													<div class="input-value"><?= $filesMainData['DocumentTypeMst']['Title']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= __('Center/Branch') ?> :</label>
													<div class="input-value"><?= $filesMainData['CenterBranch']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['LoanAmount'] ?> :</label>
													<div class="input-value"><?= $filesMainData['LoanAmount']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= __('Document Image') ?> :</label>
													<div class="input-value"><?= $filesMainData['DocumentImage']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= __('APN/Parcel Number') ?> :</label>
													<div class="input-value"><?= $filesMainData['APNParcelNumber']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= __('Legal Description (Short Legal)') ?> :</label>
													<div class="input-value"><?= $filesMainData['LegalDescriptionShortLegal']?></div> 
												</div>
												
												<?php if(isset($partnerMapFields['fieldsvalsFL'])){
												foreach($partnerMapFields['fieldsvalsFL'] as $fieldsvalFL){ ?>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= $fieldsvalFL['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?> :</label>
														<div class="input-value"><?= $filesMainData[$fieldsvalFL['fm']['fm_title']] ?></div>
													</div>
												<?php } } ?>
			
												<!-----------Grantors--------------->
												
												<h2><?= __($partnerMapFields['mappedtitle']['Grantors']) ?></h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['Grantors']?> :</label>
													<div class="input-value"><?= $filesMainData['Grantors']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['GrantorFirstName1']?> :</label>
													<div class="input-value"><?= $filesMainData['GrantorFirstName1']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['GrantorFirstName2']?> :</label>
													<div class="input-value"><?= $filesMainData['GrantorFirstName2']?></div> 
												</div>
												
												<?php
												if(isset($partnerMapFields['fieldsvalsMGR'])){
												foreach($partnerMapFields['fieldsvalsMGR'] as $fieldsvalsMGR){ ?>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= $fieldsvalsMGR['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?> :</label>
														<div class="input-value"><?= $filesMainData[$fieldsvalsMGR['fm']['fm_title']] ?></div>
													</div>
												<?php }
												} ?>
												
												
												<!-----------Grantees--------------->
												
												<h2><?= __($partnerMapFields['mappedtitle']['Grantees']) ?></h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['Grantees']?> :</label>
													<div class="input-value"><?= $filesMainData['Grantees']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['GranteeFirstName1']?> :</label>
													<div class="input-value"><?= $filesMainData['GranteeFirstName1']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['GranteeFirstName2']?> :</label>
													<div class="input-value"><?= $filesMainData['GranteeFirstName2']?></div> 
												</div>
												
												<!-- Mortgagor Grantor(s) -->
												<h2><?= __($partnerMapFields['mappedtitle']['MortgagorGrantors']) ?></h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['MortgagorGrantors']?> :</label>
													<div class="input-value"><?= $filesMainData['MortgagorGrantors']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['MortgagorGrantorFirstName1']?> :</label>
													<div class="input-value"><?= $filesMainData['MortgagorGrantorFirstName1']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['MortgagorGrantorFirstName2']?> :</label>
													<div class="input-value"><?= $filesMainData['MortgagorGrantorFirstName2']?></div> 
												</div>
												<!-- Mortgagor Grantor(s) end-->
												
												<!-- Mortgagee -->
												<h2><?= __($partnerMapFields['mappedtitle']['MortgageeLenderCompanyName']) ?></h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['MortgageeLenderCompanyName']?> :</label>
													<div class="input-value"><?= $filesMainData['MortgageeLenderCompanyName']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['MortgageeFirstName1']?> :</label>
													<div class="input-value"><?= $filesMainData['MortgageeFirstName1']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['MortgageeFirstName2']?> :</label>
													<div class="input-value"><?= $filesMainData['MortgageeFirstName2']?></div> 
												</div>
												<!-- Mortgagee end-->
												
												
												<?php
												if(isset($partnerMapFields['fieldsvalsMGE'])){
												foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= $fieldsvalMGE['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?> :</label>
														<div class="input-value"><?= $filesMainData[$fieldsvalMGE['fm']['fm_title']] ?> </div>
													</div>
												<?php }
												} ?>
												
											</div>
										</div>
									</div>
									<!-----------Address--------------->
									<div class="col-xxl-6 col-md-6 col-sm-12">
										<div class="row">
											<div class="col-xxl-12 col-md-12">
											<h2>Address</h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['StreetNumber']?> :</label>
													<div class="input-value"><?= $filesMainData['StreetNumber']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['StreetName']?> :</label>
													<div class="input-value"><?= $filesMainData['StreetName']?></div> 
												</div>
												
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['City']?> :</label>
													<div class="input-value"><?= $filesMainData['City']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['County']?> :</label>
													<div class="input-value"><?= $filesMainData['County']?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?= $partnerMapFields['mappedtitle']['State']?> :</label>
													<div class="input-value"><?= $filesMainData['State']?></div> 
												</div>
												<!-----------County Detail--------------->
												<!--<div class="output-border">
													<h2>County Details</h2>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= __('City')?> :</label>
														<div class="input-value"><?= (isset($CountyDetails['cm_City'])) ? $CountyDetails['cm_City'] : '' ?></div> 
													</div>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= __('Zip Code')?> :</label>
														<div class="input-value"><?= (isset($CountyDetails['cm_zip'])) ? $CountyDetails['cm_zip'] : ''?></div> 
													</div>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= __('Checks Payable To')?> :</label>
														<div class="input-value"><?= (isset($CountyDetails['cm_payable'])) ? $CountyDetails['cm_payable'] : '' ?></div> 
													</div>
												</div>-->
											</div>
										</div>
									</div>
								</div>
								<!----row end----->
											
								<div class="row">
									<div class="col-xxl-12 col-md-12">
										<h2 style="text-align:right; margin-top:-25px;"><font color="red"><i><b>
										<?php if(!($user_Gateway)){ 
												echo $this->Html->link(__('<span style="color:red"> <i>( Edit )</i></span>'), ['controller' => 'FilesVendorAssigment', 'action' => 'edit',$fileCKData['Id'],"complete"],['title'=>'Edit Partner Details', 'escape'=>false]);
											} ?>
											
											</b></i></font></h2>
									</div>
								</div>
											
								<!--<div class="row">
									<div class="col-xxl-12 col-md-12">
									<h2><?= __("Vendor Data") ?>
										</h2>
									
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['TransactionType'])) ? ($partnerMapFields['mappedtitle']['TransactionType'] == 'TransactionType') ? 'Transaction Type' : $partnerMapFields['mappedtitle']['TransactionType'] : 'Document Type'; ?>  :</label>
											<div class="input-value"><?= $filesMainData['DocumentTypeMst']['Title']?></div> 
										</div>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['DocumentReceived'])) ? $partnerMapFields['mappedtitle']['DocumentReceived']: 'Record Status'; ?> :</label>
											<div class="input-value"><?php echo ($fileCKData['DocumentReceived'] == 'Y') ? 'Document received' : 'Document not received';?></div> 
										</div>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CheckInProcessingDate'])) ? $partnerMapFields['mappedtitle']['CheckInProcessingDate']: 'Added Date'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileCKData['CheckInProcessingDate'])) ?   date('Y-m-d', strtotime($fileCKData['CheckInProcessingDate'])) : '';?></div> 
										</div>
										<div class="input-container-floating output-container">
											<!--------check in document save btn-------$layoutShow for email in user setion only-----
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
										<!--</div>
									</div>
								</div>-->
								<!----row end----->
											
								
							</div>
							<div class="col-xxl-8 col-md-8 col-sm-12">
								<div class="row">
									<div class="col-xxl-12 col-md-12">
										<h2><?= __("Government Fee Accounting") ?><font color="red"><i><b>
										<?php if(!($user_Gateway)){ 
												if(empty($fileACData)){ 
													echo '<span style="color:red"> <i>( Pending )</i></span>';
												}else{ 
													 
													echo $this->Html->link(__('<span style="color:red"> <i>( Edit )</i></span>'), ['controller' => 'FilesAccountingData', 'action' => 'edit',$recordMainId,$doctype,"complete"],['title'=>'Edit Accounting Details','escape'=>false]); 
													
												}
											} ?></b></i></font>
										</h2>
										<div class="row">
											<div class="col-xxl-12 col-md-12 col-xs-12">
													 
													
												<table id="model-datatables" class="table table-bordered nowrap
													align-middle no-footer dtr-inline
													collapsed" style="width: 100%;" aria-describedby="model-datatables_info">
													<thead>
														<tr>
															<th>Data Fields</th>
															<th>CountyCalc Estimated Govt. Fees (API)</th>
															<th>Initial Calculated Government Fees</th>
															<th>Curative Entry</th>
															<th>Final Billed Government fees</th>
														</tr>
													</thead>
													<tbody>
														<tr >
															<th>Jurisdiction Recording Fee</th>
															<td>
																<?php 	echo (isset($fileACData['jrf_cc_fees']) ? $fileACData['jrf_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['jrf_icg_fees']) ? $fileACData['jrf_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['jrf_curative']) ? $fileACData['jrf_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['jrf_final_fees']) ? $fileACData['jrf_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Transfer Tax</th>
															<td>
																<?php 	echo (isset($fileACData['tt_cc_fees']) ? $fileACData['tt_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['tt_icg_fees']) ? $fileACData['tt_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['tt_curative']) ? $fileACData['tt_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['tt_final_fees']) ? $fileACData['tt_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Intangible / Mtg Tax</th>
															<td>
																<?php 	echo (isset($fileACData['it_cc_fees']) ? $fileACData['it_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['it_icg_fees']) ? $fileACData['it_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['it_curative']) ? $fileACData['it_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['it_final_fees']) ? $fileACData['it_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Other Tax</th>
															<td>
																<?php 	echo (isset($fileACData['ot_cc_fees']) ? $fileACData['ot_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['ot_icg_fees']) ? $fileACData['ot_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['ot_curative']) ? $fileACData['ot_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['ot_final_fees']) ? $fileACData['ot_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Nonstandard Fee</th>
															<td>
																<?php 	echo (isset($fileACData['ns_cc_fees']) ? $fileACData['ns_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['ns_icg_fees']) ? $fileACData['ns_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['ns_curative']) ? $fileACData['ns_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['ns_final_fees']) ? $fileACData['ns_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Walkup / Abstractor Fee</th>
															<td>
																<?php echo (isset($fileACData['wu_cc_fees']) ? $fileACData['wu_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['wu_icg_fees']) ? $fileACData['wu_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['wu_curative']) ? $fileACData['wu_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['wu_final_fees']) ? $fileACData['wu_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Other Fees</th>
															<td>
																<?php 	echo (isset($fileACData['of_cc_fees']) ? $fileACData['of_cc_fees']: '200'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['of_icg_fees']) ? $fileACData['of_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['of_curative']) ? $fileACData['of_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['of_final_fees']) ? $fileACData['of_final_fees']: ''); ?> 
															</td>
														</tr>
														<tr >
															<th>Total</th>
															<td>
																<?php 	echo (isset($fileACData['total_cc_fees']) ? $fileACData['total_cc_fees']: '1400'); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['total_icg_fees']) ? $fileACData['total_icg_fees']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['total_curative']) ? $fileACData['total_curative']: ''); ?> 
															</td>
															<td>
															<?php 	echo (isset($fileACData['total_final_fees']) ? $fileACData['total_final_fees']: ''); ?> 
															</td>
														</tr>
													</tbody>
												</table>
											</div>
                                
											<div class="row mt-2 mb-2">
												<div class="col-xxl-6 col-md-6"> 
													<div class="input-container-floating">
														<label for="basiInput" class="form-label" style="width: 160px;"><strong>Check Cleared : </strong></label>
														<div style="width: calc(100% - 160px);"> 
															<?php  
															if(isset($fileACData['total_final_fees']) && ($fileACData['total_final_fees'] == 'Y')){
																echo 'Yes';
															}
															if(isset($fileACData['total_final_fees']) && ($fileACData['total_final_fees'] == 'N')){
																echo 'No';
															}
															?>
														   
														</div>
													</div>
												</div>
											</div> 
										</div>
									</div>
								</div>
								<div class="row">
									<!--<div class="col-xxl-12 col-md-12">
										<h2><?= __("Rejection Management") ?> <font color="red"><i><b>
										<?php if(!($user_Gateway)){ 
												if(empty($fileQcData)){ 
													echo '<span style="color:red"> <i>( Pending )</i></span>';
												}else{ 
													echo $this->Html->link(__('<span style="color:red"> <i>( Edit )</i></span>'), ['controller' => 'FilesQcData', 'action' => 'edit',$recordMainId,$doctype,"complete"],['title'=>'Edit QC/Rejection Details', 'escape'=>false]); 
												}
											} ?></b></i></font>
										</h2>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['Status'])) ? $partnerMapFields['mappedtitle']['Status']: 'PRR Status'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileQcData['Status'])) ? $fileQcData['Status']: '';?></div> 
										</div>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['TrackingNo4RR'])) ? $partnerMapFields['mappedtitle']['TrackingNo4RR']: 'Tracking No (RTP)'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileQcData['TrackingNo4RR'])) ? $fileQcData['TrackingNo4RR']: '';?></div> 
										</div>
										<!--<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CRNStatus'])) ? $partnerMapFields['mappedtitle']['CRNStatus']: 'CRN Status'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileQcData['CRNStatus'])) ? $fileQcData['CRNStatus']: '';?></div> 
										</div>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CRNTrackingNo4RR'])) ? $partnerMapFields['mappedtitle']['CRNTrackingNo4RR']: 'Tracking No RR (CRN)'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileQcData['CRNTrackingNo4RR'])) ? $fileQcData['CRNTrackingNo4RR']: '';?></div> 
										</div>-->
										
										<!--<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['LastModified'])) ? $partnerMapFields['mappedtitle']['LastModified']: 'Last Modified'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileQcData['LastModified'])) ?  date('Y-m-d', strtotime($fileQcData['LastModified'])) : ''; ?></div> 
										</div>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['QCProcessingDate'])) ? $partnerMapFields['mappedtitle']['QCProcessingDate']: 'Processing Date'; ?> :</label>
											<div class="input-value"><?php echo (isset($fileQcData['QCProcessingDate'])) ?  date('Y-m-d', strtotime($fileQcData['QCProcessingDate'])) : ''; ?></div> 
										</div>
										<?php if($layoutShow) { ?>
										<div class="input-container-floating output-container">
											<label for="basiInput" class="form-label"><?= __('Rejection History') ?> :</label>
										</div>
										<?php } ?>
									</div> -->
									<!--<div class="col-xxl-12 col-md-12">
										<?= $this->element('rejection_SH_table')?>
										
									</div>-->
									<div class="col-xxl-12 col-md-12">
										
										<div class="row">
											<!--<div class="col-xxl-4 col-md-4 col-sm-12">
											
												<h2><?= __("Recording Confirmation ") ?> <font color="red"><i><b>
												<?php if(!($user_Gateway)){ 
														if(empty($filesRCData)){ 
															echo '<span style="color:red"> <i>( Pending )</i></span>';
														}else{ 
															echo $this->Html->link(__('<span style="color:red"> <i>( Edit )</i></span>'), ['controller' => 'FilesRecordingData', 'action' => 'edit',$recordMainId,$doctype,'complete'],['title'=>'Edit Recording Details', 'escape'=>false]);
														}
													} ?></b></i></font>
												</h2>
										
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['RecordingProcessingDate'])) ? $partnerMapFields['mappedtitle']['RecordingProcessingDate']: 'Recording Processing Date'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['RecordingProcessingDate'])) ?  date('Y-m-d', strtotime($filesRCData['RecordingProcessingDate'])) : ''; ?></div> 
												</div>
												
												
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['DocumentNumber'])) ? $partnerMapFields['mappedtitle']['DocumentNumber']: 'Document Number'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['DocumentNumber'])) ? $filesRCData['DocumentNumber']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['InstrumentNumber'])) ? $partnerMapFields['mappedtitle']['InstrumentNumber']: 'Instrument Number'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['InstrumentNumber'])) ? $filesRCData['InstrumentNumber']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['RecordingDate'])) ? $partnerMapFields['mappedtitle']['RecordingDate']: 'Recording Date'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['RecordingDate'])) ?  date('Y-m-d', strtotime($filesRCData['RecordingDate'])) : ''; ?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['RecordingTime'])) ? $partnerMapFields['mappedtitle']['RecordingTime']: 'Recording Time'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['RecordingTime'])) ?  date('H:i:s', strtotime($filesRCData['RecordingTime'])) : ''; ?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['Page'])) ? $partnerMapFields['mappedtitle']['Page']: 'Page'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['Page'])) ? $filesRCData['Page']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['Book'])) ? $partnerMapFields['mappedtitle']['Book']: 'Book'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesRCData['Book'])) ? $filesRCData['Book']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['File'])) ? $partnerMapFields['mappedtitle']['File']: 'File'; ?> :</label>
													<div class="input-value">
														<?php   echo (isset($filesRCData['File'])) ? $filesRCData['File'].' ' : '';
														
															if(!empty($filesRCData['File'])){
																echo $this->Html->link(__('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>'), ['controller' => 'MasterData', 'action' => 'viewpdf','?'=>['filename'=>$filesRCData['File']]] ,['title'=>'View file', 'target'=>'_blank', 'escape'=>false]);
															}
														?>
													</div>				
												</div>
												<?php
												if(isset($partnerMapFields['fieldsvalsRE'])){
													foreach($partnerMapFields['fieldsvalsRE'] as $fieldsvalsRE){ ?>
													<div class="input-container-floating output-container">
														<label for="basiInput" class="form-label"><?= $fieldsvalsRE['cfm_maptitle'] ?><?= __('<sup><font color=red size=1><i>1</i></font></sup>')?> :</label>
														<div class="input-value"><?= $filesMainData[$fieldsvalsRE['fm']['fm_title']] ?></div>
													</div>
												<?php }	} ?>
												
												
												<div class="input-container-floating output-container">
												
												<?php 
													if(!empty($filesRCData) && ($layoutShow)){ ?> 
													<?= $this->Form->create() ?>
													
														<?= $this->Form->button(__('Recording Confirmation Coversheets'), ['name'=>'coversheetsSave','class'=>'btn btn-primary']) ?>
														
													<?= $this->Form->end() ?>
												<?php } ?>
												
												</div>
											</div> -->
											<!--<div class="col-xxl-4 col-md-4 col-sm-12">
												<h2><?= __("Document Migration to Recording Jurisdiction") ?> <font color="red"><i><b>
												<?php if(!($user_Gateway)){ 
														if(empty($filesS2CData)){ 
															echo '<span style="color:red"> <i>( Pending )</i></span>';
														}else{ 
															echo $this->Html->link(__('<span style="color:red"> <i>( Edit )</i></span>'), ['controller' => 'FilesShiptoCountyData', 'action' => 'edit',$recordMainId,$doctype,"complete"],['title'=>'Edit Shipping Details', 'escape'=>false]);
														}
													} ?></b></i></font>
												</h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['ShippingProcessingDate'])) ? $partnerMapFields['mappedtitle']['ShippingProcessingDate']: 'Shipping Processing Date'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesS2CData['ShippingProcessingDate'])) ?  date('Y-m-d', strtotime($filesS2CData['ShippingProcessingDate'])) : ''; ?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CarrierName'])) ? $partnerMapFields['mappedtitle']['CarrierName']: 'Carrier Name'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesS2CData['CarrierName'])) ? $filesS2CData['CarrierName']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapFields['mappedtitle']['CarrierTrackingNo']: 'Carrier Tracking No'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesS2CData['CarrierTrackingNo'])) ? $filesS2CData['CarrierTrackingNo']: '';?></div> 
												</div>
												<!--<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['MappingCode'])) ? $partnerMapFields['mappedtitle']['MappingCode']: 'Mapping Code'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesS2CData['MappingCode'])) ? $filesS2CData['MappingCode']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['DeliveryDate'])) ? $partnerMapFields['mappedtitle']['DeliveryDate']: 'Delivery Date/Time'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesS2CData['DeliveryDate'])) ?  date('Y-m-d', strtotime($filesS2CData['DeliveryDate'])) : ''; ?>
													<?php echo (isset($filesS2CData['DeliveryTime'])) ?  date('H:i:s', strtotime($filesS2CData['DeliveryTime'])) : ''; ?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['DeliverySignature'])) ? $partnerMapFields['mappedtitle']['DeliverySignature']: 'Delivery Signature'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesS2CData['DeliverySignature'])) ? $filesS2CData['DeliverySignature']: '';?></div> 
												</div>-->
											<!--</div>-->
											
											<!--<div class="col-xxl-4 col-md-4 col-sm-12">
												
												<h2><?= __("Return to Partner") ?> <font color="red"><i><b>
												<?php if(!($user_Gateway)){  
														if(empty($filesR2PData)){ 
															echo '<span style="color:red"> <i>( Pending )</i></span>';
														}else{ 
															echo $this->Html->link(__('<span style="color:red"> <i>( Edit )</i></span>'), ['controller' => 'FilesReturned2partner', 'action' => 'edit',$recordMainId,$doctype,"complete"],['title'=>'Edit Return to Partner Details', 'escape'=>false]); 
														}
													} ?></b></i></font>
												</h2>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['RTPProcessingDate'])) ? $partnerMapFields['mappedtitle']['RTPProcessingDate']: 'RTP Processing Date'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesR2PData['RTPProcessingDate'])) ?  date('Y-m-d', strtotime($filesR2PData['RTPProcessingDate'])) : ''; ?><?php echo (isset($filesR2PData['RTPProcessingTime'])) ?  date('H:i:s', strtotime($filesR2PData['RTPProcessingTime'])) : ''; ?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CarrierName'])) ? $partnerMapFields['mappedtitle']['CarrierName']: 'Carrier Name'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesR2PData['CarrierName'])) ? $filesR2PData['CarrierName']: '';?></div> 
												</div>
												<div class="input-container-floating output-container">
													<label for="basiInput" class="form-label"><?php echo (isset($partnerMapFields['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapFields['mappedtitle']['CarrierTrackingNo']: 'Carrier Tracking No'; ?> :</label>
													<div class="input-value"><?php echo (isset($filesR2PData['CarrierTrackingNo'])) ? $filesR2PData['CarrierTrackingNo']: '';?></div> 
												</div>
												
											</div>-->
										</div>
									</div>	
									
									
								</div>
							</div>
						</div>
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
				<h2>Partner Specific Fields (A to Q) Data Entry</h2>
			</div>
		</div>
	</div>
</div>