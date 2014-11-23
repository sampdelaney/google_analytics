<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('GoogleAnalyticsHelper', 'GoogleAnalytics.View/Helper');

class GoogleAnalyticsHelperTest extends CakeTestCase {
	
	public function setUp() {
		parent::setUp();
		$controller = new Controller();
		$view = new View($controller);
		$this->GoogleAnalytics = new GoogleAnalyticsHelper($view);
	}

	public function testCommandMethodOnly() {
		$actual = $this->GoogleAnalytics->command('foo');
		$expected = 'ga("foo");';
		$this->assertEqual($expected, $actual);
	}

	public function testCommandWithDifferentGlobalObject() {
		$this->GoogleAnalytics->trackerName = 'tracker';
		$actual = $this->GoogleAnalytics->command('foo');
		$expected = 'tracker("foo");';
		$this->assertEqual($expected, $actual);
	}

	public function testCommandWithFlatArgs() {
		$actual = $this->GoogleAnalytics->command('foo','bar');
		$expected = 'ga("foo", "bar");';
		$this->assertEqual($expected, $actual);
	}

	public function testCommandWithObjectArgs() {
		$actual = $this->GoogleAnalytics->command('foo', array('foo' => 'bar'));
		$expected = 'ga("foo", {"foo":"bar"});';
		$this->assertEqual($expected, $actual);

	}

	public function testTrackingCodeWebPropertyIdOnly() {
		$testWebPropertyId = 'UA-XXXX-Y';
		$actual = $this->GoogleAnalytics->trackingCode('UA-XXXX-Y');
		$expected = 'ga("create", "UA-XXXX-Y", {"cookieDomain":"auto"});';
		$this->assertEqual($expected, $actual);
	}

	public function testTrackingCodeWithOptions() {
		$options = array('foo' => 'bar');
		$actual = $this->GoogleAnalytics->trackingCode('UA-XXXX-Y', $options);
		$expected = 'ga("create", "UA-XXXX-Y", {"cookieDomain":"auto","foo":"bar"});';
		$this->assertEqual($expected, $actual);
	}

	public function testPageView() {
		$actual = $this->GoogleAnalytics->pageView();
		$expected = 'ga("send", "pageview");';
		$this->assertEqual($expected, $actual);
	}

	public function testPageViewWithArgs() {
		$options = array('foo' => 'bar');
		$actual = $this->GoogleAnalytics->pageView($options);
		$expected = 'ga("send", "pageview", {"foo":"bar"});';
		$this->assertEqual($expected, $actual);	
	}

}