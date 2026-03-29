<?php
use Cake\View\Helper;

/**
  * @var \App\View\AppView $this
  */
?>
<style>
	
	select{ background: #FFF !important;}
	.question { margin-bottom: 20px; padding: 5px; border: 1px solid #ccc; border-radius: 8px; }
	.sub-question { margin-left: 20px; margin-top: 2px; }
	.question{ margin-top: 10px; }
	b,strong,.input.textarea label{ font-weight: bold; }
	.remove_border{
		border:none;
		background-color: #e2ddddff !important;
	}
</style>			
<?= $this->Form->create($filesCheckinData, ['horizontal' => true]) ?>

<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
</div>
<!-- NAT File Overview -->
<div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">NAT File Overview
						
					<!-- <span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid #f1702b;border-radius: 12px;padding: 0px 6px;cursor: pointer;background-color: #f1702b; color: #FFF;" onclick="addFieldGroup('open-mortgage')">+</span></h4> --> 
				</div>
			</div>
		</div>
	 <div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">NAT File Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['NATFileNumber']?>" value="<?= $filesCheckinData['NATFileNumber']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Partner File Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['PartnerFileNumber']?>" value="<?= $filesCheckinData['PartnerFileNumber']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Partner Name (ID #)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['comp_mst']['cm_comp_name']?>" value="<?= $filesCheckinData['comp_mst']['cm_comp_name']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">FileStartDate</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['FileStartDate']?>" value="<?= $filesCheckinData['FileStartDate']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Transaction Type</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['document_type']['title']?>" value="<?= $filesCheckinData['document_type']['title']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Purchase Price (Consideration)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['PurchasePriceConsideration']?>" value="<?= $filesCheckinData['PurchasePriceConsideration']?> " disabled="">							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Loan Amount</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['LoanAmount']?>" value="<?= $filesCheckinData['LoanAmount']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Loan Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['LoanNumber']?>" value="<?= $filesCheckinData['LoanNumber']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Street Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['StreetNumber']?>" value="<?= $filesCheckinData['StreetNumber']?> " disabled="">						
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-StreetName label-50">Street Name</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['street_name']?>" value="<?= $filesCheckinData['street_name']?> " disabled="">							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">City</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['City']?>" value="<?= $filesCheckinData['City']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">County</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['County']?>" value="<?= $filesCheckinData['County']?> " disabled="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">State</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['State']?>" value="<?= $filesCheckinData['State']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Zip</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['Zip']?>" value="<?= $filesCheckinData['Zip']?> " disabled="">							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">APN/Parcel Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['APNParcelNumber']?>" value="<?= $filesCheckinData['APNParcelNumber']?> " disabled="">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Legal Description (Short Legal)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['PartnerFileNumber']?>" value="<?= $filesCheckinData['PartnerFileNumber']?> " disabled="">									
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
<!-- NAT File Overview END-->

<!-- Start Party Names -->
 <div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-2 col-md-2 col-sm-2" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Party Names
						
					<?php if($filesCheckinData['Id'] > 0 && $authUser && $authUser->isSuperAdmin_Or_isLimited()) {
						echo $this->Html->link(__(''), ['controller'=>'FilesVendorAssignment','action' => 'edit',$fileVendorAssignment['Id']], ['class' => 'ri-edit-2-line ri-edit-orange-ralign']);
					} ?>	
				</div>
			</div>
		</div>
		<div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
		<!-- Start Grantor(s) -->
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Grantor(s)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['Grantors']?>" value="<?= $filesCheckinData['Grantors']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																			
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">First Name (1)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GrantorFirstName1']?>" value="<?= $filesCheckinData['GrantorFirstName1']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Last Name (1)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GrantorLastName1']?>" value="<?= $filesCheckinData['GrantorLastName1']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">First Name (2)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GrantorFirstName2']?>" value="<?= $filesCheckinData['GrantorFirstName2']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Last Name (2)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GrantorLastName2']?>" value="<?= $filesCheckinData['GrantorLastName2']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Marital Status</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GrantorMaritalStatus']?>" value="<?= $filesCheckinData['GrantorMaritalStatus']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Corporation Name</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GrantorCorporationName']?>" value="<?= $filesCheckinData['GrantorCorporationName']?> " disabled="">							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Grantor(s) -->	

		<div class="card-header align-items-center d-flex"></div>

		<!-- Start Grantee(s) -->
		<div class="row">
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50 label-50 card-title">Grantee(s)</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['Grantees']?>" value="<?= $filesCheckinData['Grantees']?> " disabled="">										
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
																		
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
																	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50">First Name (1)</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GranteeFirstName1']?>" value="<?= $filesCheckinData['GranteeFirstName1']?> " disabled="">									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50">Last Name (1)</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GranteeLastName1']?>" value="<?= $filesCheckinData['GranteeLastName1']?> " disabled="">								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50">First Name (2)</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GranteeFirstName2']?>" value="<?= $filesCheckinData['GranteeFirstName2']?> " disabled="">								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50">Last Name (2)</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GranteeLastName2']?>" value="<?= $filesCheckinData['GranteeLastName2']?> " disabled="">								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50">Marital Status</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GranteeMaritalStatus']?>" value="<?= $filesCheckinData['GranteeMaritalStatus']?> " disabled="">								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
				<div class="card-body" style="padding: 0px 15px 5px !important;">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
								<div class="input-container-floating">										
									<label class="form-label mb-0 label-50">Corporation Name</label>
									<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['GranteeCorporationName']?>" value="<?= $filesCheckinData['GranteeCorporationName']?> " disabled="">							
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Grantee(s) -->

		<div class="card-header align-items-center d-flex"></div>

		<!-- Start Mortgagor -->
		<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Mortgagor</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantors']?>" value="<?= $filesCheckinData['MortgagorGrantors']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																			
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">First Name (1)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorFirstName1']?>" value="<?= $filesCheckinData['MortgagorGrantorFirstName1']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Last Name (1)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorLastName1']?>" value="<?= $filesCheckinData['MortgagorGrantorLastName1']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">First Name (2)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorFirstName2']?>" value="<?= $filesCheckinData['MortgagorGrantorFirstName2']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Last Name (2)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorLastName2']?>" value="<?= $filesCheckinData['MortgagorGrantorLastName2']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Marital Status</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorMaritalStatus']?>" value="<?= $filesCheckinData['MortgagorGrantorMaritalStatus']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Corporation Name</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorCorporationName']?>" value="<?= $filesCheckinData['MortgagorGrantorCorporationName']?> " disabled="">							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Mortgagor -->

		<div class="card-header align-items-center d-flex"></div>

		<!-- Start Mortgagee -->
		<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Mortgagee</label>
																		
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																			
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Lender/Company Name</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgagorGrantorFirstName1']?>" value="<?= $filesCheckinData['MortgagorGrantorFirstName1']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">First Name (1)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgageeFirstName1']?>" value="<?= $filesCheckinData['MortgageeFirstName1']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Last Name (1)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgageeLastName1']?>" value="<?= $filesCheckinData['MortgageeLastName1']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">First Name (2)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgageeFirstName2']?>" value="<?= $filesCheckinData['MortgageeFirstName2']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Last Name (2)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgageeLastName2']?>" value="<?= $filesCheckinData['MortgageeLastName2']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Marital Status</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['MortgageeMaritalStatus']?>" value="<?= $filesCheckinData['MortgageeMaritalStatus']?> " disabled="">							
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Mortgagee -->
		</div>
	</div> 
