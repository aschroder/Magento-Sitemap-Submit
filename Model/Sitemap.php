<?php
/**
 * 
 * @author Ashley Schroder (aschroder.com)
 */


/**
 * Sitemap model rewrite 
 *
 * Just doing this to add an event for generation.
 * 
 * @category   Mage
 * @package    Mage_Sitemap
 */
class Aschroder_SitemapSubmit_Model_Sitemap extends Mage_Sitemap_Model_Sitemap {
	
    public function generateAction() {
    	parent::generateAction();
    	Mage::dispatchEvent('sitemap_sitemap_generate', array('sitemap'=>$this));
    }

}
