<?php
    class Tls_Sp_AdminCategory_Controller{
        
        private $_prefix_name 	= 'tls-sp-ts-category';        
        private $_prefix_id 	= 'tls-sp-ts-category-';
        
        public function __construct(){
            //echo '<br>' . __METHOD__;
            global $tController;
            
            $model = $tController->getModel('Category');
                        
            add_action('init', array($model, 'create'));
            
            if ($tController->getParams('taxonomy') == 'ts-category') {
                add_action('ts-category_add_form_fields', array($this, 'display'));
                
                add_action('ts-category_edit_form_fields', array($this, 'edit'));
                
                add_action('admin_enqueue_scripts', array($this,'add_js_file'));
                add_action('admin_enqueue_scripts', array($this,'add_css_file'));
                
                add_action('edited_ts-category', array($this, 'save'));
                add_action('create_ts-category', array($this, 'save'));
            }
        }
        
        public function display($term){
            //echo '<br>' . __METHOD__;
            global $tController;
            $htmlObj = new TlsHtml();
            
            if (is_object($term)){
                $option_name = $this->_prefix_id . $term->term_id;
                $option_value = get_option($option_name);
            
                echo '<pre>';
                print_r($option_value);
                echo '</pre>';
            }
            
            $action = ($tController->getParams('action') != '')?$tController->getParams('action'):'add';
            
            // Tạo phần tử chứa Button
            $inputId    = $this->create_id('button');
            $inputName  = $this->create_id('button');
            $inputValue = esc_attr('Media Library Images');
            $arr        = array('class' => 'button-secondary', 'id' => $inputId);
            $options    = array('type' => 'button');            
            $btnMedia   = $htmlObj->button($inputName, $inputValue, $arr, $options);
            
            // Tạo phần tử chứa Picture
            $inputId    = $this->create_id('picture');
            $inputName  = $this->create_name('picture');
            $inputValue = esc_url(@$option_value['picture']);
            $arr        = array('size' => '40', 'id' => $inputId);
                        
            if ($action == 'add'){
               $html = '<div class="form-field">'
                           . $htmlObj->label(esc_html__('Image of Category'), array('for' => 'tag-name'))
                           . $htmlObj->textbox($inputName, $inputValue, $arr) . ' ' . $btnMedia
                           . $htmlObj->pTag(esc_html__('Upload image for TS Category')) .'
                        </div>';
               echo $html;
               echo $htmlObj->btn_media_script($this->create_id('button'), $this->create_id('picture'));
            }
            else if ($action == 'edit'){
                // Not working. Preplace with function edit().
            }
            
        }
        
        public function edit($term){
            global $tController;
            $htmlObj = new TlsHtml();  
            
            if (is_object($term)){
                $option_name = $this->_prefix_id . $term->term_id;
                $option_value = get_option($option_name);
            }
            
            // Tạo phần tử chứa Button
            $inputId    = $this->create_id('button');
            $inputName  = $this->create_id('button');
            $inputValue = esc_attr('Media Library Images');
            $arr        = array('class' => 'button-secondary', 'id' => $inputId);
            $options    = array('type' => 'button');
            $btnMedia   = $htmlObj->button($inputName, $inputValue, $arr, $options);
            
            // Tạo phần tử chứa Picture
            $inputId    = $this->create_id('picture');
            $inputName  = $this->create_name('picture');
            $inputValue = esc_url(@$option_value['picture']);
            $arr        = array('size' => '40', 'id' => $inputId);
            
            $lblPicture 	= $htmlObj->label(esc_html__('Picture'), array('for'=>$inputId));
            $inputPicture 	= $htmlObj->textbox($inputName, $inputValue, $arr);
            $pPicture		= $htmlObj->pTag(esc_html__('Upload image for TS category'), array('class'=>'description'));
            $jsMedia		= $htmlObj->btn_media_script($this->create_id('button'), $this->create_id('picture'));
            
            $data = array();
            $data['lblPicture']     = $lblPicture;
            $data['inputPicture']   = $inputPicture . $btnMedia . $jsMedia;
            $data['pPicture']       = $pPicture;
            
            $tController->_data = $data;
            
            $tController->getView('display.php','backend/category');
        }
        
        public function save($term_id){
            global $tController;
            if($tController->isPost()){
                /* echo '<pre>';
                print_r($tController->getParams());
                echo '</pre>'; */
                
                $option_name = $this->_prefix_id . $term_id;
                update_option($option_name, $tController->getParams($this->_prefix_name));
                
                //die();
            }
        }
        
        public function add_js_file(){
            global $tController;
            wp_register_script("tls_sp_btn_media", $tController->getJsUrl('tls-media-button'),
                array('jquery','media-upload','thickbox'),'1.0');
            wp_enqueue_script("tls_sp_btn_media");
            	
        }
        
        public function add_css_file(){
            wp_enqueue_style('thickbox');
        }
        
        private function create_name($val){
            return $this->_prefix_name . '[' . $val . ']';
        }
        
        
        private function create_id($val){
            return $this->_prefix_id . $val;
        }
    }
