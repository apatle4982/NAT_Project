<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FilesRecordingData $filesRecordingData
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<?= $this->Form->create(null, ['horizontal'=>true]) ?>
			<div class="card-body">
				<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4">
						<div class="row gy-4">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12">
										<div class="input-container-floating ">
											<?php echo $this->Form->radio('field',
														[
															['value' => 'PartnerFileNumber', 'text'=>__('Client Reference Number	')],
															['value' => 'NATFileNumber', 'text' => __('LRS File Number')],
														],
														['value' => isset($field) ? $field : '',
														'class'=>'i-checks'
														]); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label"><b>Partner:</b></label>
										<?= $this->Form->control('company_id', ['type' => 'select', 'label' =>false, 'options' => $companyMsts, 'multiple' => false, 'escape'=>false, 'empty' => 'Select Partner', 'class'=>'form-control'  ]) ?>	
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="card-body">
						<div class="live-preview lrs-frm sml-field search-partner">
							<div class="row gy-4">
								<div class="row gy-4">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="row gy-4">
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating ">
													<table cellpadding="5" cellspacing="5" style="border-spacing:0px;border-collapse: separate;">
														<tr>
															<td width="30" style="border:1px solid #ccc;padding: 2px 10px;"><b>#</b></td>
															<td style="border:1px solid #ccc;padding: 2px 10px;"><b>Enter File #</b></td>
														</tr>
														<?php foreach ($fieldhash as $fieldid){ ?>
														<tr><td width="30" style="border:1px solid #ccc;padding: 2px 10px;"><?php echo $fieldid+1; ?></td><td style="border:1px solid #ccc;padding: 2px 10px;"><input type="text" name="filenumber[]" class="textfieldvsm" value="<?php echo $filenumber[$fieldid]; ?>"></td></tr>
														<?php  } ?>
														<tr>
															<td align="center" colspan="2" style="border:1px solid #ccc;padding: 2px 10px;">
																<input type="submit" name="subExport" class="btn btn-primary m-t" value="Submit" id="btnSubmit" >
															</td>
														</tr>
													</table>
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
			<?= $this->Form->end() ?>
			<!----------Using helper here------------------>
			<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
				<!---Using helper here--->
				<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
			<?php } ?>
			<?php if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
				<!---Using helper here--->
				<?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks, 'confirmation coversheets') ?>
			<?php  } ?>
			<!---------------------------->
		</div>
	</div>
</div>

<?php $this->append('script') ?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#btnSubmit").click(function(){ 
			if(!$('.i-checks:radio').is(':checked')){
				alert("Please Select Client Reference Number/LRS File Number");
				return false;
			}
			if($("#companyid").val() == ''){
				alert("Please select partner.");
				return false;
			}
		})
    });
</script>
<?php $this->end() ?>