<?php
    global $tController, $tls_sp_settings;
    /* echo '<pre>';
    print_r($tls_sp_settings);
    echo '</pre>'; */
    
    $paymentDefault = array(
                'send_mail' => 'Send mail',
                'paypal' => 'Paypal',
                'vcb' => 'Vietcombank pay online',
                'vietin' => 'Vietinbank pay online',
            );
    
    $paymentSetting = $tls_sp_settings['payment'];    
?>

    <div id="payment">
    	<form method="post" id="paymentform" name="paymentform" action="">
    		<select name="payment" id="ils_sp_setting_payment">
    			<?php 
    		          foreach ($paymentSetting as $key => $val){
    		              echo '<option value="'. $val .'">' . $paymentDefault[$val] . '</option>';
    		          }
    			?>
    		</select>
    		
    		<input type="submit" name="submit" id="submit" value="Payment">
    	</form>
    </div>