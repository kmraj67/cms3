<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Event\Event;

class SettingsController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['saveSetting']);
    }
    
    public function index() {
        $this->pageTitle = 'List All Settings';
        $search_key = '';
        $conditions = [];

        if($this->request->query('key')) {
            $search_key = trim($this->request->query('key'));
            if(!empty($search_key)) {
                $conditions['OR']['key_field LIKE'] = "%$search_key%";
                $conditions['OR']['key_value LIKE'] = "%$search_key%";
            }
        }

        $this->paginate = [
            'limit' => ADMIN_PAGE_LIMIT,
            'order' => ['modified'=>'DESC'],
            'conditions' => $conditions
        ];

        $settings = $this->paginate($this->Settings);

        $this->set(compact('settings','search_key'));
        $this->set('_serialize', ['settings']);
    }
    
    public function saveSetting($id=null) {
        $response = ['result'=>'error','message'=>'Invalid request!'];
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        $result  = 'success';
        $message = '';
        $id = $this->Common->decrypt($id);
        if($this->request->is('ajax')) {
            if(!empty($this->loggedInUserId)) {
                if(!empty($id)) {
                    $setting = $this->Settings->get($id);
                } else {
                    $setting = $this->Settings->newEntity();
                }
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $setting_data = [
                        'key_field' => isset($this->request->data['key_field'])?$this->request->data['key_field']:NULL,
                        'key_value' => isset($this->request->data['key_value'])?$this->request->data['key_value']:NULL,    
                    ];
                    if(!empty($id)) {
                        $setting_data['id'] = $id;
                    }
                    $setting = $this->Settings->patchEntity($setting, $setting_data);
                    //pr($setting); die;
                    //pr($setting->errors()); die;
                    if(empty($setting->errors())) {
                        if($this->Settings->save($setting)) {
                            $this->Flash->success(__('Setting has been saved successfully.'));
                            $result  = 'saved';
                        } else {
                            $result  = 'error';
                            $message = 'Setting could not be saved, please try again.';
                        }
                    }
                }
                $this->viewBuilder()->template('Admin.Settings/form');
                $this->viewBuilder()->helpers(['Html']);
                $view = $this->viewBuilder()->build(compact('setting','id'));
                $view_html = $view->render();
                $response = ['result'=>$result,'message'=>$message,'html'=>$view_html];
            } else {
                $response = ['result'=>'logout','message'=>'Your session has been expired. Please login again.'];
            }
            echo json_encode($response); exit();
        } else {
            //$this->Flash->error(__('Invalid request!'));
            return $this->redirect('/');
        }
    }

    public function profile() {
        $id = $this->loggedInUserId;
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user_data = [
                'id' => $id,
                'email' => isset($this->request->data['email'])?$this->request->data['email']:null,
                'first_name' => isset($this->request->data['first_name'])?$this->request->data['first_name']:null,
                'last_name' => isset($this->request->data['last_name'])?$this->request->data['last_name']:null,
                'phone' => isset($this->request->data['phone'])?$this->request->data['phone']:null,
            ];
            $user = $this->Users->patchEntity($user, $user_data, ['validate'=>'profile']);
            if(!$user->errors()) {
                if ($this->Users->save($user,['checkRules'=>false])) {
                    $this->Flash->success(__('Profile has been updated.'));
                    return $this->redirect('/admin/profile');
                } else {
                    $this->Flash->error(__('profile could not be updated. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Please fix the validation errors.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
    
    public function isUniqueKey($id=null) {
        $id = $this->Common->decrypt($id);
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        $result = 'false';
        if ($this->request->is('ajax')) {
            if ($this->Settings->isUniqueKey($this->request->data['key_field'],$id) === true) {
                $result = 'true';
            }
        }
        echo $result; exit();
    }
}