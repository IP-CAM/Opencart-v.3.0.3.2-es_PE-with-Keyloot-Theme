<?php
/**
 * Culqi Perú -
 * @author handblack <soporte@miasoftware.net>
 */
class ControllerExtensionPaymentInsiteCulqi extends Controller {
	private $error = array();

	public function index() {
	    $this->load->language('extension/payment/insite_culqi');
        $this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_insite_culqi', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
		}

        $validate = ['warning','api_key','public_key'];
        foreach($validate as $field){
            if (isset($this->error[$field])) {
    			$data["error_{$field}"] = $this->error[$field];
    		} else {
    			$data["error_{$field}"] = '';
    		}
        }

        $data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/insite_culqi', 'user_token=' . $this->session->data['user_token'], true)
		);

        $data['action'] = $this->url->link('extension/payment/insite_culqi', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        /* Cargando el estado ORDER_STATUS */
        $this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		if (isset($this->request->post['payment_insite_culqi_geo_zone_id'])) {
			$data['payment_insite_culqi_geo_zone_id'] = $this->request->post['payment_insite_culqi_geo_zone_id'];
		} else {
			$data['payment_insite_culqi_geo_zone_id'] = $this->config->get('payment_insite_culqi_geo_zone_id');
		}

        /* Cargando las GEO_ZONA */
        $this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		if (isset($this->request->post['payment_insite_culqi_status'])) {
			$data['payment_insite_culqi_status'] = $this->request->post['payment_insite_culqi_status'];
		} else {
			$data['payment_insite_culqi_status'] = $this->config->get('payment_insite_culqi_status');
		}

        /* Cargando las CURRENCY */
        $this->load->model('localisation/currency');
        $data['currencies'] = $this->model_localisation_currency->getCurrencies();
		//$data['currencies'] = $this->model_localisation_currency->index();
		if (isset($this->request->post['payment_insite_culqi_currency_id'])) {
			$data['payment_insite_culqi_currency_id'] = $this->request->post['payment_insite_culqi_currency_id'];
		} else {
			$data['payment_insite_culqi_currency_id'] = $this->config->get('payment_insite_culqi_currency_id');
		}

        /* Aqui cargamos los campos */
        $fields = [
            'payment_insite_culqi_api_key',
            'payment_insite_culqi_public_key',
            'payment_insite_culqi_mode',
            'payment_insite_culqi_method',
            'payment_insite_culqi_currency',
            'payment_insite_culqi_order_status_id',
            'payment_insite_culqi_geo_zone_id',
            'payment_insite_culqi_status',
            'payment_insite_culqi_sort_order',
        ];
        foreach($fields as $field){
            if (isset($this->request->post[$field])){
                $data[$field] = $this->request->post[$field];
            }else{
                $data[$field] = $this->config->get($field);
            }
        }

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/insite_culqi', $data));
	}

    public function install() {
        $this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "insite_culqi_transac` (
			  `transac_id` BIGINT(11) NOT NULL AUTO_INCREMENT,
			  `order_id` INT(11) NOT NULL,
			  `customer_id` INT(11) NOT NULL,
			  `response` text NOT NULL,
			  PRIMARY KEY (`transac_id`)
			) ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci;");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "insite_culqi_transac`;");
	}



	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/insite_culqi')) {
			$this->error['warning'] = $this->language->get('error_permission');
        }

        $fields = [
            'api_key',
            'public_key',
        ];
        foreach($fields as $field){
            if (!$this->request->post["payment_insite_culqi_{$field}"]) {
			    $this->error[$field] = $this->language->get("error_{$field}");
		    }
        }
		return !$this->error;
	}

}