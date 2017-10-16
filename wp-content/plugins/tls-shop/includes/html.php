<?php

class TlsHtml{

	public function __construct($options = null){

	}

	public function btn_media_script($button_id,$input_id){
	    $script = "<script>
    	               jQuery(document).ready(function($){
    	               $('#{$button_id}').tlsBtnMedia('{$input_id}');
    	               });
    	           </script>";
	    return $script;
	}

	//Phần tử P
	public function pTag($value = '', $attr = array(), $options = null){
	    require_once TLS_SP_INLCUDE_PATH . '/html/Html_PTag.php';
		return Html_PTag::create($value, $attr, $options);
	}

	//Phần tử LABEL
	public function label($value = '', $attr = array(), $options = null){
	    require_once TLS_SP_INLCUDE_PATH . '/html/HtmlLabel.php';
		return HtmlLabel::create($value, $attr, $options);
	}

	//Phần tử TEXTBOX
	public function textbox($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlTextbox.php';
		return HtmlTextbox::create($name, $value, $attr, $options);
	}

	//Phần tử FILEUPLOAD
	public function fileupload($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlFileupload.php';
		return HtmlFileupload::create($name, $value, $attr, $options);
	}

	//Phần tử PASSWORD
	public function password($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlPassword.php';
		return HtmlPassword::create($name, $value, $attr, $options);
	}

	//Phần tử HIDDEN
	public function hidden($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlHidden.php';
		return HtmlHidden::create($name, $value, $attr, $options);
	}

	//Phần tử BUTTON - SUBMIT - RESET
	public function button($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlButton.php';
		return HtmlButton::create($name, $value, $attr, $options);
	}

	//Phần tử TEXTAREA
	public function textarea($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlTextarea.php';
		return HtmlTextarea::create($name, $value, $attr, $options);
	}

	//Phần tử RADIO
	public function radio($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlRadio.php';
		return HtmlRadio::create($name, $value, $attr, $options);
	}

	//Phần tử CHECKBOX
	public function checkbox($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlCheckbox.php';
		return HtmlCheckbox::create($name, $value, $attr, $options);
	}

	//Phần tử SELECTBOX
	public function selectbox($name = '', $value = '', $attr = array(), $options = null){
		require_once TLS_SP_INLCUDE_PATH . '/html/HtmlSelectbox.php';
		return HtmlSelectbox::create($name, $value, $attr, $options);
	}

}