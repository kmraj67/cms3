<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $this->pageTitle = 'Users List';
        $search_key = '';
        $having     = null;
        $conditions = ['Users.role_id !='=>ADMIN];
        
        if($this->request->query('key')) {
            $search_key = trim($this->request->query('key'));
            if(!empty($search_key)) {
                $having['OR'] = [
                    "name LIKE"   => "%$search_key%",
                    "Users.email LIKE" => "%$search_key%"
                ];
            }
        }
        
        $this->paginate = [
            'limit' => ADMIN_PAGE_LIMIT,
            'order' => ['Users.modified'=>'DESC'],
            'contain' => ['Statuses','Roles'],
            'conditions' => $conditions,
            'fields' => ['id','email','phone','status_id','last_login','created','Statuses.title','Roles.title',
                'name' => $this->Users->query()->func()->concat([
                    'trim(Users.first_name)' => 'literal',' ','trim(Users.last_name)' => 'literal'
                ])
            ],
            'sortWhitelist' => ['Roles.title','Statuses.title','Users.email','Users.phone','Users.modified','Users.created','name','Users.last_login']
        ];
        if(!empty($having)) {
            $this->paginate['having'] = $having;
        }
        $users = $this->paginate($this->Users);

        $this->set(compact('users','search_key'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $this->pageTitle = 'User Details';
        
        $id = $this->Common->decrypt($id);
        if($this->Users->isValid($id)) {
            $user = $this->Users->get($id, [
                'contain' => ['Roles','Statuses']
            ]);    
            $this->set('user', $user);
            $this->set('_serialize', ['user']);
        } else {
            $this->Flash->error(__('Invalid user ID.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->pageTitle = 'New User';
        
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->_saveUser($user);
        }
        $roles = $this->Users->Roles->find('list', ['conditions'=>['id !='=>ADMIN],'limit' => 200]);
        $this->set(compact('user', 'roles', 'statuses'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->pageTitle = 'Edit User';
        
        $id = $this->Common->decrypt($id);
        if($this->Users->isValid($id)) {
            $user = $this->Users->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $this->_saveUser($user,null);
            }
            $roles = $this->Users->Roles->find('list', ['conditions'=>['id !='=>ADMIN],'limit' => 200]);
            $this->set(compact('user', 'roles', 'statuses'));
            $this->set('_serialize', ['user']);
        } else {
            $this->Flash->error(__('Invalid user ID.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    /**
     * _saveUser method
     *
     * @param array|$user.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    function _saveUser($user, $id=null) {
        $password = $this->Common->genratePassword();
        $user_data = [
            'role_id' => isset($this->request->data['role_id'])?$this->request->data['role_id']:null,
            'email' => isset($this->request->data['email'])?$this->request->data['email']:null,
            'first_name' => isset($this->request->data['first_name'])?$this->request->data['first_name']:null,
            'last_name' => isset($this->request->data['last_name'])?$this->request->data['last_name']:null,
            'phone' => isset($this->request->data['phone'])?$this->request->data['phone']:null,
            'status_id' => isset($this->request->data['status_id'])?$this->request->data['status_id']:null,
            'password' => $password
        ];
        
        if(!empty($id)) {
            unset($user_data['password']);
        }
        
        $user = $this->Users->patchEntity($user, $user_data, ['validate'=>'saveUser']);
        
        if(!$user->errors()) {
            if ($this->Users->save($user,['checkRules'=>false])) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('Please fix the validation errors.'));
        }
    }
    
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function _delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function changeStatus() {
        $response = [];
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            if(!empty($this->loggedInUserId)) {
                $user_id  = $this->Common->decrypt(isset($this->request->data['user_id'])?$this->request->data['user_id']:'');
                if(!empty($user_id) && ($this->Users->isValid($user_id) === true)) {
                    $user = $this->Users->get($user_id);
                    
                    $requestData['status_id'] = INACTIVE;
                    $actionStr = 'de-activated';
                    $statusText = 'Inactive';
                    if($user->status_id == INACTIVE) {
                        $requestData['status_id'] = ACTIVE;
                        $actionStr = 'activated';
                        $statusText = 'Active';
                    }
                    $user = $this->Users->patchEntity($user,$requestData,['validate'=>false]);
                    if($this->Users->save($user)) {
                        $response = ['result'=>'success','message'=>'User has been '.$actionStr.' successfully.','statusText'=>$statusText];
                        $email_data = [
                            'first_name' => isset($user->first_name)?$user->first_name:'',
                            'last_name' => isset($user->last_name)?$user->last_name:'',
                            'email' => isset($user->email)?$user->email:'',
                        ];
                        
                        if($user->status_id == ACTIVE) {
                            $subject = 'User Account Activated';
                            $this->Common->sendEmail($user->email,$subject,$email_data,'Admin.account_activate','Admin.default');
                        } else {
                            $subject = 'User Account Deactivated';
                            //$this->UserSessions->deleteAll(['UserSessions.user_id'=>$user_id]);
                            $this->Common->sendEmail($user->email,$subject,$email_data,'Admin.account_deactivate','Admin.default');
                        }
                        
                    } else {
                        $response = ['result'=>'error','message'=>'user could not be '.$actionStr.'. Please try again.'];
                    }
                } else {
                    $response = ['result'=>'error','message'=>'Invalid Action!'];
                }
            } else {
                $response = ['result'=>'logout','message'=>'Your session has been expired. Please login again.'];
            }
        } else {
            $response = ['result'=>'error','message'=>'Invalid Action!'];
        }
        echo json_encode($response); exit();
    }
    
    public function sendPasswordLink() {
        $response = [];
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            if(!empty($this->loggedInUserId)) {
                $user_id = (isset($this->request->data['user_id']) && !empty(trim($this->request->data['user_id'])))?trim($this->request->data['user_id']):'';
                $user_id = $this->Common->decrypt($user_id);
                if(!empty($user_id) && ($this->Users->isValid($user_id)) === true) {
                    $user = $this->Users->get($user_id);
                    $this->request->data = [];
                    $token = $this->Common->genrateToken($user->id);
                    $this->request->data['forgot_password_token'] = $token;
                    $user = $this->Users->patchEntity($user, $this->request->data,['validate'=>false]);
                    if($this->Users->save($user)) {
                       $reset_password_url = $this->base_url.'reset-password?reset_token='.$token;
                        $email_data = [
                            'first_name'  => $user->first_name,
                            'reset_url'     => $reset_password_url
                        ];
                        $subject = 'CMS3 Password Reset Link';
                        $this->Common->sendEmail($user->email,$subject,$email_data,'Admin.forgot_password','Admin.default');
                        $response = ['result'=>'success','message'=>'Reset password link has been sent to '.$user->email.'.'];
                    } else {
                        $response = ['result'=>'error','message'=>'Reset password link could not be sent. Please try again.'];
                    }
                } else {
                    $response = ['result'=>'error','message'=>'Invalid user ID.'];
                }
            } else {
                $response = ['result'=>'logout','message'=>'Your session has been expired. Please login again.'];
            }
            echo json_encode($response); exit();
        } else {
            return $this->redirect('/admin');
        }
    }
    
    public function isUniqueEmail($id=null) {
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        $result = 'false';
        if ($this->request->is('ajax')) {
            if ($this->Users->isUniqueEmail($this->request->data['email'],$id) === true) {
                $result = 'true';
            }
        }
        echo $result; exit();
    }
}