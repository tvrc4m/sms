<?php 
class ControllerCommonHeader extends ControllerBase {

	protected $id="header";

	public function index() {

        $this->data['isLogin'] = false;
        if( isset( $this->request->get['isLogin'] )){
            $this->data['isLogin'] = true;
        }

		$this->data['title'] = $this->document->getTitle(); 
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

        if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
            $this->data['isLogged'] = true;
        }else{
            $this->data['isLogged'] = false;
        }

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		
		$this->language->load('common/header');

		$this->data['heading_title'] = $this->language->get('heading_title');
		
        if(isset($this->session->data['token'])){
            $this->data['lottery'] = $this->url->link('sale/lottery','token='.$this->session->data['token']);
            $this->data['card'] = $this->url->link('room/card','token='.$this->session->data['token']);
        }

		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = '';
			
			$this->data['home'] = $this->url->link('common/login', '', 'SSL');
		} else {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
            $this->data['pp_express_status'] = $this->config->get('pp_express_status');

            //new category added by david start

            $this->data['home'] = $this->url->link('room/source', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['account_manage'] = $this->url->link('account/customer', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['sms_manage'] = $this->url->link('sms/sms', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['interface_manage'] = $this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['deposit_manage'] = $this->url->link('deposit/record', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['user_manage'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['checkout'] = $this->url->link('service/checkout', 'token=' . $this->session->data['token'], 'SSL');
            //new category added by david end

			$this->data['stores'] = array();
			
			$this->load->model('setting/store');
			
			$results = $this->model_setting_store->getStores();
			
			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}			
		}

		$this->template = 'common/header.tpl';
		
		$this->render();
	}
}