</div> 
<!-- End Party Name -->

<!-- Start Recording Data -->
<div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Recording Data
						
					<!-- <span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid #f1702b;border-radius: 12px;padding: 0px 6px;cursor: pointer;background-color: #f1702b; color: #FFF;" onclick="addFieldGroup('open-mortgage')">+</span></h4> --> 
				</div>
			</div>
		</div>
	 <div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Recording ProcessingDate</label>
										<input type="text" class="form-control remove_border" title="<?= (isset($filesCheckinData['frd']['RecordingProcessingDate']) ? date('Y-m-d', strtotime($filesCheckinData['frd']['RecordingProcessingDate'])) : '') ?>" value="<?= (isset($filesCheckinData['frd']['RecordingProcessingDate']) ? date('Y-m-d', strtotime($filesCheckinData['frd']['RecordingProcessingDate'])) : '') ?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">RecordingDate</label>
										<input type="text" class="form-control remove_border" title="<?= (isset($filesCheckinData['frd']['RecordingDate']) ? date('Y-m-d', strtotime($filesCheckinData['frd']['RecordingDate'])) : '') ?>" value="<?= (isset($filesCheckinData['frd']['RecordingDate']) ? date('Y-m-d', strtotime($filesCheckinData['frd']['RecordingDate'])) : '') ?>" disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">RecordingTime</label>
										<input type="text" class="form-control remove_border" title="<?= (isset($filesCheckinData['frd']['RecordingTime']) ? date('H:i:s', strtotime($filesCheckinData['frd']['RecordingTime'])) : '') ?>" value="<?= (isset($filesCheckinData['frd']['RecordingTime']) ? date('H:i:s', strtotime($filesCheckinData['frd']['RecordingTime'])) : '') ?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">InstrumentNumber</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['frd']['InstrumentNumber']?>" value="<?= $filesCheckinData['frd']['InstrumentNumber']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Book</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['frd']['Book']?>" value="<?= $filesCheckinData['frd']['Book']?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Page</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['frd']['Page']?>" value="<?= $filesCheckinData['frd']['Page']?> " disabled="">									
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
<!-- End Recording Data-->

