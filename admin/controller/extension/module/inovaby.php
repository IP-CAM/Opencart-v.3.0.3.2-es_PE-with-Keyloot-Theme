<?php
class ControllerExtensionModuleInovaby extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/inovaby');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_inovaby', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		
		// Tabs

		$data['tab_custom_css'] = $this->language->get('tab_custom_css');
        $data['tab_design'] = $this->language->get('tab_design');
		
		// Custom CSS
		$data['text_custom_css'] = $this->language->get('text_custom_css');
        $data['text_content_css'] = $this->language->get('text_content_css');
		$data['text_help_css'] = $this->language->get('text_help_css');
        //Custom Javascript
        $data['text_custom_javascript'] = $this->language->get('text_custom_javascript');
        $data['text_help_javascript'] = $this->language->get('text_help_javascript');
        $data['text_content_javascript'] = $this->language->get('text_content_javascript');
        //Custom Code
        $data['text_custom_code'] = $this->language->get('text_custom_code');
        $data['text_help_code'] = $this->language->get('text_help_code');
        $data['text_content_code'] = $this->language->get('text_content_code');
		
		
		 //General
        $data['tab_themepanel'] = $this->language->get('tab_themepanel');
        $data['text_general'] = $this->language->get('text_general');
        $data['help_general'] = $this->language->get('help_general');
        $data['text_topiconsize'] = $this->language->get('text_topiconsize');

        $data['text_top_bar'] = $this->language->get('text_top_bar');
        $data['text_top_cart'] = $this->language->get('text_top_cart');
        $data['text_top_search'] = $this->language->get('text_top_search');
        $data['text_top_menu'] = $this->language->get('text_top_menu');

        $data['text_background'] = $this->language->get('text_background');
        $data['text_color'] = $this->language->get('text_color');
        $data['text_hover'] = $this->language->get('text_hover');
        $data['text_border'] = $this->language->get('text_border');
        $data['text_backgroundhover'] = $this->language->get('text_backgroundhover');

        $data['text_linkcolor'] = $this->language->get('text_linkcolor');
        $data['text_linkhover'] = $this->language->get('text_linkhover');
        $data['text_color'] = $this->language->get('text_color');
        $data['text_titlecolor'] = $this->language->get('text_titlecolor');

        $data['text_dropdownhover'] = $this->language->get('text_dropdownhover');
        $data['text_dropdownbg'] = $this->language->get('text_dropdownbg');

        $data['help_title'] = $this->language->get('help_title');
        $data['help_dropdownlihover'] = $this->language->get('help_dropdownlihover');
        $data['help_languagebghv'] = $this->language->get('help_languagebghv');

        $data['entry_backgroundimage'] = $this->language->get('entry_backgroundimage');
        $data['help_backgroundimage'] = $this->language->get('help_backgroundimage');
        $data['entry_repeatbackground'] = $this->language->get('entry_repeatbackground');
        $data['entry_backgroundcolor'] = $this->language->get('entry_backgroundcolor');
        //Top Nav
        $data['text_topnavbg'] = $this->language->get('text_topnavbg');
        $data['text_topborderline'] = $this->language->get('text_topborderline');
        $data['text_topcolorline'] = $this->language->get('text_topcolorline');
        $data['help_topborderline'] = $this->language->get('help_topborderline');
        $data['text_toplanguagebghv'] = $this->language->get('text_toplanguagebghv');
        $data['text_toplanguagecolorhv'] = $this->language->get('text_toplanguagecolorhv');
        //Search
        $data['text_searchinput'] = $this->language->get('text_searchinput');
        $data['text_searchbutton'] = $this->language->get('text_searchbutton');
        //Cart
        $data['text_cartopen'] = $this->language->get('text_cartopen');
        $data['text_cartopenborder'] = $this->language->get('text_cartopenborder');
        $data['text_cartopenbg'] = $this->language->get('text_cartopenbg');
        $data['text_cartopenborderwidth'] = $this->language->get('text_cartopenborderwidth');
        //Menu
        $data['text_border'] = $this->language->get('text_border');
        $data['text_bordercolor'] = $this->language->get('text_bordercolor');
        $data['text_dropdownbg'] = $this->language->get('text_dropdownbg');
        $data['text_dropdowncolor'] = $this->language->get('text_dropdowncolor');

        $data['text_dropdown'] = $this->language->get('text_dropdown');
        $data['text_seeall'] = $this->language->get('text_seeall');

        $data['text_toplink'] = $this->language->get('text_toplink');
        $data['text_toplinkhover'] = $this->language->get('text_toplinkhover');
        $data['text_topaccountcolorhv'] = $this->language->get('text_topaccountcolorhv');
        $data['help_accounthv'] = $this->language->get('help_accounthv');
        //Products Modules
        $data['text_product_list'] = $this->language->get('text_product_list');
        $data['help_product_list'] = $this->language->get('help_product_list');

        $data['text_product_name'] = $this->language->get('text_product_name');
        $data['text_product_description'] = $this->language->get('text_product_description');
        $data['text_product_price'] = $this->language->get('text_product_price');
        $data['text_product_tax'] = $this->language->get('text_product_tax');

        $data['text_add_to_cart'] = $this->language->get('text_add_to_cart');
        $data['text_wishlist'] = $this->language->get('text_wishlist');
        $data['text_btgroup'] = $this->language->get('text_btgroup');
        $data['text_border_left'] = $this->language->get('text_border_left');

        //Footer
        $data['text_footer_social'] = $this->language->get('text_footer_social');
        $data['text_border_top'] = $this->language->get('text_border_top');
        $data['text_footer'] = $this->language->get('text_footer');
		// Language ends
		
		
		
		
		// Custom CSS starts

		if (isset($this->request->post['module_inovaby_custom_css'])) {
			$data['module_inovaby_custom_css'] = $this->request->post['module_inovaby_custom_css'];
		} else {
			$data['module_inovaby_custom_css'] = $this->config->get('module_inovaby_custom_css');
		}

		if (isset($this->request->post['module_inovaby_custom_css_content'])) {
			$data['module_inovaby_custom_css_content'] = $this->request->post['module_inovaby_custom_css_content'];
		} else {
			$data['module_inovaby_custom_css_content'] = $this->config->get('module_inovaby_custom_css_content');
		}
		// Custom CSS ends
		
		// Custom Javascript starts

		if (isset($this->request->post['module_inovaby_custom_javascript'])) {
			$data['module_inovaby_custom_javascript'] = $this->request->post['module_inovaby_custom_javascript'];
		} else {
			$data['module_inovaby_custom_javascript'] = $this->config->get('module_inovaby_custom_javascript');
		}

		if (isset($this->request->post['module_inovaby_custom_javascript_content'])) {
			$data['module_inovaby_custom_javascript_content'] = $this->request->post['module_inovaby_custom_javascript_content'];
		} else {
			$data['module_inovaby_custom_javascript_content'] = $this->config->get('module_inovaby_custom_javascript_content');
		}
		// Custom Javascript ends

        // Custom Code starts

		if (isset($this->request->post['module_inovaby_custom_code'])) {
			$data['module_inovaby_custom_code'] = $this->request->post['module_inovaby_custom_code'];
		} else {
			$data['module_inovaby_custom_code'] = $this->config->get('module_inovaby_custom_code');
		}

		if (isset($this->request->post['module_inovaby_custom_code_content'])) {
			$data['module_inovaby_custom_code_content'] = $this->request->post['module_inovaby_custom_code_content'];
		} else {
			$data['module_inovaby_custom_code_content'] = $this->config->get('module_inovaby_custom_code_content');
		}
		// Custom Code ends

                //General Starts
        if (isset($this->request->post['module_inovaby_backgroundcolor'])) {
			$data['module_inovaby_backgroundcolor'] = $this->request->post['module_inovaby_backgroundcolor'];
		} else {
			$data['module_inovaby_backgroundcolor'] = $this->config->get('module_inovaby_backgroundcolor');
		}

       

        if (isset($this->request->post['module_inovaby_textcolor'])) {
			$data['module_inovaby_textcolor'] = $this->request->post['module_inovaby_textcolor'];
		} else {
			$data['module_inovaby_textcolor'] = $this->config->get('module_inovaby_textcolor');
		}

        if (isset($this->request->post['module_inovaby_linkcolor'])) {
			$data['module_inovaby_linkcolor'] = $this->request->post['module_inovaby_linkcolor'];
		} else {
			$data['module_inovaby_linkcolor'] = $this->config->get('module_inovaby_linkcolor');
		}
        if (isset($this->request->post['module_inovaby_linkhover'])) {
			$data['module_inovaby_linkhover'] = $this->request->post['module_inovaby_linkhover'];
		} else {
			$data['module_inovaby_linkhover'] = $this->config->get('module_inovaby_linkhover');
		}

        if (isset($this->request->post['module_inovaby_titlecolor'])) {
			$data['module_inovaby_titlecolor'] = $this->request->post['module_inovaby_titlecolor'];
		} else {
			$data['module_inovaby_titlecolor'] = $this->config->get('module_inovaby_titlecolor');
		}

        if (isset($this->request->post['module_inovaby_dropdownhv'])) {
			$data['module_inovaby_dropdownhv'] = $this->request->post['module_inovaby_dropdownhv'];
		} else {
			$data['module_inovaby_dropdownhv'] = $this->config->get('module_inovaby_dropdownhv');
		}
        if (isset($this->request->post['module_inovaby_dropdownbghover'])) {
			$data['module_inovaby_dropdownbghover'] = $this->request->post['module_inovaby_dropdownbghover'];
		} else {
			$data['module_inovaby_dropdownbghover'] = $this->config->get('module_inovaby_dropdownbghover');
		}
        //Top Nav
        if (isset($this->request->post['module_inovaby_topnavbg'])) {
			$data['module_inovaby_topnavbg'] = $this->request->post['module_inovaby_topnavbg'];
		} else {
			$data['module_inovaby_topnavbg'] = $this->config->get('module_inovaby_topnavbg');
		}
        if (isset($this->request->post['module_inovaby_topnavline'])) {
			$data['module_inovaby_topnavline'] = $this->request->post['module_inovaby_topnavline'];
		} else {
			$data['module_inovaby_topnavline'] = $this->config->get('module_inovaby_topnavline');
		}
        if (isset($this->request->post['module_inovaby_topnavlinecolor'])) {
			$data['module_inovaby_topnavlinecolor'] = $this->request->post['module_inovaby_topnavlinecolor'];
		} else {
			$data['module_inovaby_topnavlinecolor'] = $this->config->get('module_inovaby_topnavlinecolor');
		}
        if (isset($this->request->post['module_inovaby_languagehvbg'])) {
			$data['module_inovaby_languagehvbg'] = $this->request->post['module_inovaby_languagehvbg'];
		} else {
			$data['module_inovaby_languagehvbg'] = $this->config->get('module_inovaby_languagehvbg');
		}
        if (isset($this->request->post['module_inovaby_languagecolorhv'])) {
			$data['module_inovaby_languagecolorhv'] = $this->request->post['module_inovaby_languagecolorhv'];
		} else {
			$data['module_inovaby_languagecolorhv'] = $this->config->get('module_inovaby_languagecolorhv');
		}

        if (isset($this->request->post['module_inovaby_toplink'])) {
			$data['module_inovaby_toplink'] = $this->request->post['module_inovaby_toplink'];
		} else {
			$data['module_inovaby_toplink'] = $this->config->get('module_inovaby_toplink');
		}
        if (isset($this->request->post['module_inovaby_toplinkhover'])) {
			$data['module_inovaby_toplinkhover'] = $this->request->post['module_inovaby_toplinkhover'];
		} else {
			$data['module_inovaby_toplinkhover'] = $this->config->get('module_inovaby_toplinkhover');
		}
        if (isset($this->request->post['module_inovaby_topiconsize'])) {
			$data['module_inovaby_topiconsize'] = $this->request->post['module_inovaby_topiconsize'];
		} else {
			$data['module_inovaby_topiconsize'] = $this->config->get('module_inovaby_topiconsize');
		}
        if (isset($this->request->post['module_inovaby_topdropdownhv'])) {
			$data['module_inovaby_topdropdownhv'] = $this->request->post['module_inovaby_topdropdownhv'];
		} else {
			$data['module_inovaby_topdropdownhv'] = $this->config->get('module_inovaby_topdropdownhv');
		}
        //Top Search
        if (isset($this->request->post['module_inovaby_searchinbg'])) {
			$data['module_inovaby_searchinbg'] = $this->request->post['module_inovaby_searchinbg'];
		} else {
			$data['module_inovaby_searchinbg'] = $this->config->get('module_inovaby_searchinbg');
		}
        if (isset($this->request->post['module_inovaby_searchbutton'])) {
			$data['module_inovaby_searchbutton'] = $this->request->post['module_inovaby_searchbutton'];
		} else {
			$data['module_inovaby_searchbutton'] = $this->config->get('module_inovaby_searchbutton');
		}
        if (isset($this->request->post['module_inovaby_searchiconsize'])) {
			$data['module_inovaby_searchiconsize'] = $this->request->post['module_inovaby_searchiconsize'];
		} else {
			$data['module_inovaby_searchiconsize'] = $this->config->get('module_inovaby_searchiconsize');
		}
        //Top Cart
        if (isset($this->request->post['module_inovaby_topcartcolor'])) {
			$data['module_inovaby_topcartcolor'] = $this->request->post['module_inovaby_topcartcolor'];
		} else {
			$data['module_inovaby_topcartcolor'] = $this->config->get('module_inovaby_topcartcolor');
		}
        if (isset($this->request->post['module_inovaby_topcartbg'])) {
			$data['module_inovaby_topcartbg'] = $this->request->post['module_inovaby_topcartbg'];
		} else {
			$data['module_inovaby_topcartbg'] = $this->config->get('module_inovaby_topcartbg');
		}


        if (isset($this->request->post['module_inovaby_topcartopen'])) {
			$data['module_inovaby_topcartopen'] = $this->request->post['module_inovaby_topcartopen'];
		} else {
			$data['module_inovaby_topcartopen'] = $this->config->get('module_inovaby_topcartopen');
		}
        if (isset($this->request->post['module_inovaby_topcartopenbg'])) {
			$data['module_inovaby_topcartopenbg'] = $this->request->post['module_inovaby_topcartopenbg'];
		} else {
			$data['module_inovaby_topcartopenbg'] = $this->config->get('module_inovaby_topcartopenbg');
		}
        if (isset($this->request->post['module_inovaby_topcartopenborder'])) {
			$data['module_inovaby_topcartopenborder'] = $this->request->post['module_inovaby_topcartopenborder'];
		} else {
			$data['module_inovaby_topcartopenborder'] = $this->config->get('module_inovaby_topcartopenborder');
		}
        if (isset($this->request->post['module_inovaby_topcartopenbosize'])) {
			$data['module_inovaby_topcartopenbosize'] = $this->request->post['module_inovaby_topcartopenbosize'];
		} else {
			$data['module_inovaby_topcartopenbosize'] = $this->config->get('module_inovaby_topcartopenbosize');
		}
        //Top Menu
        if (isset($this->request->post['module_inovaby_topmenbg'])) {
			$data['module_inovaby_topmenbg'] = $this->request->post['module_inovaby_topmenbg'];
		} else {
			$data['module_inovaby_topmenbg'] = $this->config->get('module_inovaby_topmenbg');
		}
        if (isset($this->request->post['module_inovaby_topmenborder'])) {
			$data['module_inovaby_topmenborder'] = $this->request->post['module_inovaby_topmenborder'];
		} else {
			$data['module_inovaby_topmenborder'] = $this->config->get('module_inovaby_topmenborder');
		}
        if (isset($this->request->post['module_inovaby_topmenbocolor'])) {
			$data['module_inovaby_topmenbocolor'] = $this->request->post['module_inovaby_topmenbocolor'];
		} else {
			$data['module_inovaby_topmenbocolor'] = $this->config->get('module_inovaby_topmenbocolor');
		}

        if (isset($this->request->post['module_inovaby_menulicolor'])) {
			$data['module_inovaby_menulicolor'] = $this->request->post['module_inovaby_menulicolor'];
		} else {
			$data['module_inovaby_menulicolor'] = $this->config->get('module_inovaby_menulicolor');
		}
        if (isset($this->request->post['module_inovaby_menulihover'])) {
			$data['module_inovaby_menulihover'] = $this->request->post['module_inovaby_menulihover'];
		} else {
			$data['module_inovaby_menulihover'] = $this->config->get('module_inovaby_menulihover');
		}
        if (isset($this->request->post['module_inovaby_menulibghover'])) {
			$data['module_inovaby_menulibghover'] = $this->request->post['module_inovaby_menulibghover'];
		} else {
			$data['module_inovaby_menulibghover'] = $this->config->get('module_inovaby_menulibghover');
		}



        if (isset($this->request->post['module_inovaby_menuinnerbg'])) {
			$data['module_inovaby_menuinnerbg'] = $this->request->post['module_inovaby_menuinnerbg'];
		} else {
			$data['module_inovaby_menuinnerbg'] = $this->config->get('module_inovaby_menuinnerbg');
		}
        if (isset($this->request->post['module_inovaby_menuinnerbghover'])) {
			$data['module_inovaby_menuinnerbghover'] = $this->request->post['module_inovaby_menuinnerbghover'];
		} else {
			$data['module_inovaby_menuinnerbghover'] = $this->config->get('module_inovaby_menuinnerbghover');
		}
        if (isset($this->request->post['module_inovaby_menuinnerlink'])) {
			$data['module_inovaby_menuinnerlink'] = $this->request->post['module_inovaby_menuinnerlink'];
		} else {
			$data['module_inovaby_menuinnerlink'] = $this->config->get('module_inovaby_menuinnerlink');
		}
        if (isset($this->request->post['module_inovaby_menuinnerlinkhover'])) {
			$data['module_inovaby_menuinnerlinkhover'] = $this->request->post['module_inovaby_menuinnerlinkhover'];
		} else {
			$data['module_inovaby_menuinnerlinkhover'] = $this->config->get('module_inovaby_menuinnerlinkhover');
		}


        if (isset($this->request->post['module_inovaby_menushowallbg'])) {
			$data['module_inovaby_menushowallbg'] = $this->request->post['module_inovaby_menushowallbg'];
		} else {
			$data['module_inovaby_menushowallbg'] = $this->config->get('module_inovaby_menushowallbg');
		}
        if (isset($this->request->post['module_inovaby_menushowallbghover'])) {
			$data['module_inovaby_menushowallbghover'] = $this->request->post['module_inovaby_menushowallbghover'];
		} else {
			$data['module_inovaby_menushowallbghover'] = $this->config->get('module_inovaby_menushowallbghover');
		}
        if (isset($this->request->post['module_inovaby_menushowalllink'])) {
			$data['module_inovaby_menushowalllink'] = $this->request->post['module_inovaby_menushowalllink'];
		} else {
			$data['module_inovaby_menushowalllink'] = $this->config->get('module_inovaby_menushowalllink');
		}
        if (isset($this->request->post['module_inovaby_menushowalllinkhover'])) {
			$data['module_inovaby_menushowalllinkhover'] = $this->request->post['module_inovaby_menushowalllinkhover'];
		} else {
			$data['module_inovaby_menushowalllinkhover'] = $this->config->get('module_inovaby_menushowalllinkhover');
		}


        //Product list
        if (isset($this->request->post['module_inovaby_product_list_bg'])) {
			$data['module_inovaby_product_list_bg'] = $this->request->post['module_inovaby_product_list_bg'];
		} else {
			$data['module_inovaby_product_list_bg'] = $this->config->get('module_inovaby_product_list_bg');
		}
        if (isset($this->request->post['module_inovaby_product_list_bordersize'])) {
			$data['module_inovaby_product_list_bordersize'] = $this->request->post['module_inovaby_product_list_bordersize'];
		} else {
			$data['module_inovaby_product_list_bordersize'] = $this->config->get('module_inovaby_product_list_bordersize');
		}
        if (isset($this->request->post['module_inovaby_product_list_bordercolor'])) {
			$data['module_inovaby_product_list_bordercolor'] = $this->request->post['module_inovaby_product_list_bordercolor'];
		} else {
			$data['module_inovaby_product_list_bordercolor'] = $this->config->get('module_inovaby_product_list_bordercolor');
		}


        if (isset($this->request->post['module_inovaby_product_name'])) {
			$data['module_inovaby_product_name'] = $this->request->post['module_inovaby_product_name'];
		} else {
			$data['module_inovaby_product_name'] = $this->config->get('module_inovaby_product_name');
		}
        if (isset($this->request->post['module_inovaby_product_description'])) {
			$data['module_inovaby_product_description'] = $this->request->post['module_inovaby_product_description'];
		} else {
			$data['module_inovaby_product_description'] = $this->config->get('module_inovaby_product_description');
		}
        if (isset($this->request->post['module_inovaby_product_price'])) {
			$data['module_inovaby_product_price'] = $this->request->post['module_inovaby_product_price'];
		} else {
			$data['module_inovaby_product_price'] = $this->config->get('module_inovaby_product_price');
		}


        if (isset($this->request->post['module_inovaby_product_btgroup'])) {
			$data['module_inovaby_product_btgroup'] = $this->request->post['module_inovaby_product_btgroup'];
		} else {
			$data['module_inovaby_product_btgroup'] = $this->config->get('module_inovaby_product_btgroup');
		}
        if (isset($this->request->post['module_inovaby_product_btgroupborder'])) {
			$data['module_inovaby_product_btgroupborder'] = $this->request->post['module_inovaby_product_btgroupborder'];
		} else {
			$data['module_inovaby_product_btgroupborder'] = $this->config->get('module_inovaby_product_btgroupborder');
		}
        if (isset($this->request->post['module_inovaby_product_btgroupcolor'])) {
			$data['module_inovaby_product_btgroupcolor'] = $this->request->post['module_inovaby_product_btgroupcolor'];
		} else {
			$data['module_inovaby_product_btgroupcolor'] = $this->config->get('module_inovaby_product_btgroupcolor');
		}


        if (isset($this->request->post['module_inovaby_product_cartbg'])) {
			$data['module_inovaby_product_cartbg'] = $this->request->post['module_inovaby_product_cartbg'];
		} else {
			$data['module_inovaby_product_cartbg'] = $this->config->get('module_inovaby_product_cartbg');
		}
        if (isset($this->request->post['module_inovaby_product_cartbghover'])) {
			$data['module_inovaby_product_cartbghover'] = $this->request->post['module_inovaby_product_cartbghover'];
		} else {
			$data['module_inovaby_product_cartbghover'] = $this->config->get('module_inovaby_product_cartbghover');
		}


        if (isset($this->request->post['module_inovaby_product_cartcolor'])) {
			$data['module_inovaby_product_cartcolor'] = $this->request->post['module_inovaby_product_cartcolor'];
		} else {
			$data['module_inovaby_product_cartcolor'] = $this->config->get('module_inovaby_product_cartcolor');
		}
        if (isset($this->request->post['module_inovaby_product_cartcolorhover'])) {
			$data['module_inovaby_product_cartcolorhover'] = $this->request->post['module_inovaby_product_cartcolorhover'];
		} else {
			$data['module_inovaby_product_cartcolorhover'] = $this->config->get('module_inovaby_product_cartcolorhover');
		}


        if (isset($this->request->post['module_inovaby_product_wishlistborder'])) {
			$data['module_inovaby_product_wishlistborder'] = $this->request->post['module_inovaby_product_wishlistborder'];
		} else {
			$data['module_inovaby_product_wishlistborder'] = $this->config->get('module_inovaby_product_wishlistborder');
		}
        if (isset($this->request->post['module_inovaby_product_wishlistbordercolor'])) {
			$data['module_inovaby_product_wishlistbordercolor'] = $this->request->post['module_inovaby_product_wishlistbordercolor'];
		} else {
			$data['module_inovaby_product_wishlistbordercolor'] = $this->config->get('module_inovaby_product_wishlistbordercolor');
		}


        if (isset($this->request->post['module_inovaby_product_wishlistbg'])) {
			$data['module_inovaby_product_wishlistbg'] = $this->request->post['module_inovaby_product_wishlistbg'];
		} else {
			$data['module_inovaby_product_wishlistbg'] = $this->config->get('module_inovaby_product_wishlistbg');
		}
        if (isset($this->request->post['module_inovaby_product_wishlistbghover'])) {
			$data['module_inovaby_product_wishlistbghover'] = $this->request->post['module_inovaby_product_wishlistbghover'];
		} else {
			$data['module_inovaby_product_wishlistbghover'] = $this->config->get('module_inovaby_product_wishlistbghover');
		}


        if (isset($this->request->post['module_inovaby_product_wishlistcolor'])) {
			$data['module_inovaby_product_wishlistcolor'] = $this->request->post['module_inovaby_product_wishlistcolor'];
		} else {
			$data['module_inovaby_product_wishlistcolor'] = $this->config->get('module_inovaby_product_wishlistcolor');
		}
        if (isset($this->request->post['module_inovaby_product_wishlistcolorhover'])) {
			$data['module_inovaby_product_wishlistcolorhover'] = $this->request->post['module_inovaby_product_wishlistcolorhover'];
		} else {
			$data['module_inovaby_product_wishlistcolorhover'] = $this->config->get('module_inovaby_product_wishlistcolorhover');
		}

        // End Product List
        //Start Footer
        if (isset($this->request->post['module_inovaby_footer_bg'])) {
			$data['module_inovaby_footer_bg'] = $this->request->post['module_inovaby_footer_bg'];
		} else {
			$data['module_inovaby_footer_bg'] = $this->config->get('module_inovaby_footer_bg');
		}
        if (isset($this->request->post['module_inovaby_footer_border'])) {
			$data['module_inovaby_footer_border'] = $this->request->post['module_inovaby_footer_border'];
		} else {
			$data['module_inovaby_footer_border'] = $this->config->get('module_inovaby_footer_border');
		}
        if (isset($this->request->post['module_inovaby_footer_bordercolor'])) {
			$data['module_inovaby_footer_bordercolor'] = $this->request->post['module_inovaby_footer_bordercolor'];
		} else {
			$data['module_inovaby_footer_bordercolor'] = $this->config->get('module_inovaby_footer_bordercolor');
		}
        if (isset($this->request->post['module_inovaby_footer_textcolor'])) {
			$data['module_inovaby_footer_textcolor'] = $this->request->post['module_inovaby_footer_textcolor'];
		} else {
			$data['module_inovaby_footer_textcolor'] = $this->config->get('module_inovaby_footer_textcolor');
		}

        if (isset($this->request->post['module_inovaby_footer_linkcolor'])) {
			$data['module_inovaby_footer_linkcolor'] = $this->request->post['module_inovaby_footer_linkcolor'];
		} else {
			$data['module_inovaby_footer_linkcolor'] = $this->config->get('module_inovaby_footer_linkcolor');
		}
         if (isset($this->request->post['module_inovaby_footer_linkhover'])) {
			$data['module_inovaby_footer_linkhover'] = $this->request->post['module_inovaby_footer_linkhover'];
		} else {
			$data['module_inovaby_footer_linkhover'] = $this->config->get('module_inovaby_footer_linkhover');
		}

        if (isset($this->request->post['module_inovaby_footer_titlecolor'])) {
			$data['module_inovaby_footer_titlecolor'] = $this->request->post['module_inovaby_footer_titlecolor'];
		} else {
			$data['module_inovaby_footer_titlecolor'] = $this->config->get('module_inovaby_footer_titlecolor');
		}

        //Design ends

		// Content ends
		
		
		
		
		
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/inovaby', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/inovaby', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_inovaby_status'])) {
			$data['module_inovaby_status'] = $this->request->post['module_inovaby_status'];
		} else {
			$data['module_inovaby_status'] = $this->config->get('module_inovaby_status');
		}

        if (isset($this->request->post['module_inovaby_youtube_link'])) {
			$data['module_inovaby_youtube_link'] = $this->request->post['module_inovaby_youtube_link'];
		} else {
			$data['module_inovaby_youtube_link'] = $this->config->get('module_inovaby_youtube_link');
		}

		if (isset($this->request->post['module_inovaby_blog_link'])) {
			$data['module_inovaby_blog_link'] = $this->request->post['module_inovaby_blog_link'];
		} else {
			$data['module_inovaby_blog_link'] = $this->config->get('module_inovaby_blog_link');
		}

		if (isset($this->request->post['module_inovaby_facebook_link'])) {
			$data['module_inovaby_facebook_link'] = $this->request->post['module_inovaby_facebook_link'];
		} else {
			$data['module_inovaby_facebook_link'] = $this->config->get('module_inovaby_facebook_link');
		}

		if (isset($this->request->post['module_inovaby_twitter_link'])) {
			$data['module_inovaby_twitter_link'] = $this->request->post['module_inovaby_twitter_link'];
		} else {
			$data['module_inovaby_twitter_link'] = $this->config->get('module_inovaby_twitter_link');
		}

		if (isset($this->request->post['module_inovaby_pinterest_link'])) {
			$data['module_inovaby_pinterest_link'] = $this->request->post['module_inovaby_pinterest_link'];
		} else {
			$data['module_inovaby_pinterest_link'] = $this->config->get('module_inovaby_pinterest_link');
		}

		if (isset($this->request->post['module_inovaby_googlep_link'])) {
			$data['module_inovaby_googlep_link'] = $this->request->post['module_inovaby_googlep_link'];
		} else {
			$data['module_inovaby_googlep_link'] = $this->config->get('module_inovaby_googlep_link');
		}

		if (isset($this->request->post['module_inovaby_linkedin_link'])) {
			$data['module_inovaby_linkedin_link'] = $this->request->post['module_inovaby_linkedin_link'];
		} else {
			$data['module_inovaby_linkedin_link'] = $this->config->get('module_inovaby_linkedin_link');
		}


		if (isset($this->request->post['module_inovaby_instagram_link'])) {
			$data['module_inovaby_instagram_link'] = $this->request->post['module_inovaby_instagram_link'];
		} else {
			$data['module_inovaby_instagram_link'] = $this->config->get('module_inovaby_instagram_link');
		}

		if (isset($this->request->post['module_inovaby_whatsapp_link'])) {
			$data['module_inovaby_whatsapp_link'] = $this->request->post['module_inovaby_whatsapp_link'];
		} else {
			$data['module_inovaby_whatsapp_link'] = $this->config->get('module_inovaby_whatsapp_link');
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/inovaby', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/inovaby')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}