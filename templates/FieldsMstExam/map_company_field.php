<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FieldsMst> $fieldsMst
 */
?>
<?= $this->Form->create($fieldsMsts, ['action'=>'map-company-field']) ?>
<div class="row">
<div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Partner Name</label>
                                <?=  $this->Form->select('cfm_companyid',$companyMsts,['multiple' => false, 'empty' => 'Select Partner','class'=>'js-example-basic-single form-control', 'required'=>'required', 'onchange'=>'this.form.submit()','label' => false]); ?>   
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 btm-inline">
                            <div class="submit">
                            <?= $this->Form->submit(__('Submit'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>  
                            </div> 
                            <div class="cancel"> 
                                <?= $this->Html->link(__('Cancel'),['action'=>'map-company-field'], ['class'=>'btn btn-danger']) ?>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-bordered" style="width:70%">
                    <thead>
                        <tr>
                        <th>NAT Field Names</th>
                        <th>Partner Field Name</th> 
                        <th>Custom Data Field Section</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($fieldsSectionData as $fieldSection):  ?>
                            <tr class="odd map-fld-title">
                                <td colspan="3"><?= h($fieldSection['section_name']) ?></td>
                            </tr>
                             <?php foreach($fieldSection['fields_mst_exam'] as $fieldsMst): ?>
                                <tr>
                                    <td>
                                        <?= $this->Form->control('cfm_fieldid[]', ['label' =>false, 'value'=>$fieldsMst['fm_id'], 'type'=>'hidden', 'class'=>'form-control', 'required'=>'required']) ?>
                                        <?= h($fieldsMst['fm_title'])  ?>
                                    </td>
                                    <td>  
                                        <?php  
                                            if(array_key_exists($fieldsMst['fm_id'],$companyFieldArray)){
                                                echo $this->Form->control('cfm_maptitle[]', ['label' =>false, 'value'=>trim($companyFieldArray[$fieldsMst['fm_id']][1]), 'class'=>'form-control', 'pattern'=>'[A-Za-z0-9 _@.-/$%#()]+', 'title'=>'Only letters, numbers and special character are allowed (_@.-/#).']);
                                                echo $this->Form->control('cfm_id[]', ['label' =>false,'type'=>'hidden', 'value'=>$companyFieldArray[$fieldsMst['fm_id']][0], 'class'=>'form-control']);
                                            }else{

                                                echo $this->Form->control('cfm_maptitle[]', ['label' =>false, 'value'=>'', 'class'=>'form-control', 'pattern'=>'[A-Za-z0-9 _@.-/$%#()]+', 'title'=>'Only letters, numbers and special character are allowed (_@.-/#)']);

                                                echo $this->Form->control('cfm_id[]', ['label' =>false,'type'=>'hidden', 'value'=>'', 'class'=>'form-control']);
                                            }
                                        ?>  
                                    </td>
                                   
                                    <td><?php if($fieldsMst['field_sections_id'] == 8): ?>
                                        <?=  $this->Form->select('cfm_group['.$fieldsMst['fm_id'].']',['File'=>'File','Document'=>'Document','Accounting'=>'Accounting','Submission'=>'Submission','Rejection'=>'Rejection','Recording'=>'Recording','Notes'=>'Notes'],['multiple' => false, 'value'=>(!empty($companyFieldArray[$fieldsMst['fm_id']][2])? $companyFieldArray[$fieldsMst['fm_id']][2] : ''), 'empty' => 'Select Fields Section','class'=>'form-control', 'label' => false]);  ?>
                                      <?php endif; ?>
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
            <div class="submit">
            <?= $this->Form->submit(__('Submit'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>  
            </div> 
            <div class="cancel"> 
                <?= $this->Html->link(__('Cancel'), ['action' => 'map-company-field'], ['class' => 'btn btn-danger']) ?> 
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>