<!-- Start Search and Exam Data -->
 <div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-2 col-md-2 col-sm-2" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Search and Exam Data
						<?php if($filesCheckinData['fer']['id'] > 0 && $authUser && $authUser->isSuperAdmin_Or_isLimited()) {
						echo $this->Html->link(__(''), ['controller'=>'FilesExamReceipt','action' => 'exam_receipt',$filesCheckinData['Id']], ['class' => 'ri-edit-2-line ri-edit-orange-ralign']);
					} ?> 
				</div>
			</div>
		</div>
	 <div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
			<div class="row">
				<div class="col-xxl-8 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 card-title">Official Property Address as Titled</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 card-title">File</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Partner</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['comp_mst']['cm_comp_name']?>" value="<?= $filesCheckinData['comp_mst']['cm_comp_name']?> " disabled="">	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Property Address</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['OfficialPropertyAddress']?>" value="<?= $filesCheckinData['fer']['OfficialPropertyAddress']?> " disabled="">	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">NAT File Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['NATFileNumber']?>" value="<?= $filesCheckinData['NATFileNumber']?> " disabled="">	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-header align-items-center d-flex"></div>

			<!-- Start Vesting - Chain of Title Information -->
			 <div class="row">
				<div class="col-xxl-8 col-md-8 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Vesting - Chain of Title Information</label>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Deed Type</label>	
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingDeedType'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingDeedType'] ?? '') ?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Consideration Amount</label>			
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingConsiderationAmount'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingConsiderationAmount'] ?? '') ?> " disabled="">									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Vested As (Grantee)</label>			
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestedAsGrantee'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestedAsGrantee'] ?? '') ?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Grantor</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingGrantor'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingGrantor'] ?? '') ?> " disabled="">													
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Dated</label>		
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingDated'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingDated'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Recorded Date</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingRecordedDate'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingRecordedDate'] ?? '') ?> " disabled="">													
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Book/Page</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingBookPage'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingBookPage'] ?? '') ?> " disabled="">													
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Instrument #</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingInstrument'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingInstrument'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Comments</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingComments'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['vesting_attributes'], true)[0]['VestingComments'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Vesting - Chain of Title Information -->

			<div class="card-header align-items-center d-flex"></div>

			<!-- Start Open Mortgage Information -->
			 <div class="row">
				<div class="col-xxl-8 col-md-8 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Open Mortgage Information</label>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Amount $</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageAmount'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageAmount'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Dated</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageDated'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageDated'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Recorded (Date)</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageRecordedDate'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageRecordedDate'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Book/Page</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageBookPage'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageBookPage'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Instrument #</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageInstrument'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageInstrument'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Borrower (Mortgagor)</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageBorrowerMortgagor'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageBorrowerMortgagor'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Lender (Mortgagee)</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageLenderMortgagee'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageLenderMortgagee'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Trustee 1</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageTrustee1'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageTrustee1'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Trustee 2</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageTrustee2'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageTrustee2'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Comments</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageComments'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_mortgage_attributes'], true)[0]['OpenMortgageComments'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Open Mortgage Information -->

			<div class="card-header align-items-center d-flex"></div>

			<!-- Start Open Judgments & Encumbrances -->
			<div class="row">
				<div class="col-xxl-8 col-md-8 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Open Judgments & Encumbrances</label>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Type</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsType'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsType'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Lien Holder/Plaintiff</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsLienHolderPlaintiff'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsLienHolderPlaintiff'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Borrower/Defendant</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsBorrowerDefendant'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsBorrowerDefendant'] ?? '') ?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Amount $</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsAmount'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsAmount'] ?? '') ?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Date Entered</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsDateEntered'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsDateEntered'] ?? '') ?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Date Recorded</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsDateRecorded'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsDateRecorded'] ?? '') ?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Book/Page</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsBookPage'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsBookPage'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Instrument #</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsInstrument'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsInstrument'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Comments</label>
										<input type="text" class="form-control remove_border" title="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsComments'] ?? '') ?>" value="<?= h(json_decode($filesCheckinData['fer']['open_judgments_attributes'], true)[0]['OpenJudgmentsComments'] ?? '') ?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Open Judgments & Encumbrances -->

			<div class="card-header align-items-center d-flex"></div>

			<!-- Start Tax Status and Assessor Information -->
			<div class="row">
				<div class="col-xxl-8 col-md-8 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Tax Status and Assessor Information</label>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Tax Status</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxStatus']?>" value="<?= $filesCheckinData['fer']['TaxStatus']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Tax Year</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxYear']?>" value="<?= $filesCheckinData['fer']['TaxYear']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Tax Amount</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxAmount']?>" value="<?= $filesCheckinData['fer']['TaxAmount']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Tax Type</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxType']?>" value="<?= $filesCheckinData['fer']['TaxType']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Payment Schedule</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxPaymentSchedule']?>" value="<?= $filesCheckinData['fer']['TaxPaymentSchedule']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Due Date</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxDueDate']?>" value="<?= $filesCheckinData['fer']['TaxDueDate']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Deliquent Date</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxDeliquentDate']?>" value="<?= $filesCheckinData['fer']['TaxDeliquentDate']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Comments</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxComments']?>" value="<?= $filesCheckinData['fer']['TaxComments']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Land Value</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxLandValue']?>" value="<?= $filesCheckinData['fer']['TaxLandValuefer']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Building Value</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxBuildingValue']?>" value="<?= $filesCheckinData['fer']['TaxBuildingValue']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Total Value</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxTotalValue']?>" value="<?= $filesCheckinData['fer']['TaxTotalValue']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">APN/Account #</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxAPNAccount']?>" value="<?= $filesCheckinData['fer']['TaxAPNAccount']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Assessed Year</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxAssessedYear']?>" value="<?= $filesCheckinData['fer']['TaxAssessedYear']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Total Value</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxTotalValue2']?>" value="<?= $filesCheckinData['fer']['TaxTotalValue2']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Municipality/County</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['TaxMunicipalityCounty']?>" value="<?= $filesCheckinData['fer']['TaxMunicipalityCounty']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Tax Status and Assessor Information -->

			<div class="card-header align-items-center d-flex"></div>

			<!-- Start Legal Description -->
			<div class="row">
				<div class="col-xxl-8 col-md-8 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">Legal Description</label>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Legal Description</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['fer']['LegalDescription']?>" value="<?= $filesCheckinData['fer']['LegalDescription']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<!-- End Legal Description -->

			<div class="card-header align-items-center d-flex"></div>

			<!-- Start File -->
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50 card-title">File</label>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">NATFileNumber</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['NATFileNumber']?>" value="<?= $filesCheckinData['NATFileNumber']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Partner File Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['PartnerFileNumber']?>" value="<?= $filesCheckinData['PartnerFileNumber']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">FileStartDate</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['FileStartDate']?>" value="<?= $filesCheckinData['FileStartDate']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Center/Branch</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['CenterBranch']?>" value="<?= $filesCheckinData['CenterBranch']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Loan Amount</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['LoanAmount']?>" value="<?= $filesCheckinData['LoanAmount']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Loan Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['LoanNumber']?>" value="<?= $filesCheckinData['LoanNumber']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Transaction Type</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['document_type']['title']?>" value="<?= $filesCheckinData['document_type']['title']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">StreetNumber</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['StreetNumber']?>" value="<?= $filesCheckinData['StreetNumber']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">StreetName</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['street_name']?>" value="<?= $filesCheckinData['street_name']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">City</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['City']?>" value="<?= $filesCheckinData['City']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">County</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['County']?>" value="<?= $filesCheckinData['County']?> " disabled="">												
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">State</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['State']?>" value="<?= $filesCheckinData['State']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Zip</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['Zip']?>" value="<?= $filesCheckinData['Zip']?> " disabled="">								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">APN/Parcel Number</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['APNParcelNumber']?>" value="<?= $filesCheckinData['APNParcelNumber']?> " disabled="">										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50 label-50">Legal Description(Short Legal)</label>
										<input type="text" class="form-control remove_border" title="<?= $filesCheckinData['PartnerFileNumber']?>" value="<?= $filesCheckinData['PartnerFileNumber']?> " disabled="">											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="input-container-floating">
											<label><strong>Supporting Documentation</strong></label>
                                            <?php //echo "bbbbb<pre>";print_r($filesExamReceiptNew);echo "</pre>";
                                            if (!empty($filesExamReceiptNew['supporting_documentation'])): ?>
                                                <p>Current File:
                                                    <a href="<?= $this->Url->build('/uploads/' . $filesExamReceiptNew['supporting_documentation'], ['fullBase' => true]) ?>" target="_blank">
                                                        <?= h($filesExamReceiptNew['supporting_documentation']) ?>
                                                    </a>

                                            <?php endif; ?>
										</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End File -->
		</div>
	</div> 
