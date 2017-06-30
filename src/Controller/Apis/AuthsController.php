<?php
namespace App\Controller\Apis;

use App\Controller\Apis\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;

class AuthsController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->loadModel('Users');
        $this->loadModel('AppSessions');
    }
    
    public function login() {
        $response = $this->Common->getResponse('400');
        if ($this->request->is('post')) {
            $request_data = $this->request->input('json_decode', true);
            $user_data = [
                'email' => isset($request_data['email'])?$request_data['email']:'',
                'password' => isset($request_data['password'])?$request_data['password']:''
            ];
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $user_data, ['validate'=>'Login']);
            if(!$user->errors()) {
                $user_row = $this->Users->find('all', [
                    'conditions'=> ['Users.status_id IN'=>[ACTIVE,INACTIVE],'Users.email'=>$user_data['email']]
                ])->first();
                
                if(!empty($user_row)) {
                    if($this->Users->checkPassword($user_data['password'], $user_row->password) == true) {
                        if($user_row->status_id == 1) {
                            $token = $this->Common->genrateToken($user_row->id,false);
                            $session_data = [
                                'user_id' => $user_row->id,
                                'token' => $token,
                                'ip_address' => isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'',
                                'http_user_agent' => substr(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'',0,250),
                                'created' => $this->current_date,
                                'last_active' => $this->current_date
                            ];
                            $appSession = $this->AppSessions->newEntity();
                            $appSession = $this->AppSessions->patchEntity($appSession, $session_data);
                            if($this->AppSessions->save($appSession)) {
                                $response = $this->Common->getResponse('200','success','User login successfully.');
                                $response['token'] = $token;
                                $response['user'] = $user_row;
                            } else {
                                $response = $this->Common->getResponse('500');
                            }
                        } else {
                            $response = $this->Common->getResponse('401','error','Your account has been de-activated. Please contact to site admin for further instructions.');
                        }                        
                    } else {
                        $response = $this->Common->getResponse('401','error','Email or password did not match.');
                    }
                } else {
                    $response = $this->Common->getResponse('401','error','Email or password did not match.');
                }
            } else {
                $response = $this->Common->getResponse('400','error','Validation errors');
                $response['errors'] = $this->Common->getErrors($user->errors());
            }
        } else {
            $response = $this->Common->getResponse('405');
        }
        $this->_serializeData($response);
    }
    
    public function logout() {
        $response = $this->Common->getResponse('400');
        if ($this->request->is('delete')) {
            $auth_token = $this->request->header('token');
            if(!empty($auth_token)) {                    
                if($this->AppSessions->isValidToken($auth_token)) {
                    if($this->AppSessions->deleteSession($auth_token)) {
                        $response = $this->Common->getResponse('204','success','User successfully logged out.');      
                    } else {
                        $response = $this->Common->getResponse('304','error','Request not completed, please try again.');
                    }
                } else {
                    $response = $this->Common->getResponse('401');                           
                }
            } else {
                $response = $this->Common->getResponse('401');
            }
        } else {
            $response = $this->Common->getResponse('405');
        }
        $this->_serializeData($response);
    }

    public function changePassword() {
        $response = $this->Common->getResponse('400');
        if ($this->request->is('put')) {
            $auth_token = $this->request->header('token');
            if(!empty($auth_token)) {                    
                if($this->AppSessions->isValidToken($auth_token)) {
                    $row = $this->AppSessions->findByToken($auth_token)->contain(['Users'])->first();
                    if(isset($row->user) && !empty($row->user)) {
                        $request_data = $this->request->input('json_decode', true);
                        $user_data = [
                            'old_password' => isset($request_data['old_password'])?$request_data['old_password']:'',
                            'new_password' => isset($request_data['new_password'])?$request_data['new_password']:'',
                            'confirm_password' => isset($request_data['confirm_password'])?$request_data['confirm_password']:''
                        ];                        
                        $user = $row->user;
                        $user = $this->Users->patchEntity($user, $user_data, ['validate'=>'changepassword']);
                        if(empty($user->errors())) {
                            $user->password = $user_data['new_password'];
                            if ($this->Users->save($user)) {
                                $response = $this->Common->getResponse('200','success','Password changed successfully.');
                            } else {
                                $response = $this->Common->getResponse('304','error','Password could not be changed, try again.');
                            }
                        } else {
                            $response = $this->Common->getResponse('400','error','Validation errors');
                            $response['errors'] = $this->Common->getErrors($user->errors());
                        }
                    } else {
                        $response = $this->Common->getResponse('401',null,'Authentication token is invalid.');
                    }
                } else {
                    $response = $this->Common->getResponse('401',null,'Authentication token is invalid.');
                }
            } else {
                $response = $this->Common->getResponse('401',null,'Authentication token is required.');
            }
        } else {
            $response = $this->Common->getResponse('405');
        }
        $this->_serializeData($response);
    }
}