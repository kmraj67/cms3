<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Event\Event;

/**
 * EmailTemplates Controller
 *
 * @property \Admin\Model\Table\EmailTemplatesTable $EmailTemplates
 */
class EmailTemplatesController extends AppController {
    
    public function initialize() {
        parent::initialize();
        $this->loadmodel('EmailTemplates');
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->pageTitle = 'Email Templates';
        $search_key = '';
        $conditions = [];
        
        if($this->request->query('key')) {
            $search_key = trim($this->request->query('key'));
            if(!empty($search_key)) {
                $conditions["subject LIKE"] = "%$search_key%";
            }
        }
        
        $this->paginate = [
            'limit' => ADMIN_PAGE_LIMIT,
            'order' => ['modified'=>'DESC'],
            'contain' => [],
            'conditions' => $conditions
        ];
        
        $emailTemplates = $this->paginate($this->EmailTemplates);
        $this->set(compact('emailTemplates','search_key'));
        $this->set('_serialize', ['emailTemplates']);
    }

    /**
     * View method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $id = $this->Common->decrypt($id);
        if($this->EmailTemplates->isValid($id)) {
            $emailTemplate = $this->EmailTemplates->get($id, [
                'contain' => []
            ]);    
            $this->set('emailTemplate', $emailTemplate);
            $this->set('_serialize', ['emailTemplate']);
        } else {
            $this->Flash->error(__('Invalid template ID.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $emailTemplate = $this->EmailTemplates->newEntity();
        if ($this->request->is('post')) {
            $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->data);
            if ($this->EmailTemplates->save($emailTemplate)) {
                $this->Flash->success(__('The email template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email template could not be saved. Please, try again.'));
        }
        $this->set(compact('emailTemplate'));
        $this->set('_serialize', ['emailTemplate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $id = $this->Common->decrypt($id);
        if($this->EmailTemplates->isValid($id)) {
            $emailTemplate = $this->EmailTemplates->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->data);
                if ($this->EmailTemplates->save($emailTemplate)) {
                    $this->Flash->success(__('The email template has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The email template could not be saved. Please, try again.'));
            }
            $this->set(compact('emailTemplate'));
            $this->set('_serialize', ['emailTemplate']);
        } else {
            $this->Flash->error(__('Invalid template ID.'));
            return $this->redirect(['action' => 'index']);
        }
    }
}
