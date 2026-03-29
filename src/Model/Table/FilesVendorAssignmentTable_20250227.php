<?php
// src/Model/Table/FilesVendorAssignmentTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class FilesVendorAssignmentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Table name
        $this->setTable('files_vendor_assignment');
		$this->setAlias('fva');
        // Primary key
        $this->setPrimaryKey('Id');

        // Validation rules
        $this->addBehavior('Timestamp'); // Automatically handles `date_updated`
		
		$this->addBehavior('CustomLRS');
        // add in plugin
        $this->addBehavior('Search.Search');

         // Setup search filter using search manager
         $this->searchManagerConfig();
    }
	
	
	public function searchManagerConfig()
    {
        $search = $this->searchManager();
       // $search = $this->behaviors()->Search->searchManager();
      
        $search->Value('TransactionType'); 
		$search->Value('company_id',['prifix'=>'fmd']);
		 $search->Like('NATFileNumber',['prifix'=>'fmd']);
	 	$search->Like('PartnerFileNumber',['prifix'=>'fmd']);
	//	$search->Like('LoanNumber',['prifix'=>'fmd']);
		
	//	$search->Like('StreetNumber',['prifix'=>'fmd']);
		$search->Like('StreetName',['prifix'=>'fmd']);
	//	$search->Like('City',['prifix'=>'fmd']);
		$search->Like('County',['prifix'=>'fmd']);
		$search->Like('State',['prifix'=>'fmd']);
	//	$search->Like('Zip',['prifix'=>'fmd']);

		$search->Like('Grantors',['prifix'=>'fmd']);
	//	$search->Like('Grantees',['prifix'=>'fmd']);
		
	//	$search->Like('GrantorFirstName1',['prifix'=>'fmd']);
	//	$search->Like('GranteeFirstName1',['prifix'=>'fmd']);
		
		$search->Value('cm_partner_cmp',['prifix'=>'cpm']);  
	
	//	$search->Like('Status',['prifix'=>'fqd']);
        return $search;
    }
	
	public function insertNewVendorData($fmdLastId,$documentId,$currentUserId,$docRecived=null, $LRS_extension=0){
		// check unique records for fmd_id & doc_id
		$exist = $this->exists(['RecId' => $fmdLastId, 'TransactionType' => $documentId]);
		 
		if(!$exist){  // not found so insert new
		 
			$filesVendorAssData = $this->newEmptyEntity();
			$insertVendorAssData =  [
									'RecId' => $fmdLastId,
									'TransactionType' => $documentId,									
									'UserId' => $currentUserId									
								];
			
			// ****** For rejected files, not in used corrently *****
			if($docRecived !== null){
				$insertVendorAssData['DocumentReceived'] = $docRecived;
			}
			if($LRS_extension){
				$insertVendorAssData['extension'] = date('Y-m-d H:i:s');
			}
			// *********************** END
		  
			$filesVendorAssData = $this->patchEntity($filesVendorAssData, $insertVendorAssData,['validate' => false]);
			
			if($this->save($filesVendorAssData)) 
				return $filesVendorAssData->id;
			else 
				return false;
		}
	} 
	
	
	public function getMainDataByMultiDocType($ClientFlNocolno,  $doctype, $recIdname="PartnerFileNumber"){
		$results= [];
	 
		
		$query = $this->find('all')
					->where(['fmd.'.$recIdname =>$ClientFlNocolno, 'fva.TransactionType'=>$doctype])
					->join([
						'table' => 'files_main_data'.ARCHIVE_PREFIX,
						'alias' => 'fmd',
						'type' => 'LEFT',
						'conditions' => 'fva.RecId = fmd.Id'
					])->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'LEFT',
						'conditions' => ['fva.RecId = fqcd.RecId', 'fva.TransactionType = fqcd.TransactionType']
					])->select(['fmd.Id','fva.TransactionType', 'fqcd.Id','fqcd.Status']);
 
		$results = $query->disableHydration()->first();
	 
		$setFlag = 0; $qcid=$RecId='';
		// not in array 
		if(!empty($results))
		{
			if(!in_array($results['fqcd']['Status'], ['', 'OK'])){
				$ext = 0; 
				$setFlag = 1;
				$qcid=$results['fqcd']['Id'];
				$RecId=$results['fmd']['Id'];
			}else{
				$ext = 1;
			}
		}else{$ext = 0;}
		 
		return ['ext'=>$ext, 'setFlag'=>$setFlag, 'RecId'=>$RecId, 'qcid'=>$qcid]; 
		
	}
	
	public function getMainDataByDocType($ClientFlNocolno,  $doctype){
		$results= [];
		$this->setAlias('fva');
		$query = $this->find()
					->where(['fmd.PartnerFileNumber'=>$ClientFlNocolno, 'fva.TransactionType'=>$doctype])
					->join([
						'table' => 'files_main_data'.ARCHIVE_PREFIX,
						'alias' => 'fmd',
						'type' => 'LEFT',
						'conditions' => 'fva.RecId = fmd.Id'
					])->select(['fmd.Id','fva.TransactionType']);
		$results = $query->disableHydration()->all()->toArray();

		if(!empty($results)) $results=$results[0];
		return $results;
		
	}
	
	public function fileVendeorAssignQuery(array $whereCondition, array $pdata, $cm_partner_cmp = ''){
		$this->setAlias('fva');
		 
		$query = $this->find('search', $pdata['condition'])
				->join([
					'table' => 'files_main_data'.ARCHIVE_PREFIX,
					'alias' => 'fmd',
					'type' => 'INNER',
					'conditions' => 'fmd.Id = fva.RecId'
				])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => 'dtm.Id = fva.TransactionType'
				])
				->where($whereCondition);

	//	if(!empty($cm_partner_cmp)){
			$query = $query->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT',
							'conditions' => 'cpm.cm_id = fmd.company_id'
						]);
	//	}
		//for reject search on checking section
		$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);  
		$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_vendor_assignment'.ARCHIVE_PREFIX]);
		//$query = $query->group(['fcd.files_main_data_id', 'fcd.document_type_mst_id']);
		return $query;
		
	}
	
	
	public function filecheckinQuery(array $whereCondition, array $pdata, $cm_partner_cmp = ''){
		$this->setAlias('fva');
		 
		$query = $this->find('search', $pdata['condition'])
				->join([
					'table' => 'files_main_data'.ARCHIVE_PREFIX,
					'alias' => 'fmd',
					'type' => 'INNER',
					'conditions' => 'fmd.Id = fva.RecId'
				])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => 'dtm.Id = fva.TransactionType'
				])
				->where($whereCondition);

	//	if(!empty($cm_partner_cmp)){
			$query = $query->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT',
							'conditions' => 'cpm.cm_id = fmd.company_id'
						]);
	//	}
		//for reject search on checking section
		$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);  
		$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_vendor_assignment'.ARCHIVE_PREFIX]);
		//$query = $query->group(['fcd.files_main_data_id', 'fcd.document_type_mst_id']);
		return $query;
		
	}

    public function filecheckinQueryAol(array $whereCondition, array $pdata, $cm_partner_cmp = ''){
		$this->setAlias('fva');

		$query = $this->find('search', $pdata['condition'])
				->join([
					'table' => 'files_main_data'.ARCHIVE_PREFIX,
					'alias' => 'fmd',
					'type' => 'INNER',
					'conditions' => 'fmd.Id = fva.RecId'
				])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => 'dtm.Id = fva.TransactionType'
				])
                ->join([
					'table' => 'files_aol_assignment',
					'alias' => 'faol',
					'type' => 'LEFT',
					'conditions' => 'faol.RecId = fmd.Id'
				])

				->where($whereCondition);

			$query = $query->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT',
							'conditions' => 'cpm.cm_id = fmd.company_id'
						]);
	//	}
		//for reject search on checking section
		$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);
		$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_vendor_assignment'.ARCHIVE_PREFIX]);
		//$query = $query->group(['fcd.files_main_data_id', 'fcd.document_type_mst_id']);
		return $query;

	}

    public function filecheckinQueryAtt(array $whereCondition, array $pdata, $cm_partner_cmp = ''){
		$this->setAlias('fva');

		$query = $this->find('search', $pdata['condition'])
				->join([
					'table' => 'files_main_data'.ARCHIVE_PREFIX,
					'alias' => 'fmd',
					'type' => 'INNER',
					'conditions' => 'fmd.Id = fva.RecId'
				])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => 'dtm.Id = fva.TransactionType'
				])
                ->join([
					'table' => 'files_attorney_assignment',
					'alias' => 'faa',
					'type' => 'LEFT',
					'conditions' => 'faa.RecId = fmd.Id'
				])

				->where($whereCondition);

			$query = $query->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT',
							'conditions' => 'cpm.cm_id = fmd.company_id'
						]);
	//	}
		//for reject search on checking section
		$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);
		$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_vendor_assignment'.ARCHIVE_PREFIX]);
		//$query = $query->group(['fcd.files_main_data_id', 'fcd.document_type_mst_id']);
		return $query;

	}

    public function filecheckinQueryEss(array $whereCondition, array $pdata, $cm_partner_cmp = ''){
		$this->setAlias('fva');

		$query = $this->find('search', $pdata['condition'])
				->join([
					'table' => 'files_main_data'.ARCHIVE_PREFIX,
					'alias' => 'fmd',
					'type' => 'INNER',
					'conditions' => 'fmd.Id = fva.RecId'
				])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => 'dtm.Id = fva.TransactionType'
				])
                ->join([
					'table' => 'files_escrow_assignment',
					'alias' => 'fea',
					'type' => 'LEFT',
					'conditions' => 'fea.RecId = fmd.Id'
				])

				->where($whereCondition);

			$query = $query->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT',
							'conditions' => 'cpm.cm_id = fmd.company_id'
						]);
	//	}
		//for reject search on checking section
		$tableFldCount = $this->tblFldCountExport($pdata['condition']['fields']);
		$query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_vendor_assignment'.ARCHIVE_PREFIX]);
		//$query = $query->group(['fcd.files_main_data_id', 'fcd.document_type_mst_id']);
		return $query;

	}
	
	public function insertNewCheckinData($fmdLastId,$documentId,$currentUserId,$docRecived=null, $LRS_extension=0){
		// check unique records for fmd_id & doc_id
		$exist = $this->exists(['RecId' => $fmdLastId, 'TransactionType' => $documentId]);
		 
		if(!$exist){  // not found so insert new
		 
			$filesCheckinData = $this->newEmptyEntity();
			$insertCheckInData =  [
									'RecId' => $fmdLastId,
									'TransactionType' => $documentId,
									'DocumentReceived' => (($docRecived !== null) ? $docRecived : ''),
									'UserId' => $currentUserId
									//'CheckInProcessingDate' => date("Y-m-d"),
									//'CheckInProcessingTime' => date("H:i:s")
								];

			if($docRecived !== null){
				$insertCheckInData['DocumentReceived'] = $docRecived;
			}
			if($LRS_extension){
				$insertCheckInData['extension'] = date('Y-m-d H:i:s');
			}
		  
			$filesCheckinData = $this->patchEntity($filesCheckinData, $insertCheckInData,['validate' => false]);
			
			if($this->save($filesCheckinData)) 
				return $filesCheckinData->id;
			else 
				return false;
		}
	} 
	
	public function sqlDataInsertByForm($rowData,$currentUserId,$cmFileEnabled,$NATFileNumber){
		if($NATFileNumber != null)
		$rowData['NATFileNumber']=$NATFileNumber;
	
		$rowData['FileStartDate']=  date("Y-m-d H:i:s",strtotime($rowData['FileStartDate']));
		$rowData['UserId']=$currentUserId;
		$rowData['DateAdded']=date("Y-m-d H:i:s");
		$rowData['ECapable']=$cmFileEnabled; //$CountyTitle[cm_file_enabled]
		$rowData['TransactionType']=$rowData['TransactionType'];
		//array_push($rowData,['document_type_mst_id'=>$rowData['TransactionType']]); 

		if(isset($rowData['saveBtn'])) unset($rowData['saveBtn']);
		if(isset($rowData['saveOpenBtn'])) unset($rowData['saveOpenBtn']);

		unset($rowData['TransactionType']);
		if(isset($rowData['fmd_id'])) unset($rowData['fmd_id']);
		
		return $rowData;
	}
	
	public function checkCountByFileIdDoctype($fmdId, $doctype){
		$results = 0;
		$query = $this->find()->where(['RecId'=>$fmdId, 'TransactionType'=>$doctype]);
		$results = $query->all()->count();
		return $results;
	}
	
	public function updateCheckInData($documentId,$DocumentReceived, $fmdId, $documentTypeHidden=null)
	{
	 
		if($documentTypeHidden == null) $documentTypeHidden = $documentId;
		$documentTypeHidden = explode(',',$documentTypeHidden);
		$query = $this->find('all')->where(['RecId'=>$fmdId, 'TransactionType IN'=>$documentTypeHidden])->select(['Id']);
 
		$results = $query->disableHydration()->all()->toArray(); // expected only one record
	 
		// expected one record
		$checkInData =  [
							'TransactionType' => $documentId,
							'DocumentReceived' => $DocumentReceived
							//'CheckInProcessingDate' => date("Y-m-d"),
							//'CheckInProcessingTime' => date("H:i:s")
						];
 
		if(!empty($results)){

			foreach($results as $result){
				// update by check in Id
				$this->updateAll($checkInData, ['Id' =>$result['Id']]);
			}
		}

		return true;
	}
	
	// call for delete vendor Records
	public function countByFileId($fmdId){
		$results = 0;
		$query = $this->find()->where(['RecId'=>$fmdId, 'TransactionType IS NOT'=>null]);
		$results = $query->all()->count();
		return $results;
	}
	
}

