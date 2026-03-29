<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FieldsMst> $fieldsMst
 */
?>
   
<?= $this->Form->create($fieldsMsts, ['action'=>'import-company-field']) ?>
<div class="row">

<div class="col-lg-12">
        <div class="card">
             
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Partner Name</label>
                                <?=  $this->Form->select('cfm_companyid',$companyMsts,['multiple' => false, 'empty' => 'Select Partner','class'=>'js-example-basic-single form-control', 'required'=>'required', 'onchange'=>'this.form.submit()','label' => false]); ?> 
                            	<?= $this->Form->control('companyImportId', ['label' =>false,'type'=>'hidden', 'value'=>isset($companyImportFields['id'])? $companyImportFields['id']: '', 'class'=>'form-control']); ?>
						
                            </div>
                        </div> 
                        
                        <div class="col-xs-12 col-sm-8 col-md-8 btm-inline">
                            <div style="display:inline-block;">
                            <?= $this->Form->submit(__('Submit'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>  
                            </div> 
                            <div style="display:inline-block;">
                                <?= $this->Html->link(__('Cancel'), ['action' => 'import-company-field'], ['class' => 'btn btn-danger']) ?> 
                            </div>
                        </div>
                        
                         
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" >
    
            <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-bordered" style="width:70%">
                    <thead>
                        <tr>
                        <th><?= __('LRS Field Names') ?></th>
                        <th><?= __('Partner Field Name') ?></th>
                        <th><?= __('Available In Import Sheet') ?></th>
                        </tr>
                    </thead>
                    <tbody> 
                    <?php foreach($fieldsSectionData as $fieldSection):  ?>
                        
                        <tr class="odd map-fld-title"> 
                            <td colspan="3"><?= h($fieldSection['section_name']) ?></td> 
                        </tr>
                            <?php   foreach($fieldSection['fields_mst_exam'] as $fieldsMst): ?>
                        <tr>
                            <td>
                                <?= h($fieldsMst['fm_title'])  ?>
                            </td>
                            <td data-label="<?= __('Partner Field Name') ?>">
                            <?php
                                if(array_key_exists($fieldsMst['fm_id'],$companyFieldArray)){
                                    echo trim($companyFieldArray[$fieldsMst['fm_id']][1]);
                                }else{
                                    echo '';
                                }
                            ?>
                            &nbsp;
                            </td>
                            <td data-label="<?= __('Available In Import Sheet') ?>" style="padding: 0 15px;">
                                <?php
                                    $checked = false;
                                    $readonlyClass = '';
                                    if(array_key_exists('fieldid',$companyImportFields)){
                                        $checked = (in_array( $fieldsMst['fm_id'],$companyImportFields['fieldid'])) ? true: false;
                                    }
                                    $readonly = "";
                                    if($fieldsMst['fm_title'] == 'PartnerFileNumber'){ $checked = true; $readonlyClass = 'readonly-checkbox';}
                                    echo $this->Form->checkbox('cif_fieldid[]', [
                                        'value'   => $fieldsMst['fm_id'],
                                        'checked' => $checked,
                                        'label'   => false,
                                        'class'   => $readonlyClass // Assign class for JavaScript control
                                    ]);
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; 
                    endforeach; ?>

                    </tbody>       
                </table>
                 </div>
            </div>
        </div>

        <div class="col-lg-12 btm-inline"> 
            <div style="display:inline-block;">
            <?= $this->Form->submit(__('Submit'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>  
            </div> 
            <div style="display:inline-block;">
                <?= $this->Html->link(__('Cancel'), ['action' => 'import-company-field'], ['class' => 'btn btn-danger']) ?> 
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".readonly-checkbox").forEach(function(checkbox) {
            checkbox.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent changes
            });
        });
    });
</script>