 <div class="ibox-content"> 
	<div class="accountList">
			<table class="table dataTable order-column stripe table-striped table-bordered" id="datatable_example" >
			<thead>
				<tr> 
					<?php 
						$firstCol = (isset($firstCol)) ? $firstCol :'CheckInput';
						echo $this->Lrs->showTableHeader($datatblHerader, $partnerMapField['mappedtitle'],$firstCol);
					?> 
				</tr>
			</thead>
		</table>
	</div> 
</div>