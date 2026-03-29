<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $groups
 */
?>
 
 
<?= $this->Form->create($user) ?>

<div class="row">
    <div class="col-lg-12 btm-inline lmb-5"> 
        <div style="display:inline-block;">
            <?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?> 
        </div>  
        <div style="display:inline-block;"> 
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
        </div>  
    </div>
</div>


<div class="card">
    <div class="row">  
        <div class="col-lg-4">
   
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Personal Details</h4> 
            </div> 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Name</label>
                                <?= $this->Form->control('user_name', ['templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Email</label>
                                <?= $this->Form->control('user_email', ['templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <!--<div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Phone</label>
                                <?= $this->Form->control('user_phone', ['templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>-->
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    
    <!--end col-->

        <div class="col-lg-4">
       
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Login Details</h4> 
            </div> 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">User Name</label>
                                <?= $this->Form->control('user_username', ['templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Password</label>
                                <?= $this->Form->control('new_password', ['type' => 'password','templates' => ['inputContainer' => '{{content}}'], 'value' => '' ,'required' => false, 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Confirm Password</label>
                                <?= $this->Form->control('new_confirm_password', ['type' => 'password','templates' => ['inputContainer' => '{{content}}'], 'required' => false, 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    


        <div class="col-lg-4"> 
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Level & Status df</h4> 
            </div> 
           
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <select name="group_id" id="group_id" class="form-control" required>
                                    <option value="">Select Security Level</option>
                                <?php 
                                    foreach($resUG as $group) {

                                        if(!empty($group['ug']['user_id'])) {
                                            $checked = 'selected';
                                        } else {
                                            $checked = '';
                                        }
                                        echo '<option value="'.$group['group_id'].'" '.$checked.'>  '.$group['group_name'].'</option>'; 
                                    } 
                                ?> 
                                </Select>
                                
                            </div>
                        </div>
                        <div class="col-xxl-12 col-md-12">
                            <div class="input-container-floating">
                                <?=  $this->Form->select('user_active',$statusArr,['empty' => 'Select Status','class' =>'form-control', 'required'=>'required', 'label' => false]); ?>
                            </div>
                        </div>
                         
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
     
    </div>  
</div>

    <div class="col-lg-12 btm-inline lmb-5"> 
        <div style="display:inline-block;">
            <?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?> 
        </div>  
        <div style="display:inline-block;"> 
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
        </div>  
    </div>
<?= $this->Form->end() ?>