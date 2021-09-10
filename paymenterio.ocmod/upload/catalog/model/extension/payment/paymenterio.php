<?php
class ModelExtensionPaymentPaymenterio extends Model {
    public function getMethod($address) {
      $this->load->language('extension/payment/paymenterio');
      
      return array( 
              'code'       => 'paymenterio',
              'title'      => "Paymenterio",
              'terms'      => '',
              'sort_order' => $this->config->get('payment_paymenterio_sort_order')
            );
    }
}