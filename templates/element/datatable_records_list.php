	<div class="ibox-content">
	  <div>
		<?php if($is_index=='Y'){ ?>
			<?= $this->Form->button(__('Save Accounting Data'), ['name'=>'saveAccount', 'class'=>'btn btn-primary dreceived']) ?>
		<?php }else{
			$iclass = ($user_Gateway) ? 'dreceived': '';
		?>
			<?= $this->Form->button(__('Generate Accounting Sheet'), ['name'=>'accountSheet', 'class'=>'btn btn-primary '.$iclass]) ?>
		<?php }?>
		
	</div>

	<div class="accountList table-responsive">
		 <table class="table dataTable order-column stripe table-striped table-bordered" id="datatable_example" >
		 
			<thead>
				<tr>
					<th><?php echo ($is_index=='Y' || ($user_Gateway)) ? '<input type="checkbox" name="checkedAll" id="checkedAll" />' : 'Sr No.'; ?></th>
					
					<?php if(!$user_Gateway){ ?>
						<th><?= __(isset($partnerMapField['mappedtitle']['NATFileNumber'])? $partnerMapField['mappedtitle']['NATFileNumber']: 'FileNo') ?></th>
					<?php } ?>
					<th><?= __(isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'PartnerFileNumber') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['TransactionType'])? $partnerMapField['mappedtitle']['TransactionType']: 'Document Type') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantors') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['State'])? $partnerMapField['mappedtitle']['State']: 'State') ?></th>

					<th><?= __(isset($partnerMapField['mappedtitle']['ECapable'])? $partnerMapField['mappedtitle']['ECapable']: 'ECapable') ?></th>

					<th><?= __('CntyRecFee') ?></th>

					<th><?= __('Taxes') ?></th>

					<th><?= __('AddnlFees') ?></th>

					<th><?= __('Total') ?></th>

					<th><?= __('ProcessingNote') ?></th>

					<?php if($is_index=='Y' || ($user_Gateway)){
						echo '<th scope="col" class="actions">'.__('Actions').'</th>';
					} ?>
				</tr>
			</thead>
		</table>
	</div>

	<div class="m-t">
		<?php if($is_index=='Y'){ ?>
			<?= $this->Form->button(__('Save Accounting Data'), ['name'=>'saveAccount', 'class'=>'btn btn-primary dreceived']) ?>
		<?php }else{
			 $iclass = ($user_Gateway) ? 'dreceived': '';
		?>
			<?= $this->Form->button(__('Generate Accounting Sheet'), ['name'=>'accountSheet', 'class'=>'btn btn-primary '.$iclass]) ?>
		<?php } ?>
	</div>
	
	<div>&nbsp;<br/></div>
  
	<div>

		<!--- use helper to show Help---->
		<?php if(!empty($partnerMapField['help'])){ 
			echo $this->Lrs->showMappingHelp($partnerMapField['help']);
		 } ?>

	</div>
	
	
</div>