<table id="model-datatables" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline
	  collapsed" style="width : 100%;" aria-describedby="model-datatables_info">
	<thead>
	 <tr>
		<th><?= __('#') ?></th>
		<th><?= __('Status') ?></th>
		<th><?= __('Rejection Reason') ?></th>
		<th><?= __('Tracking No (RTP)') ?></th>
		<th><?= __('Date') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
		if(!empty($rejectionSHData)){
			$rejectSHCount = 1; 
			foreach($rejectionSHData as $rejStatusHistory ){
	?>
		<tr style="color:<?php echo ($rejStatusHistory['Type'] =='OK') ? 'green': 'red';?>;">
			<td><?php if(isset($is_check)){ ?>
				<input class="checkSingle" type="checkbox" name="rejectedState[]" id="rejectedState[]" value="<?= $rejStatusHistory['rshId'] ?>">
			<?php }else{ echo $rejectSHCount; }?></td>
			<td><?= $rejStatusHistory['Type'] ?></td>
			<td><?= $this->Lrs->tooltipRHS($rejStatusHistory['rshId'], $rejStatusHistory['StatusReason'], 'sr');?></td>
			<td><?= $this->Lrs->tooltipRHS($rejStatusHistory['rshId'], $rejStatusHistory['StatusNote'], 'sn');?> 
			</td> 
			<td><?= date('m-d-Y', strtotime($rejStatusHistory['LastModified'])) ?></td>
		</tr>
	<?php
			$rejectSHCount++; 
			}
		}else{
			echo '<tr><td colspan="5"> Records not found</td><tr>';
		}
	?>
	</tbody>
</table>