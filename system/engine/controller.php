<?php
abstract class Controller {
	protected $registry;	
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;
	protected $customer_id;
	protected $user_id;

    protected $filters = array(); // for backend

	public function __construct($registry) {
		$this->registry = $registry;
		$this->customer_id=isset($this->session->data['customer_id'])?$this->session->data['customer_id']:0;
		$this->user_id=isset($this->session->data['user_id'])?$this->session->data['user_id']:0;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
			
	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		exit();				
	}
	
	protected function getChild($child, $args = array()) {
		$action = new Action($child, $args);
	
		if (file_exists($action->getFile())) {
			require_once($action->getFile());

			$class = $action->getClass();

			$controller = new $class($this->registry);

			$controller->{$action->getMethod()}($action->getArgs());
			
			return $controller->output;
		} else {
			trigger_error('Error: Could not load controller ' . $child . '!');
			exit();					
		}		
	}
	
	protected function hasAction($child, $args = array()) {
		$action = new Action($child, $args);
	
		if (file_exists($action->getFile())) {
			require_once($action->getFile());

			$class = $action->getClass();

			$controller = new $class($this->registry);

			if(method_exists($controller, $action->getMethod())){
				return true;
			}else{
				return false;
			}
		} else {
			return false;				
		}		
	}
	
	protected function render() {

		foreach ($this->children as $child) {

			$this->data[basename($child)] = $this->getChild($child);
		}

		if (file_exists(DIR_TEMPLATE . $this->template)) {

			extract($this->data);

      		ob_start();
            require(DIR_TEMPLATE . $this->template);
            $this->output = ob_get_contents();
      		ob_end_clean();
			return $this->output;
    	} else {
			trigger_error('Error: Could not load template ' . DIR_TEMPLATE . $this->template . '!');
			exit();				
    	}
	}


    /*****************************************************************************************/

    protected function makeFilters(){

        $result = array();

        foreach($this->filters as $filterItem) {
            if (isset($this->request->get[$filterItem])) {
                $this->data[$filterItem] = $this->request->get[$filterItem];
                $result[$filterItem] = $this->request->get[$filterItem];
            } else {
                $this->data[$filterItem] = "";
            }
        }

        return $result;

    }

    protected function createURLParams($data=array()) {

        $url = '';

        $result = array_merge($this->filters,$data);

        foreach($result as $filterItem) {
            if(isset($this->request->get[$filterItem])) {
                $url .= '&' . $filterItem . '=' . urlencode(html_entity_decode($this->request->get[$filterItem], ENT_QUOTES, 'UTF-8'));
            }
        }

        return $url;

    }
}
?>