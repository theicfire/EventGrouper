<?php
/* /app/views/helpers/link.php (using other helpers) */
class ConfigurationHelper extends AppHelper {
	function readConfig() {
		return Configuration::read('FACEBOOK_APP_ID');//doesn't work
	}
}
?>
