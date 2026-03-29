<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPartners" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPartners">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-partners">Partners</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPartners">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
								<?= $this->Html->link('List Partners', ['controller' => 'company-mst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-partnerlisting']) ?>
                            </li> 
                            <li class="nav-item">
                                <?= $this->Html->link('List Partner Users', ['controller' => 'Users', 'action' => 'partnerUser'], ['class' => 'nav-link','data-key'=>'t-userlisting']) ?>
                            </li>
                            <!-- <li class="nav-item">
                                <?php //= $this->Html->link('List Fields', ['controller' => 'FieldsMst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-listfield']) ?>
                             
                            </li> --> 
                            <li class="nav-item">
                                <?= $this->Html->link('Map Partners Fields', ['controller' => 'FieldsMst', 'action' => 'mapCompanyField'], ['class' => 'nav-link','data-key'=>'t-mappartner']) ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Import Sheet Setting', ['controller' => 'FieldsMst', 'action' => 'importCompanyField'], ['class' => 'nav-link','data-key'=>'t-importsheetsetting']) ?>
                            </li> 
							<?php if ($user_group_id == ADMIN_GROUP) { // ADMIN_GROUP = 1 ?>
                            <li class="nav-item">
								<?= $this->Html->link('Export Sheet Setting', ['controller' => 'FieldsMst', 'action' => 'exportCompanyField'], ['class' => 'nav-link','data-key'=>'t-exportsheetsetting']) ?>
                            </li> 
							<?php } ?>
                        </ul>
                    </div>
                </li> 
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecords" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecords">
                        <i class="las la-file-upload"></i> <span data-key="t-records">Records</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecords">
                        <ul class="nav nav-sm flex-column"> 
                            <li class="nav-item">
								<?= $this->Html->link('Upload CSV', ['controller' => 'FilesMainData', 'action' => 'importRecords'], ['class' => 'nav-link','data-key'=>'t-uploadcsv']) ?>
                            </li>
							<li class="nav-item">
								<?= $this->Html->link('Add Record', ['controller' => 'FilesVendorAssignment', 'action' => 'add-records'], ['class' => 'nav-link','data-key'=>'t-add']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Record Listing', ['controller' => 'FilesVendorAssignment', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-index']) ?>
                            </li>
							<li class="nav-item">
								<?= $this->Html->link('Search Record', ['controller' => 'FilesVendorAssignment', 'action' => 'search-records'], ['class' => 'nav-link','data-key'=>'t-search-records']) ?>
                            </li>
                            <!-- <li class="nav-item">
								<?= $this->Html->link('Download Sample Import CSV', ['controller' => 'files-checkin-data', 'action' => 'sample-import'], ['class' => 'nav-link','data-key'=>'t-downloadcsv']) ?>
                            </li> -->
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecords" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecords">
                        <i class="las la-file-upload"></i> <span data-key="t-records">Vendor Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecords">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
								<?= $this->Html->link('Vendors List', ['controller' => 'vendor', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-list']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Add Vendor', ['controller' => 'vendor', 'action' => 'add'], ['class' => 'nav-link','data-key'=>'t-index']) ?>
                            </li>
							<li class="nav-item">
								<?= $this->Html->link('Vendor User List', ['controller' => 'vusers', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-add']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Add Vendor User', ['controller' => 'vusers', 'action' => 'vendor-add'], ['class' => 'nav-link','data-key'=>'t-add']) ?>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecords" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecords">
                        <i class="las la-file-upload"></i> <span data-key="t-records">Masters</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecords">
                        <ul class="nav nav-sm flex-column"> 
                            <li class="nav-item">
								<?= $this->Html->link('Master Search', ['controller' => 'MasterData', 'action' => 'masterSearch'], ['class' => 'nav-link','data-key'=>'t-uploadcsv']) ?>
                            </li>
							
							
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecords" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecords">
                        <i class="las la-file-upload"></i> <span data-key="t-records">Receipt of Exam</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecords">
                        <ul class="nav nav-sm flex-column"> 
                            <li class="nav-item">
                                <?= $this->Html->link('Receipt of Exam', ['controller' => 'FilesExamReceipt', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-receipt']) ?>
                            </li>
                            
                            
                        </ul>
                    </div>
                </li>
				<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecords" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecords">
                        <i class="las la-file-upload"></i> <span data-key="t-records">AOL</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecords">
                        <ul class="nav nav-sm flex-column"> 
                            <li class="nav-item">
								<?= $this->Html->link('Create AOL Template', ['controller' => 'FilesVendorAssignment', 'action' => 'aolindex'], ['class' => 'nav-link','data-key'=>'t-index']) ?>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOpt" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOpt">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-opt">Operations</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOpt">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
								<?= $this->Html->link('Rejection Management', ['controller' => 'FilesQcData', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-rejections']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Accounting Entry', ['controller' => 'FilesAccountingData', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-accountingentry']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Upload Accounting Info (Import Accounting CSV)', ['controller' => 'ImportAccountingInfo', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-ImportAccountingInfo']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Generate Accounting Sheet', ['controller' => 'FilesAccountingData', 'action' => 'accountSheet'], ['class' => 'nav-link','data-key'=>'t-accountingseet']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Estimated Fee Sheet', ['controller' => 'FilesAccountingData', 'action' => 'estimatedFeeSheet'], ['class' => 'nav-link','data-key'=>'t-estimatedfeesheet']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('AF Pending File Estimate Sheet', ['controller' => 'FilesAccountingData', 'action' => 'pendingFileEstimateSheet'], ['class' => 'nav-link','data-key'=>'t-pendingfileestimatesheet']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('CSC Accounting / RecInfo Upload', ['controller' => 'CscAccounting', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-cscaccounting']) ?>
                            </li><li class="nav-item">
								<?= $this->Html->link('Simplifile Accounting / RecInfo Upload', ['controller' => 'SimplifileAccounting', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-simplifileaccounting']) ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Huntington Accounting / RecInfo Upload', ['controller' => 'HuntingtonAccounting', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-huntingtonaccounting']) ?>
                            </li>
                        </ul>
                    </div>
                </li>-->
				
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarShip" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarShip">
                        <i class="las la-shipping-fast"></i> <span data-key="t-ship">Ship to County</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarShip">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
								<?= $this->Html->link('Send to County', ['controller' => 'FilesShiptoCountyData', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-sendtoCounty']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Ship to County eSub upload', ['controller' => 'ImportShippingInfo', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-esub']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Generate Shipping CSV Sheet', ['controller' => 'FilesShiptoCountyData', 'action' => 'generateShippingSheet'], ['class' => 'nav-link','data-key'=>'t-shipsheet']) ?>
                            </li>
                        </ul>
                    </div>
                </li>-->

                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarScanning" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarScanning">
                    <i class="las la-barcode"></i> <span data-key="t-Scanning">Scanning Recognition</span> 
                    </a>
 
                    <div class="collapse menu-dropdown" id="sidebarScanning">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
								<?= $this->Html->link('Scanning Recognition', ['controller' => 'FilesRecordingData', 'action' => 'scanningRecognition'], ['class' => 'nav-link','data-key'=>'t-scann']) ?>
                            </li>
 
                            <li class="nav-item">
								<?= $this->Html->link('Initiate Coversheet', ['controller' => 'FilesRecordingData', 'action' => 'initiateCoversheet'], ['class' => 'nav-link','data-key'=>'t-inCoversheet']) ?>
                            </li>
 
                        </ul>
                    </div>
                </li>-->

                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRecording" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarRecording">
                        <i class="las la-record-vinyl"></i> <span data-key="t-recording">Recording</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRecording">
                        <ul class="nav nav-sm flex-column">
                           
                            <li class="nav-item">
								<?= $this->Html->link('Key With Image', ['controller' => 'FilesRecordingData', 'action' => 'indexNew'], ['class' => 'nav-link','data-key'=>'t-keywithimage']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Research', ['controller' => 'FilesRecordingData', 'action' => 'recordingResearch'], ['class' => 'nav-link','data-key'=>'t-reseach']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Upload Recording Info (Import Recording CSV)', ['controller' => 'ImportRecordingInfo', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-importrecordinginfo']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Generate CSV', ['controller' => 'FilesRecordingData', 'action' => 'recordingCsv'], ['class' => 'nav-link','data-key'=>'t-recordingcsv']) ?> 
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Key No Image', ['controller' => 'FilesRecordingData', 'action' => 'recordingkeyNoImage'], ['class' => 'nav-link','data-key'=>'t-keynoimage']) ?> 
                            </li>
							<li class="nav-item">
								<?= $this->Html->link('Recording Management Report', ['controller' => 'FilesRecordingData', 'action' => 'recordingManagementReport'], ['class' => 'nav-link','data-key'=>'t-recordingManagementReport']) ?> 
                            </li>
							<li class="nav-item">
								<?= $this->Html->link('Generate Recording Confirmation Coversheets', ['controller' => 'FilesRecordingData', 'action' => 'recordingConfirmationCoversheets'], ['class' => 'nav-link','data-key'=>'t-recordingConfirmationCoversheets']) ?>
                            </li>
                            
                            <li class="nav-item"> 
								<?= $this->Html->link('Returned To Partner', ['controller' => 'FilesReturned2partner', 'action' => 'returnPartnerNew'], ['class' => 'nav-link','data-key'=>'t-returntopartnernew']) ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link(__('Completed Order', true), ['controller' => 'MasterData', 'action' => 'completeOrder'], ['class' => 'nav-link','data-key'=>'t-userlisting','escape' => false] ) ?>
                            </li> 
							<li class="nav-item">
								<?= $this->Html->link('Manual Confirmation Coversheets', ['controller' => 'FilesRecordingData', 'action' => 'manualConfirmationCoversheets'], ['class' => 'nav-link','data-key'=>'t-manualConfirmationCoversheets']) ?>
                            </li>
							<li class="nav-item">
								<?= $this->Html->link('New Confirmation Coversheets', ['controller' => 'FilesRecordingData', 'action' => 'newConfirmationCoversheets'], ['class' => 'nav-link','data-key'=>'t-newConfirmationCoversheets']) ?>
                            </li>
                            <li class="nav-item">
								<?= $this->Html->link('Generate Return File Sheet', ['controller' => 'FilesReturned2partner', 'action' => 'generateReturnfileSheet'], ['class' => 'nav-link','data-key'=>'t-generatereturnfilesheet']) ?>
                            </li>
                        </ul>
                    </div> 
                </li>-->
                
				<!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOthers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOthers">
                        <i class="ri-settings-2-line"></i> <span data-key="t-others">Others</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOthers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <?= $this->Html->link('System Users', ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-userlisting']) ?>
                            </li> 
                            <li class="nav-item">
                                <?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'changePassword'], ['class' => 'nav-link']) ?>
                            </li>
							<li class="nav-item">
                                <?= $this->Html->link('Shipping Setting', ['controller' => 'FedexShippingSetting', 'action' => 'index'], ['class' => 'nav-link']) ?>
                            </li>
							<li class="nav-item">
                                <?= $this->Html->link('Banking Detail Charge Type', ['controller' => 'ChargeMaster', 'action' => 'index'], ['class' => 'nav-link']) ?>
                            </li> 
                            <li class="nav-item">
                                <?= $this->Html->link('Document Type Master', ['controller' => 'DocumentTypeMst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-userlisting']) ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('List County', ['controller' => 'CountyMst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-createuser']) ?> 
                            </li> 
							<li class="nav-item">
                                <?= $this->Html->link('County Cal Document Type Master', ['controller' => 'DocumentCountycalMst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-userlisting']) ?>
                            </li>
							<li class="nav-item">
                                <?= $this->Html->link('CSC Document Type Master', ['controller' => 'DocumentCscMst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-userlisting']) ?>
                            </li>
							<li class="nav-item">
                                <?= $this->Html->link('Simplifile Document Type Master', ['controller' => 'DocumentSimplifileMst', 'action' => 'index'], ['class' => 'nav-link','data-key'=>'t-userlisting']) ?>
                            </li> 
                        </ul>
                    </div>
                </li> -->
				
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMasters" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMasters">
                        <i class="ri-account-circle-line"></i><span data-key="t-masters">Masters</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMasters">
                        <ul class="nav nav-sm flex-column">
							<li class="nav-item">
                                <?= $this->Html->link('Master Search', ['controller' => 'MasterData', 'action' => 'master-search'], ['class' => 'nav-link']) ?>
                            </li>
							<li class="nav-item">
                                <?= $this->Html->link('Management Report', ['controller' => 'MasterData', 'action' => 'management-report'], ['class' => 'nav-link']) ?>
                            </li>
                        </ul>
                    </div>
                </li>-->
               
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarStatistic" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarStatistic">
                        <i class="ri-account-circle-line"></i><span data-key="t-statistic">Statistics</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarStatistic">
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