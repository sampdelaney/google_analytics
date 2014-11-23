<?php

class GoogleAnalyticsHelper extends AppHelper
{

	public $trackerName = 'ga';

	public function trackingCode($webPropertyId, $options = array()) {
		$default = array('cookieDomain' => 'auto');
		$options = am($default, $options);
		return $this->command('create', $webPropertyId, $options);
	}

	public function pageView($options = array()) {
		return $this->command('send', 'pageview', $options);
	}

	public function command($method) {
		$args = array_slice(func_get_args(), 1);
		$cmd = '';
		$argString = '';
		// build the arg string
		$formattedArgs = [];
		foreach ($args as $arg) {
			if (is_string($arg)) {
				$formattedArgs[] = String::insert('":arg"', array('arg' => $arg));
			} elseif (is_array($arg)  && !empty($arg)) {
				$formattedArgs[] = json_encode($arg);
			}
		}
		if (count($formattedArgs) > 0) {
			$argString = ", " . implode(", ", $formattedArgs);
		}
		// build the method call
		$cmd = String::insert(':trackerName(":method":argString);', array(
			'trackerName' => $this->trackerName, 'method' => $method,
			'argString' => $argString));
		return $cmd;
	}
}

?>