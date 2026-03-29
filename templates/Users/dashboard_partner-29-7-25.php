<div class="row">
    <div class="col-xxl-12 col-md-12 col-sm-12">
        <div class="card"> 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row dash-section">
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-search"></i></div>
                                <h2><?php echo $this->Html->link(__('Master Search'), ['controller' => 'master-data', 'action'=>'masterSearchPartner']); ?></h2>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-handshake"></i></div>
                                <h2><?= $this->Html->link('Check In', ['controller' => 'FilesCheckinData', 'action' => 'indexPartner']) ?></h2>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-save"></i></div>
                                <h2><?= $this->Html->link('Rejection', ['controller' => 'FilesQcData', 'action' => 'indexPartner']) ?></h2>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-edit"></i></div>
                                <h2><?= $this->Html->link('Accounting', ['controller' => 'FilesAccountingData', 'action' => 'indexPartner']) ?></h2>
                            </div>
                        </div>
						<div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-shipping-fast"></i></div>
                                <h2><?= $this->Html->link('Shipping', ['controller' => 'FilesShiptoCountyData', 'action' => 'indexPartner']) ?></h2>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-clipboard"></i></div>
                                <h2><?= $this->Html->link('Recording Entry', ['controller' => 'FilesRecordingData', 'action' => 'indexPartner']) ?></h2>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-file-alt"></i><span class="doc"><i class="las la-undo"></i> </span></div>
								<h2><?= $this->Html->link('Returned Docs', ['controller' => 'FilesReturned2partner', 'action' => 'indexPartner']) ?></h2>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-clipboard-check"></i></div>
								<h2><?= $this->Html->link('Completed Orders', ['controller' => 'MasterData', 'action' => 'completeOrderPartner']) ?></h2>
                            </div>
                        </div>
						<div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-clipboard-check"></i></div>
								<h2><?= $this->Html->link('Statistics', ['controller' => 'statistics', 'action' => 'checkinToSubmission']) ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>