<?php

/**
 * Sitemap Submit controller - for invoking the submission from the UI. 
 *
 * @author Ashley Schroder (aschroder.com)
 */
class Aschroder_SitemapSubmit_IndexController
	extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		
		try {
			
			$id = $this->getRequest()->getParam('sitemap_id');
			
			$obj = Mage::getModel('sitemapsubmit/submit');
			$msg = $obj->submit($id);
			Mage::getSingleton('adminhtml/session')->addSuccess($msg);
			
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		
		$this->_redirectReferer();
		
	}

} 
