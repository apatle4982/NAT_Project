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
                    <?= $this->Html->link(__(' <i class="las la-file-upload"></i>Check In Status'), ['controller' => 'FilesCheckinData','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-checkin', 'escape'=>false]) ?>
                </li>
  
                <li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-record-vinyl"></i>Rejection Status'), ['controller' => 'FilesQcData','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-qc', 'escape'=>false]) ?>
                </li>

                <!--<li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-record-vinyl"></i>Accounting Status'), ['controller' => 'FilesAccountingData','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-accounting', 'escape'=>false]) ?>
                </li>-->
			
				<li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-record-vinyl"></i><span data-key="t-partners">Accounting </span>'), ['controller' => 'FilesAccountingData','action' => 'indexPartner'] , ['class'=>'nav-link menu-link', 'data-bs-toggle'=>'collapse' ,'role'=>'button', 'aria-expanded'=>'false', 'aria-controls'=>'sidebarPartners', 'data-key'=>'t-accounting', 'escape'=>false]) ?>
					<div class="collapse menu-dropdown" id="sidebarRecording">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
							<?= $this->Html->link(__('Accounting Status'), ['controller' => 'FilesAccountingData','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-accounting', 'escape'=>false]) ?>
                            </li>
                            <li class="nav-item">
							<?= $this->Html->link(__('Estimated Fee Sheet'), ['controller' => 'FilesAccountingData','action' => 'estimatedFeeSheetPartner'],['class'=>'nav-link', 'data-key'=>'t-feesheet', 'escape'=>false]) ?> 
                            </li>
                        </ul>
                    </div>
				</li>

                <li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-shipping-fast"></i>Send to County'), ['controller' => 'FilesShiptoCountyData','action' => 'indexPartner'],['class'=>'nav-link menu-link',  'data-key'=>'t-ship', 'escape'=>false]) ?>
                </li> 
 
                <!--<li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-record-vinyl"></i>Recording Status'), ['controller' => 'FilesRecordingData','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-recording', 'escape'=>false]) ?> 	 
                </li>  -->
				
				<li class="nav-item">
					<?= $this->Html->link(__('<i class="las la-record-vinyl"></i><span data-key="t-partners">Recording </span>'), ['controller' => 'FilesRecordingData','action' => 'indexPartner'], ['class'=>'nav-link menu-link', 'data-bs-toggle'=>'collapse' ,'role'=>'button', 'aria-expanded'=>'false', 'aria-controls'=>'sidebarPartners', 'data-key'=>'t-accounting', 'escape'=>false]) ?>
					<div class="collapse menu-dropdown" id="sidebarRecording">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
							<?= $this->Html->link(__('Recording Status'), ['controller' => 'FilesRecordingData','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-accounting', 'escape'=>false]) ?>
                            </li>
                            <li class="nav-item">
							<?= $this->Html->link(__('Return file to partner'), ['controller' => 'FilesReturned2partner','action' => 'indexPartner'],['class'=>'nav-link menu-link', 'data-key'=>'t-return', 'escape'=>false]) ?> 
                            </li>
							<li class="nav-item">
							<?= $this->Html->link(__('Completed Order', true), ['controller' => 'MasterData', 'action' => 'completeOrderPartner'], ['class' => 'nav-link menu-link','data-key'=>'t-complete','escape' => false] ) ?> 
                            </li>
                        </ul>
                    </div>
				</li>
				
				<li class="nav-item">
					<a class="nav-link menu-link" href="#sidebarStatistic" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarStatistic">
                        <i class="ri-account-circle-line"></i><span data-key="t-statistic">Statistics</span>
                    </a>
					<div class="collapse menu-dropdown" id="sidebarRecording">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
							<?= $this->Html->link('Checkin Date to Submission Report', ['controller' => 'Statistics', 'action' => 'checkinToSubmission'], ['class' => 'nav-link']) ?>
                            </li>
                            <li class="nav-item">
							<?= $this->Html->link('Checkin Date to Recording Information', ['controller' => 'Statistics', 'action' => 'checkinToRecording'], ['class' => 'nav-link']) ?>
                            </li>
							<li class="nav-item">
							<?= $this->Html->link('Open Rejected Status', ['controller' => 'Statistics', 'action' => 'OpenRejectedStatus'], ['class' => 'nav-link']) ?>
                            </li>
                        </ul>
                    </div>
				</li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
