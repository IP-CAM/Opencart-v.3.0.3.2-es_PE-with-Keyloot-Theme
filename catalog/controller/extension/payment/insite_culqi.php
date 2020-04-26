<?php
class ControllerExtensionPaymentInsiteCulqi extends Controller {
	public function index() {
		$this->load->language('extension/payment/insite_culqi');

		$data['months'] = array();

		for ($i = 1; $i <= 12; $i++) {
			$data['months'][] = array(
				'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
				'value' => sprintf('%02d', $i)
			);
		}

		$today = getdate();

		$data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $amount = number_format($order_info['total'], 2, '', ''); // El importe de visa no debe haber 35.00 = 3500
        $data['culqi_public_key']   = $this->config->get('payment_insite_culqi_public_key');
        $data['title']              = $this->config->get('config_meta_title');
        $data['currencyiso']        = 'PEN';
        $data['description']        = 'Pedido #'.$this->session->data['order_id'];
        $data['amount']             = $amount;
        $data['logo_visa']          = $this->language->get('logo_visa');
        // Publicacion de la llama publica
        $html = "
                <script>
                    var Culqi = new culqijs.Checkout();
                    Culqi.publicKey = '{$data['culqi_public_key']}';
                </script>";
        $data['html_culqi']         = $html;
        //$data['javascript'] = $this->url->link('checkout/success', '', true);

		return $this->load->view('extension/payment/insite_culqi', $data);
	}


    public function send(){
		$this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        /* Preparamos la transaccion con CULQI */
        try{
            include_once DIR_SYSTEM . 'library/culqi/request/Requests.php';
            Requests::register_autoloader();
            include_once DIR_SYSTEM . 'library/culqi/class/culqi.php';
            /* Creamos el OBJETO */
            $SECRET_KEY = $this->config->get('payment_insite_culqi_api_key');
            $CURRENCY   = $this->config->get('payment_insite_culqi_currency');
            $TOKEN      = $this->request->post['token'];
            $CUOTAS     = $this->request->post['cuotas'];
            $AMOUNT     = number_format($order_info['total'], 2, '', ''); // El importe de visa no debe haber 35.00 = 3500
            $EMAIL      = $order_info['email'];

            $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));
            // Creando Cargo a una tarjeta
            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
            $response = $culqi->Charges->create(
                    array(
                        "amount"        => $AMOUNT,
                        "currency_code" => $CURRENCY,
                        "email"         => $EMAIL,
                        "installments"  => $CUOTAS,
                        "source_id"     => $TOKEN
                    )
            );
            /* Almacenamos la transaccion en la DB */
            $dd  = json_encode($response);
            $dd  = base64_encode($dd);
            $oID = $this->session->data['order_id'];
            $cID = $order_info['customer_id'];
            $this->db->query("INSERT INTO `" . DB_PREFIX . "insite_culqi_transac`(order_id,customer_id,response) VALUES ({$oID},{$cID},'{$dd}');");

            $charge = (array) $response;
            $charge['redirect'] = $this->url->link('checkout/success', '', true);

