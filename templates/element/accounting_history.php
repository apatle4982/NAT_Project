<table id="model-datatables" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline
	  collapsed" style="width :100%;" aria-describedby="model-datatables_info">
	<thead>
	 <tr>
		<th><?= __('#') ?></th>
		<th><?= __('CountyCalc Estimated Govt. Fees') ?></th>
		<th><?= __('Initial Calculated Government Fees') ?></th>
		<th><?= __('Curative Entry') ?></th>
		<th><?= __('Final Billed Government Fees') ?></th>
        <th><?= __('Date') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
		if(!empty($accountingHistoryData)){
			$accCount = 1; 
			foreach($accountingHistoryData as $accountingData ){
                $unSerData = unserialize($accountingData['serialized_data']);
                //echo "<pre>"; print_r($unSerData);
	?>
		<tr>
			<td><?php echo $accCount; ?></td>
			<td>
                <?php
                    echo "County Recording Fee: <b>".$unSerData['jrf_cc_fees']."</b><br />";
                    echo "Transfer Tax: <b>".$unSerData['tt_cc_fees']."</b><br />";
                    echo "Intangible / Mtg Tax: <b>".$unSerData['it_cc_fees']."</b><br />";
                    echo "Taxes: <b>".$unSerData['ot_cc_fees']."</b><br />";
                    echo "Nonstandard Fee: <b>".$unSerData['ns_cc_fees']."</b><br />";
                    echo "Walkup / Abstractor Fee: <b>".$unSerData['wu_cc_fees']."</b><br />";
                    echo "Additional Fees: <b>".$unSerData['of_cc_fees']."</b><br />";
                    echo "Total: <b>".$unSerData['total_cc_fees']."</b><br />";
                ?>
            </td> 
            <td>
                <?php
                    echo "County Recording Fee: <b>".$unSerData['jrf_icg_fees']."</b><br />";
                    echo "Transfer Tax: <b>".$unSerData['tt_icg_fees']."</b><br />";
                    echo "Intangible / Mtg Tax: <b>".$unSerData['it_icg_fees']."</b><br />";
                    echo "Taxes: <b>".$unSerData['ot_icg_fees']."</b><br />";
                    echo "Nonstandard Fee: <b>".$unSerData['ns_icg_fees']."</b><br />";
                    echo "Walkup / Abstractor Fee: <b>".$unSerData['wu_icg_fees']."</b><br />";
                    echo "Additional Fees: <b>".$unSerData['of_icg_fees']."</b><br />";
                    echo "Total: <b>".$unSerData['total_icg_fees']."</b><br />";
                ?> 
            </td> 
            <td>
                <?php
                    echo "County Recording Fee: <b>".$unSerData['jrf_curative']."</b><br />";
                    echo "Transfer Tax: <b>".$unSerData['tt_curative']."</b><br />";
                    echo "Intangible / Mtg Tax: <b>".$unSerData['it_curative']."</b><br />";
                    echo "Taxes: <b>".$unSerData['ot_curative']."</b><br />";
                    echo "Nonstandard Fee: <b>".$unSerData['ns_curative']."</b><br />";
                    echo "Walkup / Abstractor Fee: <b>".$unSerData['wu_curative']."</b><br />";
                    echo "Additional Fees: <b>".$unSerData['of_curative']."</b><br />";
                    echo "Total: <b>".$unSerData['total_curative']."</b><br />";
                ?>  
            </td> 
            <td>
                <?php
                    echo "County Recording Fee: <b>".$unSerData['jrf_final_fees']."</b><br />";
                    echo "Transfer Tax: <b>".$unSerData['tt_final_fees']."</b><br />";
                    echo "Intangible / Mtg Tax: <b>".$unSerData['it_final_fees']."</b><br />";
                    echo "Taxes: <b>".$unSerData['ot_final_fees']."</b><br />";
                    echo "Nonstandard Fee: <b>".$unSerData['ns_final_fees']."</b><br />";
                    echo "Walkup / Abstractor Fee: <b>".$unSerData['wu_final_fees']."</b><br />";
                    echo "Additional Fees: <b>".$unSerData['of_final_fees']."</b><br />";
                    echo "Total: <b>".$unSerData['total_final_fees']."</b><br />";
                ?> 
            </td> 
			<td><?= date('Y-m-d', strtotime($accountingData['created'])) ?></td>
		</tr>
	<?php
			$accCount++; 
			}
		}else{
			echo '<tr><td colspan="6" align="center"> Records not found</td><tr>';
		}
	?>
	</tbody>
</table>