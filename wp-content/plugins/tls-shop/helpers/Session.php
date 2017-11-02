<?php 
    /* 
     * get_bloginfo(): Lấy đường dẫn chính của website.
     *  */
?>

<?php
    class Tls_Sp_Session_Helper{
        
        public $_tlsSsName;
        
        public function __construct(){
            $this->_tlsSsName = 'tlsSs_' . md5(get_bloginfo('wpurl') . TLS_SP_PLUGIN_NAME . TLS_SP_PLUGIN_VERSION);
            //echo $this->_tlsSsName;
            
            if (!isset($_SESSION[$this->_tlsSsName])) {
                $_SESSION[$this->_tlsSsName] = array();
            }
        }
        
        public function set($name = null, $value = null){
            if ($name != null || !empty($name)){
                $_SESSION[$this->_tlsSsName][$name] = $value;
            }            
        }
        
        public function get($name = null, $default = null) {
            if ($name == null){
                return $_SESSION[$this->_tlsSsName];
            }else {
                return (!isset($_SESSION[$this->_tlsSsName][$name]))?$default:$_SESSION[$this->_tlsSsName][$name];
            }
        }
        
        public function reset() {
            $_SESSION[$this->_tlsSsName] = array();
        }
    }