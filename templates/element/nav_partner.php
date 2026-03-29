<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">    
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu Partner</span></li>
                 
                <li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-file-upload"></i>Master Search'), ['controller' => 'MasterData','action' => 'masterSearchPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-master', 'escape'=>false]) ?>
                </li>

                <li class="nav-item">
					<?= $this->Html->link('View AOL Template', ['controller' => 'FilesVendorAssignment', 'action' => 'aolindexPartner'], ['class' => 'nav-link','data-key'=>'t-index']) ?>
				</li>
				
                <!--<li class="nav-item">
					<?= $this->Html->link('Record Listing', ['controller' => 'FilesVendorAssignment', 'action' => 'indexPartner'], ['class' => 'nav-link','data-key'=>'t-index']) ?>
				</li>
  
				<li class="nav-item">
                    <?= $this->Html->link(__('<i class="ri-settings-2-line"></i>Receipt of Exam'), ['controller' => 'FilesExamReceipt','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-qc', 'escape'=>false]) ?>
                </li>

				-->
							
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecords" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecords">
                        <i class="ri-account-circle-line"></i> <span data-key="t-records">AOL</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecords">
                        <ul class="nav nav-sm flex-column">
                            
                            <li class="nav-item">
								<?= $this->Html->link('Attorney Reviews', ['controller' => 'reviews', 'action' => 'list'], ['class' => 'nav-link','data-key'=>'t-index']) ?>
                            </li>
                        </ul>
                    </div>
                </li>-->							
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>