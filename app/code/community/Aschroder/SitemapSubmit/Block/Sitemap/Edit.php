
<?php
/**
 * 
 * Add our manual submission button to the sitemap edit page.
 * 
 * @author ashley
 *
 */

class Aschroder_SitemapSubmit_Block_Sitemap_Edit extends Mage_Adminhtml_Block_Sitemap_Edit
{

 	public function __construct()
    {
    	
    	parent::__construct();
    	
    	// Only put the button here if the extension is enabled
    	
    	if (Mage::helper('sitemapsubmit')->isEnabled()) {
    		
	    	$params = array("sitemap_id" => Mage::registry('sitemap_sitemap')->getId());
	    	$url = Mage::helper('adminhtml')->getUrl("sitemapsubmit", $params);
	    	
	    	 $this->_addButton('submit', array(
	            'label'   => Mage::helper('adminhtml')->__('Submit Sitemap'),
	            'onclick' => "window.location.href='".$url."'",
	            'class'   => 'add',
	        ));
			
    	}
    	
        return $this;
    }
    
}