<?php

class GoogleAnalyticsHelper extends AppHelper
{

	public $helpers = array('Session');

	protected $tag = '';

	protected $_options = array(
		'isLocal' => false,
		'trackUser' => false
	);

	protected $_validFieldNames = array(
		'userId'/*,'appName', 'appVersion'*/);

	function getTrackingCode() {
		
		$createOnlyFields = [];
		$options = am($this->_options, Configure::read('GoogleAnalytics'));
		
		$webPropertyId = Configure::read('GoogleAnalytics.webPropertyId');

		if ($webPropertyId == NULL) {
			throw new CakeException('WebPropertyId has not been set for GoogleAnalytics');
		}

		if ($options['isLocal']) {
			$createOnlyFields['cookieDomain'] = 'none';
		}
	
		$fields = array_intersect_key($options, array_flip($this->_validFieldNames));

		if ($options['trackUser']) {
			$fields['userId'] = $this->Session->read('Auth.User.id');
		}

		return $this->_View->element('GoogleAnalytics', array(
			'webPropertyId' => $webPropertyId,
			'createOnlyFields' => $createOnlyFields,
			'fields' => $fields
			));
	}
}

?>