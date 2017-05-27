<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Event\Event;

class AnalyticsController extends AppController {
    
    public function initialize() {
        parent::initialize();
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        //$this->Auth->allow(['dashboard']);
        //$this->viewBuilder()->layout('Admin.default');
    }
    
    public function dashboard() {
        $this->pageTitle = 'Dashboard';
    }
}