            //$charge['redirect'] = $this->url->link('checkout/success', '', true);
            #echo 'aqui msotramos datos';
            ##echo $charge;
            #echo 'aqui mostramso mmmas datos';
        } catch (Exception $e) {
            error_log($e->getMessage());
            #$json = json_decode($json);
            #if($json){
            #    switch(){
            #        case 'error':
            #    }
            #}
            #var_dump(json_decode($json));
            #echo 'INSITE genero error=';
            #echo $e->getMessage();
            $charge = $e->getMessage(); // Pasamos el mensaje de error directamente
        }
        /*
        error_log("sometext", 1, "zigzag@my.domain",
        "Subject: Foo\nFrom: Rizzlas@my.domain\n");
        $json = array();
        /*
        if(true){
            $message = $this->request->post['container'];
            $this->model_checkout_order->addOrderHistory(
                $this->session->data['order_id'],
                $this->config->get('payment_insite_culqi_order_status_id'),
                $message, false);
            $json['redirect'] = $this->url->link('checkout/success', '', true);
        }else{
            $json['error'] = 'No se proceso el PAGO';
        }
        */
        //$json['data_x'] = $this->request->post;
        $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($charge));
    }


	public function send2() {
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$request  = 'MERCHANT_ID=' . urlencode($this->config->get('payment_web_payment_software_merchant_name'));
		$request .= '&MERCHANT_KEY=' . urlencode($this->config->get('payment_web_payment_software_merchant_key'));
		$request .= '&TRANS_TYPE=' . urlencode($this->config->get('payment_web_payment_software_method') == 'capture' ? 'AuthCapture' : 'AuthOnly');
		$request .= '&AMOUNT=' . urlencode($this->currency->format($order_info['total'], $order_info['currency_code'], 1.00000, false));
		$request .= '&CC_NUMBER=' . urlencode(str_replace(' ', '', $this->request->post['cc_number']));
		$request .= '&CC_EXP=' . urlencode($this->request->post['cc_expire_date_month'] . substr($this->request->post['cc_expire_date_year'], 2));
		$request .= '&CC_CVV=' . urlencode($this->request->post['cc_cvv2']);
		$request .= '&CC_NAME=' . urlencode($order_info['payment_firstname'] . ' ' . $order_info['payment_lastname']);
		$request .= '&CC_COMPANY=' . urlencode($order_info['payment_company']);
		$request .= '&CC_ADDRESS=' . urlencode($order_info['payment_address_1']);
		$request .= '&CC_CITY=' . urlencode($order_info['payment_city']);
		$request .= '&CC_STATE=' . urlencode($order_info['payment_iso_code_2'] != 'US' ? $order_info['payment_zone'] : $order_info['payment_zone_code']);
		$request .= '&CC_ZIP=' . urlencode($order_info['payment_postcode']);
		$request .= '&CC_COUNTRY=' . urlencode($order_info['payment_country']);
		$request .= '&CC_PHONE=' . urlencode($order_info['telephone']);
		$request .= '&CC_EMAIL=' . urlencode($order_info['email']);
		$request .= '&INVOICE_NUM=' . urlencode($this->session->data['order_id']);

		if ($this->config->get('payment_web_payment_software_mode') == 'test') {
			$request .= '&TEST_MODE=1';
		}

		$curl = curl_init('https://secure.web-payment-software.com/gateway');

		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

		$response = curl_exec($curl);

		curl_close($curl);

		//If in test mode strip results to only contain xml data
		if ($this->config->get('payment_web_payment_software_mode') == 'test') {
			$end_index = strpos($response, '</WebPaymentSoftwareResponse>');
			$debug = substr($response, $end_index + 30);
			$response = substr($response, 0, $end_index) . '</WebPaymentSoftwareResponse>';
		}

		//get response xml
		$xml = simplexml_load_string($response);

		//create object to use as json
		$json = array();

		//If successful log transaction in opencart system
		if ('00' === (string)$xml->response_code) {
			$message = '';

			$message .= 'Response Code: ';

			if (isset($xml->response_code)) {
				$message .= (string)$xml->response_code . "\n";
			}

			$message .= 'Approval Code: ';

			if (isset($xml->approval_code)) {
				$message .= (string)$xml->approval_code . "\n";
			}

			$message .= 'AVS Result Code: ';

			if (isset($xml->avs_result_code)) {
				$message .= (string)$xml->avs_result_code . "\n";
			}

			$message .= 'Transaction ID (web payment software order id): ';

			if (isset($xml->order_id)) {
				$message .= (string)$xml->order_id . "\n";
			}

			$message .= 'CVV Result Code: ';

			if (isset($xml->cvv_result_code)) {
				$message .= (string)$xml->cvv_result_code . "\n";
			}

			$message .= 'Response Text: ';

			if (isset($xml->response_text)) {
				$message .= (string)$xml->response_text . "\n";
			}

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('payment_web_payment_software_order_status_id'), $message, false);

			$json['redirect'] = $this->url->link('checkout/success', '', true);
		} else {
			$json['error'] = (string)$xml->response_text;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}