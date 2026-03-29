<?php
// src/Controller/ReviewsController.php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Routing\Router;

class ReviewsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel("FilesMainData");
        $this->loadModel('FilesVendorAssignment');
        $this->loadModel('FilesAolAssignment');
        $this->loadModel('FilesAttorneyAssignment');
        $this->loadModel('FilesEscrowAssignment');
        $this->loadComponent('GeneratePDF');
        $this->loadModel('AttorneyReviews');
        $this->loadModel('FilesExamReceipt');
        $this->viewBuilder()->setLayout('default');
        $this->autoRender = true;
        $this->Authentication->allowUnauthenticated(['index', 'add']);
    }

    public function index($id = null){
        if ($id !== null) {
            $id = (int) $id;
            $this->set('reviewId', $id);
            $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
        } else {
            $aol_data = null; // Set a default value to avoid query errors
        }
        $this->set(compact('fmd_data'));
        //echo "<pre>";print_r($fmd_data);echo "</pre>";
        $review = $this->AttorneyReviews->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if(count($this->request->getData('answer'))>0){
                $data['answer'] = json_encode($data['answer']);
            }
        //echo "<pre>";print_r($data);echo "</pre>";exit;
            $review = $this->AttorneyReviews->patchEntity($review, $data);
            if ($review->getErrors()) {
                debug($review->getErrors()); // Show validation errors
                exit;
            }
            if ($this->AttorneyReviews->save($review)) {
                $fullUrl = Router::url(['controller' => 'Reviews', 'action' => 'index', $id], true);
                $this->Flash->success(__('Your review has been submitted.'));
                return $this->redirect($fullUrl);
            }
            $this->Flash->error(__('Unable to submit your review.'));
        }
        $this->set(compact('review'));
    }
}

// templates/Reviews/index.php
?>