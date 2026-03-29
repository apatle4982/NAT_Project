<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CountyMst Controller
 *
 * @property \App\Model\Table\CountyMstTable $CountyMst
 * @method \App\Model\Entity\CountyMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountyMstController extends AppController
{ 

	private $columns_alise = [
        'SrNo'=> 'cm_id',
        "State" => 'cm_State',
        "County" =>'cm_title',
        /* "VendorClassID" =>'cm_vendor_class_id', */
        "Code" =>'cm_code', 
        /* "TownshipDivision" =>'cm_township_division', */ 
        "Availability" =>'file_avl',
        "E_Capable" =>'cm_file_enabled',
        "RecordingInfoImageAvailability" =>'rec_info_avl',
        "WebsiteURL" =>'cm_link',
        /* "Applicable Forms"=>'', */
        "DateModified" => 'date_modified',
        "Actions" => ''
     ];    
      
	private $columnHeaders = ['County Title', 'County Code','State',  'E-File Enabled','All Document types', 'Recording Information Availabile','Link', 'Date Created'];
	private $columns = array(0=>'SrNo',1=>'cm_State',2=>'cm_title',3=>'cm_code',4=>'file_avl',5=>'cm_file_enabled',6=>'rec_info_avl',7=>'cm_link', 8=>'date_modified');  
  
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event); 
		$this->loginAccess();
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function index()
    {
        // set page title
        $pageTitle = 'County Listing';
        $this->set(compact('pageTitle'));
 
		$CountyMst = $this->CountyMst->newEmptyEntity();
		if($this->user_Gateway){ $this->removeColumn(); }
		// step for datatable config : 3
		$this->set('dataJson',$this->CustomPagination->setDataJson($this->columns_alise,['Actions']));
		// step for datatable config : 4
		$isSearch = 0;
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->getData();
			$isSearch = 1;
		}
		$this->set('formpostdata', $formpostdata);
	
		//end step
		$this->set('isSearch', $isSearch);

		//$StateList = $this->CountyMst->StateListArray();
		$this->loadModel('States');
		$StateList = $this->States->StateListArray();
		
        $this->set(compact('CountyMst','StateList'));
        $this->set('_serialize', ['CountyMst']); 

    }
	
	public function removeColumn(){
		unset($this->columns_alise['Vendor Class ID'], $this->columns_alise['Code'], $this->columns_alise['E_Capable'], $this->columns_alise['Availability'], $this->columns_alise['Recording Info & Image Availability'], $this->columns_alise['Website URL']);
		unset($this->columns[3],$this->columns[4],$this->columns[6],$this->columns[7],$this->columns[8]);
		array_splice($this->columns,9,1); // 1-> key number, 1->count
	}
	// step for datatable config : 5 main step
	public function ajaxListIndex()
    {
		$modelname = $this->name;
        $this->autoRender = false;
      
		//remove/pop extra fields 
		array_pop($this->columns_alise);

		$this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
													 'columns'=>$this->columns, 
													 'columnAlise'=>$this->columns_alise,
													 'modelName'=>$modelname
													]);
		$pdata = $this->CustomPagination->getQueryData();
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		
		$query = $this->$modelname->find('search', $pdata['condition']);
	 
		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find()->count();
		}else{
			// remove limit from condition
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('search', $pdata['condition'])->count();
		}
	 
        $results = $query->order(['cm_id'=>'desc'])->all();
        $data = $results->toArray();
		 
		// customise as per condition for differant datatable use.
		$data = $this->getCustomParshingData($data);
  //pr($data);exit;
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );
		
        echo json_encode($response); 
        exit;
    }
	
	// step for datatable config : 6 custome data action
	private function getCustomParshingData(array $data){
		// manual
         
        foreach ($data as $key => $value) { 

            $E_Capable = ['1'=>'CSC', '2'=>'SF', '3'=>'CSC / SF'];
            $value['E_Capable'] = (!empty($value['E_Capable']) ? (isset($E_Capable[$value['E_Capable']]) ? $E_Capable[$value['E_Capable']]: "") : '') ;

            $RecordingInfoImageAvailability =['imagesNoCost'=>'Rec Info & Images No Cost', 'NoimageNocost'=>'Rec Info No Images No Cost', 'fbr'=>'Fee Based Research'];
            
            $value['RecordingInfoImageAvailability'] =  (!empty($RecordingInfoImageAvailability[$value['RecordingInfoImageAvailability']]) ? $RecordingInfoImageAvailability[$value['RecordingInfoImageAvailability']] : '');
            
           // $value['E_Capable'] = ($value['E_Capable'] == "Y") ? '<span style="color:green;">'.$value['E_Capable'].'</span>': "";
			//$value['Applicable Forms'] = $this->getApplicableForm($value['SrNo']);
 
			if($this->user_Gateway){ 
				$value['Actions'] = $this->CustomPagination->getUserActionButtons($this->name, $value, ['SrNo'], 'County');
			}else{               
				$value['Actions'] = $this->CustomPagination->getActionButtons($this->name,$value,['SrNo','County']);
			}
        
			if($value['WebsiteURL'] !=""){				
				$link_replace = $this->getLink($value['WebsiteURL']);
				if(strlen($link_replace)>20)
					$value['WebsiteURL'] = '<a href="http://'.$value['WebsiteURL'].'" target="_blank" title="'.$value['County'].'">'.substr($link_replace,0,20).' </a>';
				else
 
					$value['WebsiteURL'] = '<a href="http://'.$value['WebsiteURL'].'" target="_blank" title="'.$value['County'].'">'.$link_replace.'</a>';

			} 
 
        }
		return $data;
	}

    /**
     * View method
     *
     * @param string|null $id County Mst id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $CountyMst = $this->CountyMst->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('CountyMst'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $CountyMst = $this->CountyMst->newEmptyEntity();
        if ($this->request->is('post')) {
            $Countydata = $this->request->getData();
 
           //  $Countydata = $this->setExtraValue($Countydata);
 
            $Countydata['date_created'] = date('Y-m-d');
            $Countydata['date_modified'] = date('Y-m-d');
            $CountyMst = $this->CountyMst->patchEntity($CountyMst, $Countydata); 
            if ($this->CountyMst->save($CountyMst)) {
                $this->Flash->success(__('The County has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The County could not be saved. Please, try again.'));
        }

        		$this->loadModel('States');
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		$this->set('pageTitle', 'Add County');
        $this->set(compact('CountyMst'));
    }

    /**
     * Edit method
     *
     * @param string|null $id County Mst id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $CountyMst = $this->CountyMst->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Countydata = $this->request->getData();
            //$Countydata = $this->setExtraValue($Countydata);
            $CountyMst = $this->CountyMst->patchEntity($CountyMst, $Countydata);
            if ($this->CountyMst->save($CountyMst)) {
                $this->Flash->success(__('The County has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The County could not be saved. Please, try again.'));
        }

        $this->loadModel('States');
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);

		$this->set('pageTitle', 'Update County');
        $this->set(compact('CountyMst'));
    }

    /**
     * Delete method
     *
     * @param string|null $id County Mst id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $CountyMst = $this->CountyMst->get($id);
        if ($this->CountyMst->delete($CountyMst)) {
            $this->Flash->success(__('The County has been deleted.'));
        } else {
            $this->Flash->error(__('The County could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	 
	public function export() {
        $this->response->withDownload('export.csv');
        $data = $this->CountyMst->find('all',['fields'=>[ "cm_title", "cm_code","cm_State","cm_file_enabled", "rec_info_avl","file_avl", "cm_link",  "date_created"]])->toArray();

        $_serialize = 'data';
        $_header = $this->columnHeaders;
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->setClassName('CsvView.Csv');
        return;
    }

    
	/* private function setExtraValue(array $postData){
		
		$filearr = [];
		if($postData['cm_file_enabled'] == 'Y'){
			  if($postData['cm_all_doc_type'] != "")
				$filearr[] = 'All Document Types';
			if($postData['cm_limited_doc_type'] != "")
				$filearr[] = 'Limited Document Types';  
		}
		$postData['file_avl'] = implode("<br \>\n",$filearr);
		
		$rec_info = array();		
		  // if($postData['cm_file_enabled'] != '0')
		//	$rec_info[] = '<span style="color:red;">No Info Available (Website Only)</span>';  
		
		  if($postData['rec_info_main'] == '1')
			$rec_info[] = 'Rec Info & Images Available No Charge';
		elseif($postData['rec_info_main'] == '2')
			$rec_info[] = 'Rec Info Only No Charge';
		elseif($postData['rec_info_main'] == '3')
			$rec_info[] = '<span style="color:red;">Rec Info & Images Available $$$</span>';
			
		if($postData['sub_info_main'] == '1')
			$rec_info[] = 'Subscription Rec Info & Images Available No Charge';
		elseif($postData['sub_info_main'] == '2')
			$rec_info[] = 'Subscription Rec Info Only No Charge';
		elseif($postData['sub_info_main'] == '3')
			$rec_info[] = '<span style="color:red;">Subscription Rec Info & Images Available $$$</span>';	
  
		$postData['rec_info_avl'] = implode("<br \>\n",$rec_info);
		
		return $postData;
		
    } */

	private function getLink($Website){
		$link_replace ='';
		if(strpos($Website, '://')){
			$link = explode("://",$Website);
			$link_replace = str_replace("www.","",$link[1]);
		}else{
			$link_replace = $Website;
		}
		return $link_replace;
	}
}