<?php

namespace App\Controller\Apis;

use Cake\Controller\Controller as BaseController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Network\Request;
use Cake\Core\Configure;

class AppController extends BaseController {

	public function initialize() {
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Common');
		$this->loadModel('Roles');
		$this->loadModel('Statuses');
		$this->loadModel('Settings');
        $this->current_date = date('Y-m-d H:i:s');
		$this->_loadConstants();
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->RequestHandler->ext = 'json';
        $this->response->header('Access-Control-Allow-Origin', '*');
	}

	public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    function _loadConstants() {
        $settingRows = $this->Settings->find();
        foreach ($settingRows as $row) {
            define(strtoupper($row->key_field), $row->key_value);
        }
    }
    
    function _serializeData($response) {
        $serialize_data = [];
        foreach($response as $key=>$val) {
            $this->set($key, $val);
            $serialize_data[] = $key;
        }
        $this->set('_serialize', $serialize_data);
    }
}