</div> 
<!-- End Search and Exam Data --> 

<!-- Start Attorney (AOL) Data --> 
 <?php
	function showAnswer($val) {
		if($val)
		return '<div class="answer"><b>Answer: </b> ' . h($val) . '</div>';
	}
	function showExplanation($val) {
		if($val)
		return !empty($val) ? '<div class="explanation"><b>Explanation: </b>' . h($val) . '</div>' : '';
	}
?>
 <div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-2 col-md-2 col-sm-2" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Attorney (AOL) Data
					<?php if($filesCheckinData['fer']['id'] > 0 && $authUser && $authUser->isSuperAdmin_Or_isLimited()) {
								echo $this->Html->link(__(''), ['controller'=>'Reviews','action' => 'index',$filesCheckinData['Id']], ['class' => 'ri-edit-2-line ri-edit-orange-ralign']);
							} ?>
				</div>
			</div>
		</div>
	 <div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="col-md-6"><strong>NAT File Number:</strong> <?= h($fmd_data['NATFileNumber']) ?></div>
										<div class="col-md-6"><strong>Status:</strong> <?= h($AttorneyReviews->status) ?></div>
										<div class="col-md-6"><strong>Comment:</strong> <?= h($AttorneyReviews->comment) ?></div>
										<div class="col-md-6"><strong>Reviewed By:</strong> <?= h($AttData->vendor) ?></div>
										<div class="col-md-6"><strong>AOL Ordered Date/Time:</strong> <?= h($AolData->pre_aol_date) ?></div>
										<div class="col-md-6"><strong>AOL Received Date/Time:</strong> <?= h($AolData->final_aol_date) ?></div>
										<div class="col-md-6"><strong>Submitted to Client Date/Time:</strong> <?= h($AolData->submit_aol_date) ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>1. Legal Description Match</b></label>
											<div class="sub-question">Does the legal description of the property match the following documents?</div>
											<div class="sub-question"><li> Proposed AOL</li></div>
											<div class="sub-question"><li> Vesting Deed & any proposed Conveyance Deed</li></div>
											<div class="sub-question"><li> Proposed Security Instrument</li></div>
											<div class="sub-question"><li> Title Records (e.g., prior recorded docs)</li></div>
											<div class="sub-question"><li> Property Appraiser search results and/or Tax Certificate</li></div>
											<?= showAnswer($AttorneyReviews->q1) ?>
                    						<?= showExplanation($AttorneyReviews->explain1) ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>2. Ownership Status</b></label>
											<div class="sub-question">According to the Title Records, is the property held in fee simple?</div>
											<?= showAnswer($AttorneyReviews->q2) ?>
                    						<?= showExplanation($AttorneyReviews->explain2) ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>3. Borrower(s) as Individuals</b></label>
											<div class="sub-question">Are all Borrower(s) individuals?</div>
											<?php echo showAnswer($AttorneyReviews->q3) ?>
											<?php //if ($AttorneyReviews->q3 === 'No'): ?>
											<div class="sub-question">
											<label>a. Did the Settlement Agent provide organizational documents of the entity or trust that owns the property, and do these documents allow it to own real property?</label>
											<?php echo showAnswer($AttorneyReviews->q3a) ?>
											<?php echo showExplanation($AttorneyReviews->explain3a) ?>
											</div>
											<div class="sub-question">
											<label>b. Has the entity/trust issued a resolution authorizing an individual to sign the proposed Security Instrument or Conveyance Deed?</label>
											<?php echo showAnswer($AttorneyReviews->q3b) ?>
											<?php echo showExplanation($AttorneyReviews->explain3b) ?>
											</div>
											<?php //endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>4. Security Instrument & AOL Consistency</b></label>
											<div class="sub-question">Do the following match between the proposed Security Instrument and the proposed AOL?</div>
											<div class="sub-question"><li> Loan number</li></div>
											<div class="sub-question"><li> Loan amount</li></div>
											<div class="sub-question"><li> Lender name</li></div>
											<?php echo showAnswer($AttorneyReviews->q4) ?>
											<?php echo showExplanation($AttorneyReviews->explain4) ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>5. Land Boundary Survey</b></label>
											<div class="sub-question">Did the Settlement Agent provide a land boundary survey for the property?</div>
											<?php echo showAnswer($AttorneyReviews->q5) ?>
											<?php if ($AttorneyReviews->q5 === 'Yes'): ?>
											<div class="sub-question">
											<label>a. Have all encroachments, easements, or issues noted on the survey been listed in Exhibit B (Matters of Record) of the proposed AOL?</label>
											<?php echo showAnswer($AttorneyReviews->q5a) ?>
											<?php echo showExplanation($AttorneyReviews->explain5a) ?>
											</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>6. Encumbrances & Title Matters</b></label>
											<div class="sub-question">Does Exhibit B (Matters of Record) in the proposed AOL accurately identify all the following, as shown in the Title Records?</div>
											<div class="sub-question"><li> Encumbrances</li></div>
											<div class="sub-question"><li> Subsurface interests (e.g., mineral rights)</li></div>
											<div class="sub-question"><li> Liens, judgments, CC&Rs, easements, etc.</li></div>
											<div class="sub-question"><li> Any unpaid items not addressed by the payoff statement</li></div>
											<?php echo showAnswer($AttorneyReviews->q6) ?>
											<?php echo showExplanation($AttorneyReviews->explain6) ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<div class="question">
											<label class="card-title"><b>7. Final Approval</b></label>
											<div class="sub-question">After reviewing all of the above, do you approve the issuance of the Attorney Opinion Letter for this transaction?</div>
											<?php echo showAnswer($AttorneyReviews->q7) ?>
											<?php echo showExplanation($AttorneyReviews->explain7) ?>
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
<!-- End Attorney (AOL) Data --> 

