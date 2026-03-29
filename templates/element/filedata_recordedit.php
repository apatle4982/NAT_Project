<div class="panel panel-default">
	<div class="panel-heading">
	<?= __('File Data') ?>
	</div>
	<div class="panel-body ">
		<div class="table-responsive">
		<table class="filedatatable table table-bordered">
			<tbody>
				<?php if(!$user_Gateway){ ?>
				<tr>
					<td class=""><?php echo isset($partnerMapField['mappedtitle']['company_id'])? ($partnerMapField['mappedtitle']['company_id'] != 'company_id') ? $partnerMapField['mappedtitle']['company_id']: 'Partner' : 'Partner';?>
					</td>
					<td class="">
					<?= $filesMainData['comp_mst']['cm_comp_name'] ?></td>
				</tr>
				<tr>
					<td class="">
						<?php echo ((isset($partnerMapField['mappedtitle']['NATFileNumber']) && (!empty(trim($partnerMapField['mappedtitle']['NATFileNumber'])))))? $partnerMapField['mappedtitle']['NATFileNumber']: 'NAT File Number'; ?>
					</td>
					<td class="">
						<?= $filesMainData['NATFileNumber'] ?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td class="">
					<?php echo isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'Partner File Number'; ?>
					</td>
					<td class="">
						<?= $filesMainData['PartnerFileNumber'] ?>
					</td>
				</tr>
				
				<tr>
					<td class="">
						<?= __('Center Branch') ?>
					</td>
					<td class="">
						<?= $filesMainData['CenterBranch'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['LoanAmount'])? $partnerMapField['mappedtitle']['LoanAmount']: 'Loan Amount'; ?>
					</td>
					<td class="">
						<?= $filesMainData['LoanAmount'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantor'; ?>
					</td>
					<td class="">
						<?= $filesMainData['Grantors'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['GrantorFirstName1'])? $partnerMapField['mappedtitle']['GrantorFirstName1']: 'Grantor First Name (1)'; ?>
					</td>
					<td class="">
						<?= $filesMainData['GrantorFirstName1'] ?>
					</td>
				</tr>
				
				
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['GrantorFirstName2'])? $partnerMapField['mappedtitle']['GrantorFirstName2']: 'Grantor First Name (2)'; ?>
					</td>
					<td class="">
						<?= $filesMainData['GrantorFirstName2'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['GrantorMaritalStatus'])? $partnerMapField['mappedtitle']['GrantorMaritalStatus']: 'Marital Status'; ?>
					</td>
					<td class="">
						<?= $filesMainData['GrantorMaritalStatus'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['GrantorCorporationName'])? $partnerMapField['mappedtitle']['GrantorCorporationName']: 'Corporation Name'; ?>
					</td>
					<td class="">
						<?= $filesMainData['GrantorCorporationName'] ?>
					</td>
				</tr>
				
				
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['Grantees'])? $partnerMapField['mappedtitle']['Grantees']: 'Grantee'; ?>
					</td>
					<td class="">
						<?= $filesMainData['Grantees'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['GranteeFirstName1'])? $partnerMapField['mappedtitle']['GranteeFirstName1']: 'Grantee First Name 1'; ?>
					</td>
					<td class="">
						<?= $filesMainData['GranteeFirstName1'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['GranteeFirstName2'])? $partnerMapField['mappedtitle']['GranteeFirstName2']: 'Grantee First Name 2'; ?>
					</td>
					<td class="">
						<?= $filesMainData['GranteeFirstName2'] ?>
					</td>
				</tr>
				<!-- Mortgagor Grantor(s) -->
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['MortgagorGrantors'])? $partnerMapField['mappedtitle']['MortgagorGrantors']: 'Mortgagor Grantor'; ?>
					</td>
					<td class="">
						<?= $filesMainData['MortgagorGrantors'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['MortgagorGrantorFirstName1'])? $partnerMapField['mappedtitle']['MortgagorGrantorFirstName1']: 'First Name 1'; ?>
					</td>
					<td class="">
						<?= $filesMainData['MortgagorGrantorFirstName1'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['MortgagorGrantorFirstName2'])? $partnerMapField['mappedtitle']['MortgagorGrantorFirstName2']: 'First Name 2'; ?>
					</td>
					<td class="">
						<?= $filesMainData['MortgagorGrantorFirstName2'] ?>
					</td>
				</tr>
				<!-- Mortgagor Grantor(s) end-->
				
				<!-- Mortgagee Grantor(s) -->
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['MortgageeLenderCompanyName'])? $partnerMapField['mappedtitle']['MortgageeLenderCompanyName']: 'Lender/Company Name'; ?>
					</td>
					<td class="">
						<?= $filesMainData['MortgageeLenderCompanyName'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['MortgageeFirstName1'])? $partnerMapField['mappedtitle']['MortgageeFirstName1']: 'First Name 1'; ?>
					</td>
					<td class="">
						<?= $filesMainData['MortgageeFirstName1'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['MortgageeFirstName2'])? $partnerMapField['mappedtitle']['MortgageeFirstName2']: 'First Name 2'; ?>
					</td>
					<td class="">
						<?= $filesMainData['MortgageeFirstName2'] ?>
					</td>
				</tr>
				<!-- Mortgagor Grantor(s) end-->
				
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['StreetNumber'])? $partnerMapField['mappedtitle']['StreetNumber']: 'Street Number'; ?>
					</td>
					<td class="">
						<?= $filesMainData['StreetNumber'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'Street Name'; ?>
					</td>
					<td class="">
						<?= $filesMainData['StreetName'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['City'])? $partnerMapField['mappedtitle']['City']: 'City'; ?>
					</td>
					<td class="">
						<?= $filesMainData['City'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County'; ?>
					</td>
					<td class="">
						<?= $filesMainData['County'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['State'])? $partnerMapField['mappedtitle']['State']: 'State'; ?>
					</td>
					<td class="">
						<?= $filesMainData['State'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['APNParcelNumber'])? $partnerMapField['mappedtitle']['APNParcelNumber']: 'APN/Parcel Number'; ?>
					</td>
					<td class="">
						<?= $filesMainData['APNParcelNumber'] ?>
					</td>
				</tr>
				<tr>
					<td class="">
						<?php echo isset($partnerMapField['mappedtitle']['LegalDescriptionShortLegal'])? $partnerMapField['mappedtitle']['LegalDescriptionShortLegal']: 'Legal Description (Short Legal)'; ?>
					</td>
					<td class="">
						<?= $filesMainData['LegalDescriptionShortLegal'] ?>
					</td>
				</tr>
			</tbody>
		</table>
		</div>

	</div>
</div>