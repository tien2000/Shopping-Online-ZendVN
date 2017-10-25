<?php 
    /* 
     * Sử dụng đường dẫn tuyệt đối
     * $obj = new stdClass(): Gán 1 biến thành 1 đối tượng
     *  */
?>

<?php
    class tController{
        public $_error = array();
        public $_data   = array();
        
        public function __construct($options = array()) {
            
        }
        
        public function isPost(){
            $flag = ($_SERVER['REQUEST_METHOD']=='POST')?true:false;
            return $flag;
        }
        
        public function getParams($name = null){
            /* echo '<pre>';
            print_r($_REQUEST);
            echo '</pre>'; */
            
            if($name == null || empty($name)){
    			return $_REQUEST;
    		}else{
    			$val = (isset($_REQUEST[$name]))?$_REQUEST[$name]:'';
    			return $val;
    		}
        }
        
        public function getConfig($fileName = '', $dir = '') {
            //echo '<br>' . __FILE__;
        
            $obj = new stdClass();
            $file = TLS_SP_CONFIG_PATH . DS . $dir . DS . $fileName . '.php';
            //echo '<br>' . $file;
        
            if (file_exists($file)){
                require_once $file;
                $controllerName = TLS_SP_PREFIX . $fileName . '_Config';
                $obj = new $controllerName ();      // cách ra mới chạy được
            }
            return $obj;
        }
        
        public function getController($fileName = '', $dir = '') {
            //echo '<br>' . __FILE__;
            
            $obj = new stdClass();            
            $file = TLS_SP_CONTROLLER_PATH . DS . $dir . DS . $fileName . '.php';
            //echo '<br>' . $file;
            
            if (file_exists($file)){
                require_once $file;
                $controllerName = TLS_SP_PREFIX . $fileName . '_Controller';
                $obj = new $controllerName ();      // cách ra mới chạy được
            }
            return $obj;
        }
        
        public function getModel($fileName = '', $dir = '') {
            $obj = new stdClass();
            $file = TLS_SP_MODEL_PATH . DS . $dir . DS . $fileName . '.php';
            
            if (file_exists($file)){
                require_once $file;
                $modelName = TLS_SP_PREFIX . $fileName . '_Model';
                $obj = new $modelName ();
            }
            return $obj;
        }
        
        public function getHelper($fileName = '', $dir = '') {
            $obj = new stdClass();
            $file = TLS_SP_HELPER_PATH . DS . $dir . DS . $fileName . '.php';
            
            if (file_exists($file)){
                require_once $file;
                $helperName = TLS_SP_PREFIX . $fileName . '_Helper';
                $obj = new $helperName ();
            }
            return $obj;
        }
        
        public function getView($fileName = '', $dir = '') {
            $file = TLS_SP_TEMPLATE_PATH . DS . $dir . DS . $fileName;
            //echo '<br>' . $file;
            
            if(file_exists($file)){
                require_once $file;
            }
        }
        
        public function getValidate($fileName = '', $dir = '') {
            $obj = new stdClass();
            $file = TLS_SP_VALIDATE_PATH . DS . $dir . DS . $fileName . '.php';
            
            if (file_exists($file)){
                require_once $file;
                $validateName = TLS_SP_PREFIX . $fileName . '_Validate';
                $obj = new $validateName ();
            }
            return $obj;
        }
        
        public function getCssUrl($fileName = '', $dir = '') {
            $url = TLS_SP_CSS_URL . $dir . $fileName . '.css';
            $headers = @get_headers($url);
            $flag = stripos($headers[0], '200 OK')?true:false;      // Kiểm tra tập tin có tồn tại ko.
            
            if ($flag == true) return $url; 
            return false;
        }
        
        public function getJSUrl($fileName = '', $dir = '') {
            $url = TLS_SP_JS_URL . $dir . $fileName . '.js';
            $headers = @get_headers($url);
            $flag = stripos($headers[0], '200 OK')?true:false;
            
            if ($flag == true) return $url;
            return false;
        }
        
        public function getImagesUrl($fileName = '', $dir = '') {
            $url = TLS_SP_IMAGES_URL . $dir . $fileName;
            $headers = @get_headers($url);
            $flag = stripos($headers[0], '200 OK')?true:false;
            
            if ($flag == true) return $url;
            return false;
        }
    }