<?php

namespace Admin\Controller;

use Cake\Controller\Controller as BaseController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Network\Request;
use Cake\Core\Configure;

class AppController extends BaseController {
    
    public $base_url            = '/';
    public $pageTitle           = 'Admin';
    public $loggedInUserId      = null;
    public $loggedInUserRoleId  = null;
    public $loggedInUser        = null;
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('Roles');
        $this->loadModel('Statuses');
        $this->loadModel('Users');
        $this->loadModel('Settings');
        $this->loadComponent('Flash');
        $this->loadComponent('Common');

        $this->_loadConstants();
        
        $this->loadComponent('Auth',[
            'loginAction' => [
                'controller' => 'login',
                'plugin' => 'Admin'
            ],
            'loginRedirect' => [
                'controller' => 'dashboard',
                'plugin' => 'Admin'
            ],
            'authenticate' => [
                'Form' => [
                    'scope' => ['Users.role_id'=>ADMIN],
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ]
        ]);
        $this->base_url = Router::url('/', true);
        $this->set('base_url', $this->base_url);
    }
    
    public function beforeFilter(Event $event) {
        $this->loggedInUserId = $this->Auth->user('id');
        $this->loggedInUserRoleId = $this->Auth->user('role_id');
        $this->loggedInUser = $this->Auth->user();
        $this->set('loggedInUserId',$this->loggedInUserId);
        $this->set('loggedInUserRoleId',$this->loggedInUserRoleId);
        if(!empty($this->loggedInUserId)) {
            $this->set('loggedInUser',$this->Users->get($this->loggedInUserId));    
        } else {
            $this->set('loggedInUser',[]);
        }
    }
    
    public function beforeRender(Event $event) {
        $this->set('title', $this->pageTitle);
    }

    function _loadConstants() {
        $statusRows = $this->Statuses->find();
        foreach ($statusRows as $row) {
            define(strtoupper($row->slug), $row->id);
        }
        $roleRows = $this->Roles->find();
        foreach ($roleRows as $row) {
            define(strtoupper($row->slug), $row->id);
        }
        $settingRows = $this->Settings->find();
        foreach ($settingRows as $row) {
            define(strtoupper($row->key_field), $row->key_value);
        }
    }
}
