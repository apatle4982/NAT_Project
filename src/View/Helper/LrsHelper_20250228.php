<?php
namespace App\View\Helper;
 
use Cake\View\Helper;

	class LrsHelper extends Helper
	{
		public $helpers = ['Html','Form'];

		public function loadDownloadLink($csvFileName, $folderPath, $title='Generate Documents Sheet'){
			
			/*************Changes for upload/import fedEx mapping page***********************/
			$class = '';
			if($folderPath == 'list-box-danger'){
				$class = 'list-box-danger';
				$folderPath = 'export';
			}
			/*****************************/
			
			$text='';		   
			$text .= '<div class="ibox-content">
						 <div class="panel panel-default '.$class.'">
							 <div class="panel-heading">';
					$text .=  __($title);
					$text .= '</div>
							 <div class="panel-body" style="color: #1a8600; background-color: #eaf9e6;min-height: 45px;"> <div class="col-lg-8">';
							$text .=  __('<i class="las la-download" aria-hidden="true"></i> Success <br>');
							//$text .=  __('<b>'.$csvFileName.'</b> sheet has been generated! ');
							$text .= $this->Html->link('Click here ('.$csvFileName .')',['action' => 'sampleExport','?' =>['filename' => $csvFileName,'folder'=>$folderPath]],['id'=>'exportLink']);
							$text .=  __(' to download the Sheet.');
							$text .=  '</div>
							   </div>
						   </div>
					</div>';
				
			return $text;
		}
	   
	 
		public function searchCancelBtn($class=''){	//$isSearch=false
			$text = '<div class="btn-group pull-right '.$class.'" role="group">';
				$text .= $this->Form->button(__('Search'), ['class'=>'btn btn-primary block m-b','id'=>'searchBtnId']); 
			$text .= '</div>';
			$text .= '<div class="btn-group pull-right mt-2 '.$class.'" role="group">'; 
				$text .= $this->Html->link(__('Clear'), ['action'=>'index'],['class'=>'btn btn-danger flt-rght']); 
			$text .= '</div>';
			return $text;
		}
	   
	 
		public function searchCancelBtnER($class=''){	//$isSearch=false
			$text = '<div class="btn-group pull-right '.$class.'" role="group">';
				$text .= $this->Form->button(__('Search'), ['class'=>'btn btn-primary block m-b','id'=>'searchBtnId']); 
			$text .= '</div>';
			$text .= '<div class="btn-group pull-right mt-2 '.$class.'" role="group">'; 
				$text .= $this->Html->link(__('Clear'), ['action'=>'index'],['class'=>'btn btn-danger flt-rght']);
			$text .= '</div>';
			return $text;
		}

        public function showBarCodeModelPop($vendorlist, $vendor_services){
            /*$vendor_select = '<select name="vendorid" id="vendorDropdown" class="form-control" readonly>
                <option value="">-- Select Vendor --</option>
                <option value="12" selected>Vendor 1</option>
            </select>'*/;

            $vendor_select = $this->Form->select('vendorid',$vendorlist,['empty' => 'Select Vendor','class' =>'js-example-basic-single form-control', 'required'=>'required', 'label' => false]);

		    $vendor_services_html="";
            foreach ($vendor_services as $result) {
                if($result->time == "NA"){ $time="NA"; }else if($result->time == 0){ $time="Same Day"; }else{ $time = $result->time." Hours"; }
                $vendor_services_html .= '<div class="form-group">
                <input type="checkbox" class="form-check-input" id="search_criteria"  name="search_criteria[]" value="'.$result->id.'">
                <label for="service2">'.$result->sub_service.' - '.$time.'</label>
            </div>';
                //echo $result->id . ': ' . $result->sub_service . PHP_EOL;
            }

            $vendor_services_html .='<br><div class="form-group"><b>Delivery Type: </b>
                <input type="radio" class="form-check-input" id="delivery_type"  name="delivery_type" value="email">
                <label for="service2">Email</label>
                <input type="radio" class="form-check-input" id="delivery_type"  name="delivery_type" value="api" disabled>
                <label for="service2">API</label></div>';

            $text = $this->Form->create(null, [
                'url' => [
                    'controller' => 'FilesVendorAssignment',
                    'action' => 'add'
                ],
                'type' => 'post'
            ]);
			$text .= '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Choose Vendor</h4>
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<div id="printSection">
								<div id="printThis">
								</div>
							</div>
							<div id="printThisToo"><b>Available Vendor:</b>
                            '.$vendor_select.'
                            </div>
			<br>
			<lable>Services: </label>
            '.$vendor_services_html.'
						</div>
						<div class="modal-footer">
                            <input id="file_nos" type="hidden" name="RecId" value="">
							'.$this->Form->button(__('Submit')).'<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
							<!--<button type="button" class="btn btn-primary" onclick="PrintElem(\'printSection\');">Submit</button> -->
						</div>
					</div>
				</div>
			</div>';
            $text .= $this->Form->end();
			return $text;
		}

        public function showBarCodeModelPopAtt($vendorlist, $vendor_services){
            /*$vendor_select = '<select name="vendorid" id="vendorDropdown" class="form-control" readonly>
                <option value="">-- Select Attorney --</option>
                <option value="12" selected>Attorney 1</option>
            </select>';*/

            $vendor_select = $this->Form->select('vendorid',$vendorlist,['empty' => 'Select Attorney','class' =>'js-example-basic-single form-control', 'required'=>'required', 'label' => false]);

		    $vendor_services_html="";
            foreach ($vendor_services as $result) {
                if($result->time == "NA"){ $time="NA"; }else if($result->time == 0){ $time="Same Day"; }else{ $time = $result->time." Hours"; }
                $vendor_services_html .= '<div class="form-group">
                <input type="checkbox" class="form-check-input" id="search_criteria"  name="search_criteria[]" value="'.$result->id.'">
                <label for="service2">'.$result->sub_service.' - '.$time.'</label>
            </div>';
                //echo $result->id . ': ' . $result->sub_service . PHP_EOL;
            }

            $vendor_services_html .='<br><div class="form-group"><b>Delivery Type: </b>
                <input type="radio" class="form-check-input" id="delivery_type"  name="delivery_type" value="email">
                <label for="service2">Email</label>
                <input type="radio" class="form-check-input" id="delivery_type"  name="delivery_type" value="api" disabled>
                <label for="service2">API</label></div>';

            $text = $this->Form->create(null, [
                'url' => [
                    'controller' => 'FilesVendorAssignment',
                    'action' => 'attadd'
                ],
                'type' => 'post'
            ]);
			$text .= '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Choose Attorney</h4>
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<div id="printSection">
								<div id="printThis">
								</div>
							</div>
							<div id="printThisToo"><b>Available Attorney:</b>
                            '.$vendor_select.'
                            </div>
			<br>
			<lable>Services: </label>
            '.$vendor_services_html.'
						</div>
						<div class="modal-footer">
                            <input id="file_nos" type="hidden" name="RecId" value="">
							'.$this->Form->button(__('Submit')).'<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
							<!--<button type="button" class="btn btn-primary" onclick="PrintElem(\'printSection\');">Submit</button> -->
						</div>
					</div>
				</div>
			</div>';
            $text .= $this->Form->end();
			return $text;
		}

        public function showBarCodeModelPopEss($vendorlist, $vendor_services){
            /*$vendor_select = '<select name="vendorid" id="vendorDropdown" class="form-control" readonly>
                <option value="">-- Select Escrow Service --</option>
                <option value="12" selected>Escrow Service 1</option>
            </select>';*/

            $vendor_select = $this->Form->select('vendorid',$vendorlist,['empty' => 'Select Escrow Service','class' =>'js-example-basic-single form-control', 'required'=>'required', 'label' => false]);

		    $vendor_services_html="";
            foreach ($vendor_services as $result) {
                if($result->time == "NA"){ $time="NA"; }else if($result->time == 0){ $time="Same Day"; }else{ $time = $result->time." Hours"; }
                $vendor_services_html .= '<div class="form-group">
                <input type="checkbox" class="form-check-input" id="search_criteria"  name="search_criteria[]" value="'.$result->id.'">
                <label for="service2">'.$result->sub_service.' - '.$time.'</label>
            </div>';
                //echo $result->id . ': ' . $result->sub_service . PHP_EOL;
            }

            $vendor_services_html .='<br><div class="form-group"><b>Delivery Type: </b>
                <input type="radio" class="form-check-input" id="delivery_type"  name="delivery_type" value="email">
                <label for="service2">Email</label>
                <input type="radio" class="form-check-input" id="delivery_type"  name="delivery_type" value="api" disabled>
                <label for="service2">API</label></div>';

            $text = $this->Form->create(null, [
                'url' => [
                    'controller' => 'FilesVendorAssignment',
                    'action' => 'essadd'
                ],
                'type' => 'post'
            ]);
			$text .= '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Choose Escrow Service</h4>
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<div id="printSection">
								<div id="printThis">
								</div>
							</div>
							<div id="printThisToo"><b>Available Escrow Service:</b>
                            '.$vendor_select.'
                            </div>
			<br>
			<lable>Services: </label>
            '.$vendor_services_html.'
						</div>
						<div class="modal-footer">
                            <input id="file_nos" type="hidden" name="RecId" value="">
							'.$this->Form->button(__('Submit')).'<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
							<!--<button type="button" class="btn btn-primary" onclick="PrintElem(\'printSection\');">Submit</button> -->
						</div>
					</div>
				</div>
			</div>';
            $text .= $this->Form->end();
			return $text;
		}

		public function showMappingHelp($helpText){
			$text = '<div class="panel panel-default">
						 <div class="panel-heading">'
							.__("Map Field Help").
						 '</div>
						<div class="panel-body">
							<div class="m-l helptext">
								'.$helpText.'
							</div>
						</div>
						</div>';
			return $text;
		}

		public function showTableHeader($datatblHerader, array $partnerMapField, $firstCol='CheckInput')
		{
			$checkval = '';
			$setfld = '';
			$text = '';
			foreach($datatblHerader as $key=>$value) { 
				$text .= '<th>';

				if($key == 'Checkbox') {
					// for report page SrNo
					$text .= ($firstCol !='CheckInput') ? $firstCol : '<input type="checkbox" name="checkedAll" id="checkedAll" />';
				} 
				elseif($key == 'Actions') $text .= 'Actions';
				else{
					$setfld = explode('.',$value);
					if((isset($setfld[1]) && (!empty($setfld[1])))) $checkval = $setfld[1];
					
					//$partnerMapField['mappedtitle']
					$text .= (isset($partnerMapField[$checkval]) && ($checkval != 'TransactionType')) ? $partnerMapField[$checkval]: $key;
				}

				$text .= '</th>';
			}
			return $text;
	    }
		
		public function saveCancelBtn($open='',$section='')
		{
			$text = '<div class="btn-group pull-right" role="group">';
			if(!empty($open)) $text .= $this->Form->button(__('Save and Open Another'), ['name'=>'saveOpenBtn','class'=>'btn btn-success']);
			// do not change "saveBtn" name. this use for multiple page and post condition check
			$text .= $this->Form->button(__('Save'), ['name'=>'saveBtn','class'=>'btn btn-success', 'style'=>'margin-left: 8px;']);
			
			if($section == 'fsad') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesShiptocountyData', 'action' => 'index'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} elseif($section == 'frd') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesRecordingData', 'action' => 'index'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} elseif($section == 'frd-noimg') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesRecordingData', 'action' => 'recordingkeyNoImage'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} elseif($section == 'frd-research') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesRecordingData', 'action' => 'recordingResearch'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} elseif($section == 'fqcd') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesQcData', 'action' => 'index'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} elseif($section == 'fad') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesAccountingData', 'action' => 'index'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} elseif($section == 'rf2p') {
				$text .= $this->Html->link('Cancel', ['controller' => 'FilesReturned2partner', 'action' => 'index'], ['class' => 'btn btn-danger','style'=>'margin-left: 8px;']);
			} else {
			$text .= $this->Form->button(__('Cancel'), ['type'=>'button','onclick'=>'history.go(-1);','class'=>'btn btn-danger','style'=>'margin-left: 8px;']);
			}
			$text .= '</div>';
			return $text;
		}

		public function tooltipRHS($rshId, $statusValue, $idPrifix='sr'){
			
			$text = '';
			if(!empty($statusValue)){
				
				$text .= '<div onmouseover="this.style.cursor=\'pointer\';document.getElementById(\''.$idPrifix.$rshId.'\').style.visibility=\'visible\'" onmouseout="document.getElementById(\''.$idPrifix.$rshId.'\').style.visibility=\'hidden\'">';
				
				$text .= ($idPrifix == 'clrn') ? '<span style="font-weight:bold;">(Note) </span>' : substr($statusValue, 0,25).' ...';

				$text .='</div>';

				$text .= '<div class="toolTip-show" id="'.$idPrifix.$rshId.'" >'.$statusValue.'</div>';
			}
			
			return $text;
		}

		public function showLockModelPop(){
			$text = '<div class="modal fade" id="myModalLock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					 
						<div class="modal-content">

							<div class="modal-header">
								
								<h4 class="modal-title" id="myModalLabel">Lock Record</h4>
								<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body" id="lock-div">
								<div class="col-xxl-12 col-md-12"> 
								'.$this->Form->control('lockChechinId',['type'=>'hidden','id'=>'lockChechinId','value'=>'']).'
								
								'.$this->Form->control('lock_status',['type'=>'hidden','id'=>'lock_status','value'=>'']).'
									 
									<div class="input-container-floating">
										<label for="basiInput" class="form-label"><strong>Reason:</strong></label>
										'.$this->Form->control('lock_comment', ['label' => false,'id'=>'lock_comment','class'=>'form-control', 'style'=>'height:50px;', 'type'=>'textarea', 'required'=>false]).'
									</div>
								</div>
							 
							</div>
							<div class="modal-footer">
								<div class="msg-suceess center"></div>
								<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" onclick="saveLockRecord(\'lock-div\');">Save</button>
							</div>
							
						</div>
					 
					</div>
				</div>'; 
			return $text;
		}
 
		 
		// call from coversheet PDF links and all from generate sheet
		public function pdfcsvDownloadLinks($links, $type = 'CSV sheet'){
			$text = '';
			
			$text .= '<div class="ibox-content">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="las la-file-download" aria-hidden="true"></i> Download: Use below links to download the '.$type.'.
							</div>
							<div class="panel-body pannel-body-scroll">
								<div class="row">
									<div class="col-lg-12 ol-listing">
										<ol class="list-group">
											'.$links.'
										</ol>
									</div>
								</div>
							</div>
						</div>
					</div>';
			return $text;
		}
		
		public function cscTableShow($data, $title, $css="successhearder"){
			$text = '<div class="ibox float-e-margins mt-3">
			<div class="'.$css.'"><h5>'.$title.'</h5></div>
			  <div class="ibox-content">
				  <!-- // downlink for insert --> 
				  <div class="table-responsive"> 
					   '.$data.' 
				  </div>
			  </div>
		  </div>';
		  return $text;
		}
		
		public function showPasswordModelPop(){
			$text = '<div class="modal fade" id="myModalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					 
						<div class="modal-content">

							<div class="modal-header">
								
								<h4 class="modal-title" id="myModalLabel">Delete Record</h4>
								<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							'. $this->Form->create(null, ['action' => 'FilesVendorAssignment/deleteCheckPassword']).'
							<div class="modal-body" id="lock-div">
								<div class="col-xxl-12 col-md-12"> 
									'.$this->Form->control('checkinId',['type'=>'hidden','id'=>'checkinId','value'=>'']).'
								
									<div class="input-container-floating">
										<label for="basiInput" class="form-label"><strong>Enter Delete Password:</strong></label>
										'.$this->Form->control('delpassword', ['label' => false,'id'=>'delpassword','class'=>'form-control',   'required'=>true]).'
									</div>
								</div>
							 
							</div>
							<div class="modal-footer">
								<div class="msg-suceess center"></div>
								<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Delete Confirm</button>
							</div>
							'.$this->Form->end() .'
						</div>
					 
					</div>
				</div>'; 
			return $text;
		}
	}
?>