<?php

class ControllerAccountAjax extends Controller {

	public function getCustomerList(){

		$this->language->load('customer/order');

        $this->document->setTitle('订单管理');
        $this->data['heading_title'] = '订单管理';

        $this->load->model('sale/order');

        $url = $this->createBaseURLParams(array('sort','order','page'));

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 't=' . $this->session->data['t'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('sale/order', 't=' . $this->session->data['t'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('sale/order/insert', 't=' . $this->session->data['t'], 'SSL');
        $this->data['delete'] = $this->url->link('sale/order/delete', 't=' . $this->session->data['t'] . $url, 'SSL');

        if(isset($this->request->get['filter_tab'])) {
            $this->data['filter_tab'] = true;
            $this->data['clearFilter'] = $this->url->link('sale/order/getListAjax', 't=' . $this->session->data['t'] . '&filter_tab=true' . '&filter_order_status='.$this->request->get['filter_order_status'], 'SSL');
        }else{
            $this->data['filter_tab'] = false;
            $this->data['clearFilter'] = $this->url->link('sale/order/getListAjax', 't=' . $this->session->data['t'], 'SSL');
        }

        $this->data['orders'] = array();

        $data = array(
            'sort'                   => $sort,
            'order'                  => $order,
            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'                  => $this->config->get('config_admin_limit')
        );

        $filters = $this->makeFilter();

        $params = array_merge($data,$filters);

        $order_total = $this->model_sale_order->getTotalOrders($params);

        $results = $this->model_sale_order->getOrders($params);

        foreach ($results as $result) {

            if(isset($this->order_status[$result['status']])) {
                $status = $this->order_status[$result['status']];
            }else{
                $status = '错误状态';
            }

            $action_view = array(
                'text' => $this->language->get('text_view'),
                'href' => $this->url->link('sale/order/view', 't=' . $this->session->data['t'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
            );

            $action_edit = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('sale/order/update', 't=' . $this->session->data['t'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
            );

            $action_checkout = array(
                'text' => $this->language->get('text_checkout'),
                'href' => $this->url->link('sale/order/checkout', 't=' . $this->session->data['t'] . '&order_id=' . $result['order_id'] .$url, 'SSL')
            );

            $action_terminate = array(
                'text' => $this->language->get('text_terminate'),
                'href' => "javascript:terminate(".$result['order_id'] .",'" .$result['order_number']."');"
            );

            $action_cancel = array(
                'text' => $this->language->get('text_cancel'),
                'href' => "javascript:cancel(".$result['order_id'] .",'" .$result['order_number']."');"
            );

            $action_continue = array(
                'text' => $this->language->get('text_relet'),
                'href' => $this->url->link('sale/order/relet', 't=' . $this->session->data['t'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
            );

            $action_register = array(
                'text' => $this->language->get('text_register'),
                'href' => $this->url->link('sale/order/register', 't=' . $this->session->data['t'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
            );

            $cation_call = array(
                'text' => $this->language->get('text_call'),
                'href' => "javascript:call('".$result['landlord_phone']."','".$result['contact_mobile']."');"
            );

            $action = array();

            if($result['disable'] == '1') {

                $action[] = $action_view;

            }else{
                //array('待入住',' 入住中','已取消','已退房','已失效');
                switch ($result['status']) {
                    case '0':
                        $action[] = $action_register;
                        $action[] = $action_cancel;
                        $action[] = $action_edit;
                        break;
                    case '1':
                        $action[] = $action_checkout;
                        $action[] = $action_continue;
                        $action[] = $action_edit;
                        break;
                    case '2':
                        $action[] = $action_view;
                        $action[] = $action_terminate;
                        break;
                    case '3':
                        $action[] = $action_view;
                        break;
                    case '4':
                        $action[] = $action_view;
                        break;
                }

            }

            $action[] = $cation_call;

            $this->data['orders'][] = array(
                'order_id'              => $result['order_id'],
                'order_number'          => $result['order_number'],
                'order_added_time'      => date('H:i:s',strtotime($result['date_added'])),
                'platform_name'         => $result['platform_name'],
                'platform_channel_name' => $result['platform_channel_name'],
                'name'                  => $result['lodger'],
                'mobile'                => $result['lodger_mobile'],
                'landlord_phone'        => $result['landlord_phone'],
                'room_name'             => $result['room_name'],
                'room_type_name'        => $result['room_type_name'],
                'time_start'            => date("m.d", strtotime($result['contact_ata'])),
                'time_start_year'       => date("Y", strtotime($result['contact_ata'])),
                'time_end'              => date("m.d", strtotime($result['contact_atd'])),
                'total'                 => sprintf("%.2f", $result['total']),
                'status'                => $status,
                'selected'              => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                'action'                => $action
            );
        }

        $this->data['status_type'] = $this->order_status;
        $this->data['platforms'] = $this->model_sale_order->getPlatforms();
        $this->data['platform_channels'] = $this->model_sale_order->getPlatFormChannels();

        $this->data['column_order_num'] = $this->language->get('column_order_num');
        $this->data['column_platform_channel'] = $this->language->get('column_platform_channel');
        $this->data['column_lodger'] = $this->language->get('column_lodger');
        $this->data['column_period'] = $this->language->get('column_period');
        $this->data['column_room'] = $this->language->get('column_room');
        $this->data['column_telephone'] = $this->language->get('column_telephone');
        $this->data['column_total'] = $this->language->get('column_total');
        $this->data['column_status'] = $this->language->get('column_status');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_invoice'] = $this->language->get('button_invoice');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_filter'] = $this->language->get('button_filter');
        $this->data['button_clearFilter'] = $this->language->get('button_clearFilter');

        $this->data['text_no_results'] = "没有订单信息！";

        $this->data['t'] = $this->session->data['t'];

        $url = $this->createBaseURLParams(array('sort','order'));

        $pagination = new Pagination();
        $pagination->total = $order_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/order/getListAjax', 't=' . $this->session->data['t'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'sale/order_list_info.tpl';

        $this->response->setOutput($this->render());
	}

}