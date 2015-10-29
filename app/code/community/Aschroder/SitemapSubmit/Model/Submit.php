<?php

/**
 *
 * Service to submit the Magento sitemap to the major search engines.
 *
 * @author Ashley Schroder (aschroder.com)
 */

class Aschroder_SitemapSubmit_Model_Submit {
	
	/*
	 * Begins the submit process.
	 * 
	 * Will submit the given sitemap to the major search engines.
	 *  
	 * Returns a success message
	 * 
	 * Throws exception if the pings fail
	 * 
	 */
	public function submit($sitemapId) {
		
		if (!Mage::helper('sitemapsubmit')->isEnabled()) {
			Mage::log("Sitemap Submit Extension disabled - not submiting sitemap.");
			return;
		}
		
		$sitemap = Mage::getModel('sitemap/sitemap');
        $sitemap->load($sitemapId);
        
        if(!$sitemap->getId()) {
        	throw new Exception("Site map could not be found with ID: " . $sitemapId);
        }
        
        $fileName = preg_replace('/^\//', '', $sitemap->getSitemapPath() . $sitemap->getSitemapFilename());
        // multi-store url fix thanks to Filipe Goncalves (filipe.goncalves@widetail.net)
        $url = Mage::app()
        	->getStore($sitemap->getStoreId())
        	->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK) . $fileName;

        if (file_exists(BP . DS . $fileName)) {
        	
        	$msg = "";
        	
        	//ping google
        	if($this->_pingGoogle($url)) {
        		$msg = $msg . "Pinged Google successfully<br/>";
        	} else {
        		$msg = $msg . "Failed to ping Google.<br/>";
        	}
        	
			//ping yahoo
        	if ($yahooApiKey = Mage::helper('sitemapsubmit')->getYahooKey()) {
        		
	        	if($this->_pingYahoo($url, $yahooApiKey)) {
	        		$msg = $msg . "Pinged Yahoo successfully<br/>";
	        	} else {
	        		$msg = $msg . "Failed to ping Yahoo.<br/>";
	        	}
	        	
        	} else {
        		$msg = $msg . "Skipping Yahoo. (You need to provide an API key to submit your sitemap to Yahoo)<br/>";
        	}
        	
			//ping ask
        	if($this->_pingAsk($url)) {
        		$msg = $msg . "Pinged Ask successfully<br/>";
        	} else {
        		$msg = $msg . "Failed to ping Ask.<br/>";
        	}
        	
        	
			//ping bing
        	if($this->_pingBing($url)) {
        		$msg = $msg . "Pinged Bing successfully<br/>";
        	} else {
        		$msg = $msg . "Failed to ping Bing.<br/>";
        	}
        	
        	return "Sitemap submit for url: " . $url . " complete.<br/>Results are: <br/>" . $msg;
        	
        } else {
        	throw new Exception("Site map could not be found in required location: " . BP . DS . $fileName);
        }
        
		//TODO: Add more search engines
	}
	
	protected function _pingGoogle($url) {
		$ping="http://www.google.com/webmasters/sitemaps/ping?sitemap=" . urlencode($url);
		return $this->_makeRequest($ping);
	}
	
	protected function _pingYahoo($url, $yahooApiKey) {
		$ping="http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?url=" . 
				urlencode($url) . "&appid=" . $yahooApiKey;	
		return $this->_makeRequest($ping);
	}
	
	protected function _pingBing($url) {
			$ping="http://www.bing.com/webmaster/ping.aspx?siteMap=" . urlencode($url);
		return $this->_makeRequest($ping);
	}
	
	protected function _pingAsk($url) {
		$ping="http://submissions.ask.com/ping?sitemap=" . urlencode($url);
		return $this->_makeRequest($ping);
	}
	
	
	protected function _makeRequest($ping) {
		
		$curl = new Varien_Http_Adapter_Curl();
        $curl->setConfig(array(
            'timeout'   => 20
        ));
        
        $curl->write(Zend_Http_Client::GET, $ping, '1.1');
        $data = $curl->read();
        
        if ($data === false) {
            return false;
        }
       
        if ($curl->getInfo(CURLINFO_HTTP_CODE) == 200) {
	        // Mage::log($data); // uncomment to debug raw submission response
	        return $data;
        } else {
	        Mage::log("Submission to: " . $ping . " failed, HTTP response code was not 200");
	        return false;
        }
        
        //TODO: handle timeout?
		
	}
	
}