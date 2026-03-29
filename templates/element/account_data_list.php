<div class="ibox-content">
	 
	<div class="accountList">
		 <table class="table dataTable order-column stripe table-striped table-bordered" id="datatable_example" > 
			<thead>
				<tr>
					<th>Sr No.<?php //echo ($is_index=='Y' || ($user_Gateway)) ? '<input type="checkbox" name="checkedAll" id="checkedAll" />' : 'Sr No.'; ?></th>					
					<?php if(!$user_Gateway){ ?>
						<th><?= __(isset($partnerMapField['mappedtitle']['NATFileNumber'])? $partnerMapField['mappedtitle']['NATFileNumber']: 'FileNo') ?></th>
					<?php } ?>
					<th><?= __(isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'PartnerFileNumber') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['TransactionType'])? $partnerMapField['mappedtitle']['TransactionType']: 'Document Type') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantors') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></th>
					<th><?= __(isset($partnerMapField['mappedtitle']['State'])? $partnerMapField['mappedtitle']['State']: 'State') ?></th>
					<!--<th><?= __(isset($partnerMapField['mappedtitle']['ECapable'])? $partnerMapField['mappedtitle']['ECapable']: 'ECapable') ?></th>  -->
					<?php if($is_index=='Y' || ($user_Gateway)){
						echo '<th scope="col" class="actions">'.__('Actions').'</th>';
					} ?>
				</tr>
			</thead>
		</table>
	</div> 
	<div> 
		<?php if(!empty($partnerMapField['help'])){ 
			echo $this->Lrs->showMappingHelp($partnerMapField['help']);
		 } ?> 
	</div>
	 
</div>