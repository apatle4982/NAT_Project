<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
  */
?>
<div class="password-pg">

<div class="row">
    <div class="col-lg-12">
        <div class="card login-inputs">

            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        
                        <div class="col-xxl-12 col-md-12 col-sm-12 login-rgth">
                            <div class="user-ico">
                                <h3><?= __('Reset Password') ?></h3>
                            </div>
                            <?= $this->Form->create($user) ?>
                                 
                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <?= $this->Flash->render() ?>
                                    </div>
                                    <div class="col-xxl-12 col-md-12 col-sm-12"> 
                                        <div class="input-container-floating">  
                                            <?= $this->Form->control('new_password',['label'=>false, 'type' => 'password', 'value'=>'', 'placeholder'=>'New Password', 'class'=>'form-control','required'=>true]) ?>
                                        </div> 
                                    </div> 
                                    <div class="col-xxl-12 col-md-12 col-sm-12"> 
                                        <div class="input-container-floating">  
                                            <?= $this->Form->control('confirm_password',['label'=>false, 'type' => 'password', 'value'=>'', 'placeholder'=>'Confirm Password', 'class'=>'form-control','required'=>true]) ?>
                                        </div> 
                                    </div> 
                                    <div class="col-xxl-12 col-sm-12">
                                        <div class="submit">
                                            <?= $this->Form->button('Submit', ['class'=>'btn btn-success w-100', 'escap'=>false]) ?> 
                                        </div>                        
                                    </div>
                                    <div class="col-xxl-12 col-sm-12">
                                        <?= $this->Html->link('Back to Login', ['controller' => 'users', 'action' => 'login'],['class'=>'text-muted']) ?>
                                    </div>
                                </div>


                            <?= $this->Form->end() ?>
                            <!--end row-->
                        </div>
                        <!------col right---->
                    </div>
                </div>

            </div> 
        </div>
    </div>
</div>
<!--end row-->
</div>