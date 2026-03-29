<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FedexShippingSetting $fedexShippingSetting
 */
?>
 
<div class="row">
	<div class="col-12">
		<div class="page-title d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> 
				<span style="display:block; font-size:14px; text-transform: initial;font-weight: normal;">This section explain the LRS columns for import sheet. The sample CSV file can also be downloaded from this section.
				</span>
				<span style="display:block; font-size:14px; text-transform: initial;font-weight: normal;">Column Format for Import Spread Sheet. To download sample spread sheet. <?= $this->Html->link(__('click here.'),['action' => 'downloadSamplefile']) ?>
				</span>
			</h4>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed" style="width:100%">
					<thead>
						<tr>
							<th><?= __('Column') ?></th>
							<th><?= __('Name') ?></th>
							<th><?= __('Format/Sample') ?></th>		
						</tr>
					</thead>
					<tbody>

						<tr class="odd">
							<td style="padding:4px" ><?= __('A.') ?></td>
							<td style="padding:4px"  align="left"><?= __('CenterBranch') ?></td>
							<td style="padding:4px"  align="left"><?= __('1234') ?></td>
						<tr class="even">
							<td style="padding:4px" ><?= __('B.') ?></td>
							<td style="padding:4px"  align="left"><?= __('LoanAmount') ?></td>
							<td style="padding:4px"  align="left"><?= __('20000') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('C.') ?></td>
							<td style="padding:4px"  align="left"><?= __('FileStartDate') ?></td>
							<td style="padding:4px"  align="left"><?= __('yyyy-mm-dd') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('D.') ?></td>
							<td style="padding:4px"  align="left"><?= __('ClientId') ?></td>
							<td style="padding:4px"  align="left"><?= __('2109') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('E.') ?></td>
							<td style="padding:4px"  align="left"><?= __('NATFileNumber') ?></td>
							<td style="padding:4px"  align="left"><?= __('235443') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('F.') ?></td>
							<td style="padding:4px"  align="left"><?= __('PartnerFileNumber') ?></td>
							<td style="padding:4px"  align="left"><?= __('9039520262') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('G.') ?></td>
							<td style="padding:4px"  align="left"><?= __('Grantors') ?></td>
							<td style="padding:4px"  align="left"><?= __('302') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('H.') ?></td>
							<td style="padding:4px"  align="left"><?= __('GrantorFirstName1 	') ?></td>
							<td style="padding:4px"  align="left"><?= __('Pete') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('I.') ?></td>
							<td style="padding:4px"  align="left"><?= __('Grantees') ?></td>
							<td style="padding:4px"  align="left"><?= __('304') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('J.') ?></td>
							<td style="padding:4px"  align="left"><?= __('GranteeFirstName1') ?></td>
							<td style="padding:4px"  align="left"><?= __('Pete') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('K.') ?></td>
							<td style="padding:4px"  align="left"><?= __('StreetName') ?></td>
							<td style="padding:4px"  align="left"><?= __('CECILIA CT') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('L.') ?></td>
							<td style="padding:4px"  align="left"><?= __('StreetName') ?></td>
							<td style="padding:4px"  align="left"><?= __('23 willa') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('M.') ?></td>
							<td style="padding:4px"  align="left"><?= __('City') ?></td>
							<td style="padding:4px"  align="left"><?= __('WOODBRIDGE') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('N.') ?></td>
							<td style="padding:4px"  align="left"><?= __('State') ?></td>
							<td style="padding:4px"  align="left"><?= __('VA') ?></td>
						</tr>
						<tr class="odd">
							<td style="padding:4px" ><?= __('O.') ?></td>
							<td style="padding:4px"  align="left"><?= __('apn_parcel_number') ?></td>
							<td style="padding:4px"  align="left"><?= __('234654') ?></td>
						</tr>
						<tr class="even">
							<td style="padding:4px" ><?= __('P.') ?></td>
							<td style="padding:4px"  align="left"><?= __('Zip') ?></td>
							<td style="padding:4px"  align="left"><?= __('22191') ?></td>
						</tr>

					</tbody>     
					</table>
				</div>
			</div>
		
		</div>
	</div>
</div>
