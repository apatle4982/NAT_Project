<?php
/**
  * @var \App\View\AppView $this
  */
 
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<?= $this->Form->create($Statistics, ['horizontal'=>true]) ?>
		<div class="col-lg-12">
			<div class="ibox float-e-margins">

				<!-- Data filter Section -->
				<?php  
					echo $this->element('statisctics_search_template'); 
				?> 
				
				<!-- Records Listing --> 
        <div class="card"> 
					<div class="card-body">
						<div class="live-preview">
            <div class="ibox-content"> 
              <div class="accountList">
                  <table class="table dataTable order-column stripe table-striped table-bordered" id="datatable_example" >
                    <thead>
                      <tr> 
                        <?php 
                          
                          echo $this->Lrs->showTableHeader($datatblHerader,[]);
                        ?> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(!empty($rowData)){ 
                          foreach($rowData as $key=>$row){ $df = (($key == 5)? 5: 4); ?>
                        <tr>
                          <td><?php echo (($key == 101) ? $key.'-Above' : ($key-$df).'-'.$key); ?></td>
                          <td><?php echo $row[0] ?></td>
                          <td><?php echo $row[1] ?></td>
                        </tr>
                          <?php }
                        }else{
                           echo '<tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>';
                        } ?>
                    </tbody>
                  </table>
              </div> 
            </div>
                
            </div>
					</div>
				</div>
				
			</div>
		</div>
		<?= $this->Form->end() ?>
		 
	</div>
</div>