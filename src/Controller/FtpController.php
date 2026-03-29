<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\View\View;
use Cake\View\ViewBuilder;

/**
 * Ftp Controller
 * File transfer from daily folder to tem and main through Cron Job
 *  
 */
class FtpController extends AppController
{
     
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->addUnauthenticatedActions(['moveFileTempServer', 'moveFileMainServer' ]); 
      
    }
    public function initialize(): void
    { 
        parent::initialize();
        $this->loadModel("FilesMainData");
        $this->loadModel("FilesRecordingData");
        
    }
	/********************************************************************/
	/********  Function moveFileToServer call from cron setting   *******/
	/********  for upload records scan files as daily recording   *******/ 
	/********************************************************************/
      
    public $originFolder; 
    public $targetFolder;
    public $fileCount=0;

    public function moveFileTempServer(){
        $this->autoRender = false;  
        $this->originFolder =  ROOT . DS. 'Daily';
        $this->targetFolder  = WWW_ROOT . 'temp';
        $this->moveFileToServer('TempServer');
    }

    public function moveFileMainServer(){
        $this->autoRender = false; 
        $this->originFolder =  WWW_ROOT . 'temp';
        $this->targetFolder  = WWW_ROOT . 'main';
        $this->moveFileToServer('MainServer');
    }

    private function moveFileToServer($funcName){  
        
		if (is_dir($this->originFolder) && $handle = opendir($this->originFolder)) {
           
			while (false !== ($entryDir = readdir($handle))) {
               
				if($entryDir != "." && $entryDir != ".."){
					
				 //echo '<br> <br> **********************************************';
				 //echo "<br> Folder ==> ***".$this->originFolder."***";
					if(is_dir($this->originFolder. DS .$entryDir)){
						//echo "<br> Sub Folder ==> ***".$this->originFolder. DS .$entryDir."***";
						if ($handle1 = opendir($this->originFolder. DS .$entryDir)) {
                    
							while (false !== ($entryFile = readdir($handle1))) {
								if($entryFile != "." && $entryFile != ".."){ 
                                    //echo "<br> Found file ==> ".$this->originFolder. DS .$entryDir. DS .$entry1;
                                    $this->copyFilesToFolder($entryFile, $entryDir); 
								}
							}
							closedir($handle1);
							//echo rmdir($this->originFolder. DS .$entryDir); 
						}
					}else{
						//for no sub Directory
                        $this->copyFilesToFolder($entryDir);
					} 
				}
			}
			
			closedir($handle); 

			$msg = '<br> File move to Server run as daily cron on time '.date('m-d-Y h:i')." >>>> ".$funcName;
			$msg .=  '<br> Total Files moved ==> '.$this->fileCount ;
 
		} /* else{
			 echo '<br>Folder counld not be found!! <br>Suggestion: folder name must be "daily". <br> It sould be place in root folder as "'. PUBLIC_HTML .'"' ;
		} */  
		exit;
    }

    private function copyFilesToFolder($entryFile, $entryDir=''){
        //move file from daily sub folder to daily root folder
       
        $companyDir = $companyid = "";  

        $entryDir =  ((!empty($entryDir)) ? DS .$entryDir : "");   
        $origin = $this->originFolder. $entryDir. DS .$entryFile;
        // check file in database entry
        $fileCompanyData = $this->FilesMainData->fetchCompanyFromFile($entryFile); 
 
        // check for main folder to add company Id folder  
        if(strpos($this->targetFolder, 'main') !== false){ 
            if(!empty($fileCompanyData)){ $companyid = $fileCompanyData['company_id']; }
            
            $companyDir =  ((!empty($companyid)) ? DS .$companyid : "");
            if(!empty($companyDir)){
                // make new company Dir
                if(!is_dir($this->targetFolder. $companyDir)){ 
                    @mkdir($this->targetFolder. $companyDir);
                   // echo "make company dir ==> ". $this->targetFolder. $companyDir;
                }
            }
        }

      $target =  $this->targetFolder. $companyDir. DS . $entryFile;
       
        if(is_file($origin)){
            if (copy($origin, $target)) {
                if(!empty($fileCompanyData) && (isset($fileCompanyData['frd']['Id']))){
                    // update recording table with file upload status 
                    $this->FilesRecordingData->updateFRDData($fileCompanyData['frd']['Id'], ['file_main_path'=>$companyid]); 
                }
                $this->fileCount++;
                //echo "<br> tempFolder file ==> ".$target;
                if(unlink($origin)){
                //	echo "<br> Deleted file ==> ".$origin;
                }else{
                //	echo "<br> Delete fails ==> ".$origin ;
                }
            } 
        } // no need to else.
    }

}