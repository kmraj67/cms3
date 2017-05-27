<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Validation\Validation;

class AuthsController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login','forgotPassword','resetPassword','changePassword','isValidOldPassword','isEmailExists']);
    }
    
    public function login() {
        if(!empty($this->loggedInUserId)) {
            return $this->redirect('/admin');
        }
        
        $this->pageTitle = 'Admin Login';
        $this->viewBuilder()->layout('Admin.login');
        
        $userEntity = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $userEntity = $this->Users->patchEntity($userEntity, $this->request->data,['validate'=>'login']);
            if(!$userEntity->errors()) {
                // For login with email
                //if (Validation::email($this->request->data['username'])) {
                //    $this->Auth->config('authenticate', [
                //        'Form' => [
                //            'fields' => ['username' => 'email','password' => 'password']
                //        ]
                //    ]);
                //    $this->Auth->constructAuthenticate();
                //    $this->request->data['email'] = $this->request->data['username'];
                //    unset($this->request->data['username']);
                //}
                
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->error(__('Please check your credentials and try again.'));
            }
        }
        $this->set('user', $userEntity);
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    
    public function forgotPassword() {
        $this->pageTitle = 'Forgot Password';
        $this->viewBuilder()->layout('Admin.login');        
        
        $userEntity = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $userEntity = $this->Users->patchEntity($userEntity, $this->request->data,['validate'=>'forgot']);
            $email = isset($userEntity->email)?$userEntity->email:'';
            if(empty($userEntity->errors()) && !empty($email)) {
                $user = $this->Users->findByEmail($email)->first();
                $token = $this->Common->genrateToken($user->id);
                $user->forgot_password_token = $token;
                if($this->Users->save($user)) {
                    $reset_password_url = $this->base_url.'admin/reset-password?reset_token='.$token;
                    $email_data = ['reset_url'=>$reset_password_url,'first_name'=>$user->first_name];
                    $subject = 'Reset Password Link';
                    $this->Common->sendEmail($email,$subject,$email_data,'Admin.forgot_password','Admin.default');
                    $this->Flash->success(__('An email has been sent to the registered email ID, please check your email for further instructions.'));
                    return $this->redirect('/admin/login');
                } else {
                    $this->Flash->error(__('Email could not be sent, please try again.'));
                }                
            }
        }
        $this->set('user', $userEntity);
    }
    
    public function resetPassword() {
        $this->pageTitle = 'Reset Password';
        $this->viewBuilder()->layout('Admin.login');
        
        $resetToken = isset($this->request->query['reset_token'])?trim($this->request->query['reset_token']):'';
        //echo $resetToken; die;
        if($this->Users->isValidResetToken($resetToken) === true) {
            $userEntity = $this->Users->newEntity();
            if($this->request->is('post')) {
                $userEntity = $this->Users->patchEntity($userEntity, $this->request->data,['validate'=>'reset']);
                //pr($userEntity); die;
                if(empty($userEntity->errors())) {
                    $user = $this->Users->findByForgotPasswordToken($resetToken)->first();
                    $user->password = $userEntity->confirm_password;
                    $user->forgot_password_token = NULL;
                    if($this->Users->save($user)) {
                        $email_data = ['first_name'=>$user->first_name];
                        $subject = 'Password Reset Successfully';
                        $this->Common->sendEmail($user->email,$subject,$email_data,'Admin.reset_password','Admin.default');
                        $this->Flash->success(__('Your password has been reset successfully.'));
                        return $this->redirect('/admin/login');
                    } else {
                        $this->Flash->error(__('Password could not be reset, please try again.'));
                    }
                }
            }
            $this->set('user', $userEntity);
        } else {
            $this->Flash->error(__('Invalid request!'));
            return $this->redirect('/admin/login');
        }
    }
    
    public function changePassword() {
        $response = ['result'=>'error','message'=>'Invalid request!'];
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        $result  = 'success';
        $message = ''; 
        if($this->request->is('ajax')) {
            if(!empty($this->loggedInUserId)) {
                $user = $this->Users->get($this->loggedInUserId);
                if($this->request->is('put')) {
                    $user_data = [
                        'id' => $this->loggedInUserId,
                        'old_password' => isset($this->request->data['old_password'])?$this->request->data['old_password']:'',
                        'password' => isset($this->request->data['new_password'])?$this->request->data['new_password']:'',
                        'new_password' => isset($this->request->data['new_password'])?$this->request->data['new_password']:'',
                        'confirm_password' => isset($this->request->data['confirm_password'])?$this->request->data['confirm_password']:'',
                    ];
                    $user = $this->Users->patchEntity($user,$user_data,['validate'=>'changepassword']);
                    
                    if(empty($user->errors())) {
                        if($this->Users->save($user)) {
                            $email_data = ['first_name'=>$user->first_name,'email'=>$user->email];
                            $subject = 'Password Changed Successfully';
                            $this->Common->sendEmail($user->email,$subject,$email_data,'Admin.change_password','Admin.default');
                            $this->Flash->success(__('Your password has been changed successfully.'));
                            $result  = 'saved';
                        } else {
                            $result  = 'error';
                            $message = 'Password could not be changed please try again.';
                        }
                    } else {
                        //pr($user->errors()); die;
                    }
                }
                $this->viewBuilder()->template('Admin.Auths/change_password');
                $this->viewBuilder()->helpers(['Html']);
                $view = $this->viewBuilder()->build(compact('user'));
                $view_html = $view->render();
                $response = ['result'=>$result,'message'=>$message,'html'=>$view_html];
            } else {
                $response = ['result'=>'logout','message'=>'Your session has been expired. Please login again.'];
            }
            echo json_encode($response); exit();
        } else {
            $this->Flash->error(__('Invalid request!'));
            return $this->redirect('/admin');
        }
    }
    
    public function isValidOldPassword() {
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        $result = 'false';
        if ($this->request->is('ajax')) {
            if ($this->Users->isValidOldPassword($this->request->data['old_password'],$this->loggedInUserId) === true) {
                $result = 'true';
            }
        }
        echo $result; exit();
    }
    
    public function isEmailExists() {
        $this->viewBuilder()->layout('Admin.ajax');
        $this->autoRender = false;
        $result = 'false';
        if ($this->request->is('ajax')) {
            if ($this->Users->isEmailExists($this->request->data['email']) === true) {
                $result = 'true';
            }
        }
        echo $result; exit();
    }
}