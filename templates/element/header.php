<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo" style="padding-top: 5px;">
                    <span class="logo-lg">
                        <a href="<?= $this->Url->build('/users/dashboard') ?>"><?=$this->Html->image("tenxlogo-svg.jpg", array("alt" => "LRS", 'style' => 'height: 60px;'))?></a>
                    </span> 
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button> 
                <!-- App Search--> 
            </div>
            
            <div class="head-bottom align-items-center header-center">
                <h3>NATIONAL ATTORNEY TITLE</h3>
            </div>

            <?php if(!empty($LoggedInUsers['user_id']) && $LoggedInUsers['user_id'] !='') {?>
            <div class="d-flex align-items-center">
                <?php if(!$user_Gateway){ ?> 
                    <!--<div class="ms-1 header-item d-none d-sm-flex">
                        <div class="input-container-floating">
                        <?= $this->Form->create(null,['horizontal'=>true]);
                            $sessionVar = $this->request->getSession();  ?> 
                            <label for="basiInput" class="form-label">System Status</label>
                            <?= $this->Form->control('archive', ['value' => ($sessionVar->check('system_status') ? $sessionVar->readOrFail('system_status') : 'Current'), 'options' => ['Current'=>'Current', 'Archive'=>'Archive ( < 2020)'],
                            'label' => False, 'multiple' => false, "onchange"=>"this.form.submit()", 'class'=>'form-select form-select-sm', 'aria-label'=>'.form-select-sm example', 'required'=>false]) ?>
						<?= $this->Form->end(); ?> 
                        </div>
                    </div> -->
                <?php }  ?> 
                 
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center"> 
                       
                            <span class="text-start ms-xl-2 welcome-msg">
                                <i class="ri-account-circle-line"></i>
                              <span class="welcome-user">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">Welcome </span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php echo $LoggedInUsers['user_name']; ?> <?php echo $LoggedInUsers['user_lastname']; ?></span>
                              </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- <div class="input-container-floating sys-status-menu"> 
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" fdprocessedid="evwp6k">
                                <option selected="">Current</option>
                                <option value="1">Archive</option> 
                            </select> 
					    </div> -->

                        <?= $this->Html->link('<i class="mdi mdi-home text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-home">Home</span>', ['controller'=>'users','action' => 'dashboard'], ['class' => 'dropdown-item','escape'=>false]) ?>
                        <?= $this->Html->link('<i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span>', ['controller'=>'users','action' => 'logout'], ['class' => 'dropdown-item','escape'=>false]) ?> 
                     
                    </div>
                </div>
                
            </div>
            <?php }  ?>
        </div>
    </div>
</header> 

                    
