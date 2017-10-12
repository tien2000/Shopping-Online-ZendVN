<?php

// ===================== URL =======================//
define('TLS_SP_PLUGIN_URL'      , plugin_dir_url(__FILE__));
define('TLS_SP_PUBLIC_URL'      , TLS_SP_PLUGIN_URL . 'public/');
define('TLS_SP_CSS_URL'         , TLS_SP_PLUGIN_URL . 'css/');
define('TLS_SP_JS_URL'          , TLS_SP_PLUGIN_URL . 'js/');
define('TLS_SP_IMAGES_URL'      , TLS_SP_PLUGIN_URL . 'images/');

//===================== PATH =======================//
define('DS'                         , DIRECTORY_SEPARATOR);
define('TLS_SP_PLUGIN_PATH'         , plugin_dir_path(__FILE__));
define('TLS_SP_CONFIG_PATH'         , TLS_SP_PLUGIN_PATH . 'configs');
define('TLS_SP_CONTROLLER_PATH'     , TLS_SP_PLUGIN_PATH . 'controllers');
define('TLS_SP_HELPER_PATH'         , TLS_SP_PLUGIN_PATH . 'helpers');
define('TLS_SP_INLCUDE_PATH'        , TLS_SP_PLUGIN_PATH . 'includes');
define('TLS_SP_MODEL_PATH'          , TLS_SP_PLUGIN_PATH . 'models');
define('TLS_SP_PUBLIC_PATH'         , TLS_SP_PLUGIN_PATH . 'public');
define('TLS_SP_TEMPLATE_PATH'       , TLS_SP_PLUGIN_PATH . 'templates');
define('TLS_SP_VALIDATE_PATH'       , TLS_SP_PLUGIN_PATH . 'validates');

//===================== ORTHER =======================//
define('TLS_SP_PREFIX'       , 'Tls_Sp_');