<!-- Start Escrow/Closing --> 
 <div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Escrow/Closing
						
					<?php if($filesCheckinData['fer']['id'] > 0 && $authUser && $authUser->isSuperAdmin_Or_isLimited()) {
					//echo $this->Html->link(__(''), ['controller'=>'FilesExamReceipt','action' => 'exam_receipt',$filesCheckinData['Id']], ['class' => 'ri-edit-2-line ri-edit-orange-ralign']);
				} ?>
				</div>
			</div>
		</div>
	 <div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="card-title mb-0 flex-grow-1">Vendor</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
																		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Closing Package Received</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Ok To Close Notification</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Closing Package Submitted Date/Time</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">File Closed</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">Funds Disbursed</label>								
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
<!-- End Escrow/Closing -->

<!-- Start CountyCalc API Estimated Recording Fees --> 
 <div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">CountyCalc API Estimated Recording Fees
						
					<!-- <span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid #f1702b;border-radius: 12px;padding: 0px 6px;cursor: pointer;background-color: #f1702b; color: #FFF;" onclick="addFieldGroup('open-mortgage')">+</span></h4> --> 
				</div>
			</div>
		</div>
	 <div class="open-mortgage-field-group-0 open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">CountyRecordingFeeCC</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">transferTaxCC</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">intangibleMtgTaxCC</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">TaxesCC</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">nonstandardFeeCC</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">walkupAbstractorFeeCC</label>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">AdditionalFeesCC</label>						
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
					<div class="card-body" style="padding: 0px 15px 5px !important;">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									<div class="input-container-floating">										
										<label class="form-label mb-0 label-50">TotalCC</label>						
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
<!-- End CountyCalc API Estimated Recording Fees -->

<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<?= $this->Html->link(__('Cancel'), ['action' => 'masterSearch'], ['class' => 'btn btn-danger']) ?> 					
	</div>
</div>
<!--- use helper to show Help---->
<?= $this->Form->end() ?>
		
<?php $this->end() ?>