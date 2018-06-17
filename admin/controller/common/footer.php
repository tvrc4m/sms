<?php

class ControllerCommonFooter extends ControllerBase {   

	protected $id="footer";

	public function index() {
        $this->data['isLogin'] = false;
        if( isset( $this->request->get['isLogin'] )){
            $this->data['isLogin'] = true;
        }
        if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
            $this->data['isLogged'] = true;
        }else{
            $this->data['isLogged'] = false;
        }
		$this->language->load('common/footer');
		
		$this->data['text_footer'] = sprintf($this->language->get('text_footer'), VERSION);
		
		if (file_exists(DIR_SYSTEM . 'config/svn/svn.ver')) {
			$this->data['text_footer'] .= '.r' . trim(file_get_contents(DIR_SYSTEM . 'config/svn/svn.ver'));
		}
		
		$this->template = 'common/footer.tpl';
	
    	$this->render();
  	}
}
?>