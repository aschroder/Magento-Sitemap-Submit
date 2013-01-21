<?php
/**
 *
 * Just a simple observer to kick off the submission process when the sitemap is 
 * generated. 
 * 
 * @author ashley
 *
 */
class Aschroder_SitemapSubmit_Model_Observer {
	  
	public function submit($observer) {
		
		//Check we are enabled and set for autosubmission
		
		if (Mage::helper('sitemapsubmit')->isEnabled() && 
			Mage::helper('sitemapsubmit')->isAutoSubmit()) {
			
			try {
			
				Mage::log("Sitemap regeneration detected - auto running submission");
				
				$id = $observer->getEvent()->getSitemap()->getId();
				$obj = Mage::getModel('sitemapsubmit/submit');
				$msg = $obj->submit($id);
				
				Mage::log($msg);
				
			} catch (Exception $e) {
				Mage::log($e->getMessage());
			}
		} 
			
	}
}
