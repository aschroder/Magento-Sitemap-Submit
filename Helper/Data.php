<?php

/**
 * Various Helper functions for the SitemapSubmit module
 * 
 * @author Ashley Schroder (aschroder.com)
 */

class Aschroder_SitemapSubmit_Helper_Data extends Mage_Core_Helper_Abstract {
	
	public function isEnabled() {
		return Mage::getStoreConfig('sitemap/sitemapsubmit/enabled');
	}
	public function isAutoSubmit() {
		return Mage::getStoreConfig('sitemap/sitemapsubmit/autosubmit');
	}
	
	public function getYahooKey() {
		return Mage::getStoreConfig('sitemap/sitemapsubmit/yahoo_key');
	}
	
}
