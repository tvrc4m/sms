<?php 
class ControllerCommonHeader extends Controller {
	protected function index() {

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

        if ($this->customer->isLogged() && isset($this->request->get['t']) && ($this->request->get['t'] == $this->session->data['t'])) {
            $this->data['isLogged'] = true;
        }else{
            $this->data['isLogged'] = false;
        }

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		
		$this->language->load('common/header');

		$this->data['heading_title'] = $this->language->get('heading_title');
		
        if(isset($this->session->data['t'])){
            $this->data['lottery'] = $this->url->link('sale/lottery','t='.$this->session->data['t']);
            $this->data['card'] = $this->url->link('room/card','t='.$this->session->data['t']);
        }

		if (!$this->customer->isLogged() || !isset($this->request->get['t']) || !isset($this->session->data['t']) || ($this->request->get['t'] != $this->session->data['t'])) {
			$this->data['logged'] = '';
			
			$this->data['home'] = $this->url->link('common/login', '', 'SSL');
		} else {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->customer->getUserName());
            $this->data['pp_express_status'] = $this->config->get('pp_express_status');

            //new category added by david start
            //quick start

            $this->data['home'] = $this->url->link('room/source', 't=' . $this->session->data['t'], 'SSL');
            $this->data['client_manage'] = $this->url->link('client/client', 't=' . $this->session->data['t'], 'SSL');
            $this->data['sms_manage'] = $this->url->link('sms/send', 't=' . $this->session->data['t'], 'SSL');
            $this->data['client_manage'] = $this->url->link('client/client', 't=' . $this->session->data['t'], 'SSL');
            $this->data['finance_manage'] = $this->url->link('finance/amount', 't=' . $this->session->data['t'], 'SSL');
            $this->data['account_manage'] = $this->url->link('account/index', 't=' . $this->session->data['t'], 'SSL');
            $this->data['clean'] = $this->url->link('service/clean', 't=' . $this->session->data['t'], 'SSL');
            //new category added by david end

            $this->data['top_send'] = $this->url->link('sms/send', 't=' . $this->session->data['t'], 'SSL');

            $this->data['top_outbox'] = $this->url->link('sms/outbox', 't=' . $this->session->data['t'], 'SSL');

            $this->data['logout'] = $this->url->link('common/logout', 't=' . $this->session->data['t'], 'SSL');

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
?>