<?php

/**
 * Class ControllerExtensionPaymentPaymenterio
 */

class ControllerExtensionPaymentPaymenterio extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/paymenterio');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_paymenterio', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment'));
        }

        if (isset($this->error['api_key'])) {
            $data['error_api_key'] = $this->error['api_key'];
        } else {
            $data['error_api_key'] = '';
        }

        if (isset($this->error['shop_id'])) {
            $data['error_shop_id'] = $this->error['shop_id'];
        } else {
            $data['error_shop_id'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/paymenterio', 'user_token=' . $this->session->data['user_token'])
        );

        $data['action'] = $this->url->link('extension/payment/paymenterio', 'user_token=' . $this->session->data['user_token']);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment');

        if (isset($this->request->post['payment_paymenterio_pp'])) {
            $data['payment_paymenterio_shop_id'] = $this->request->post['payment_paymenterio_shop_id'];
        } else {
            $data['payment_paymenterio_shop_id'] = $this->config->get('payment_paymenterio_shop_id');
        }

        if (isset($this->request->post['payment_paymenterio_api_key'])) {
            $data['payment_paymenterio_api_key'] = $this->request->post['payment_paymenterio_api_key'];
        } else {
            $data['payment_paymenterio_api_key'] = $this->config->get('payment_paymenterio_api_key');
        }

        if (isset($this->request->post['payment_paymenterio_order_status_id'])) {
            $data['payment_paymenterio_order_status_id'] = $this->request->post['payment_paymenterio_order_status_id'];
        } else {
            $data['payment_paymenterio_order_status_id'] = $this->config->get('payment_paymenterio_order_status_id');
        }

        if (isset($this->request->post['payment_paymenterio_order_status_new_id'])) {
            $data['payment_paymenterio_order_status_new_id'] = $this->request->post['payment_paymenterio_order_status_new_id'];
        } else {
            $data['payment_paymenterio_order_status_new_id'] = $this->config->get('payment_paymenterio_order_status_new_id');
        }

        if (isset($this->request->post['payment_paymenterio_order_status_cancel_id'])) {
            $data['payment_paymenterio_order_status_cancel_id'] = $this->request->post['payment_paymenterio_order_status_cancel_id'];
        } else {
            $data['payment_paymenterio_order_status_cancel_id'] = $this->config->get('payment_paymenterio_order_status_cancel_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['payment_paymenterio_status'])) {
            $data['payment_paymenterio_status'] = $this->request->post['payment_paymenterio_status'];
        } else {
            $data['payment_paymenterio_status'] = $this->config->get('payment_paymenterio_status');
        }

        if (isset($this->request->post['payment_paymenterio_sort_order'])) {
            $data['payment_paymenterio_sort_order'] = $this->request->post['payment_paymenterio_sort_order'];
        } else {
            $data['payment_paymenterio_sort_order'] = $this->config->get('payment_paymenterio_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/paymenterio', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/paymenterio')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['payment_paymenterio_shop_id']) {
            $this->error['shop_id'] = $this->language->get('error_paymenterio_shop_id');
        }

        if (!$this->request->post['payment_paymenterio_api_key']) {
            $this->error['api_key'] = $this->language->get('error_paymenterio_api_key');
        }

        return !$this->error;
    }
}