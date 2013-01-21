<?php
/**
 * 
 * Add the manual submission link to the sitemap grid.
 * 
 * @author Filipe Gonalves filipe.goncalves@widetail.net
 *
 */

class Aschroder_SitemapSubmit_Block_Sitemap_Grid_Renderer_Action 
	extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action {
	
    public function render(Varien_Object $row) {
    
        $this->getColumn()->setActions(array(array(
            'url'     => $this->getUrl("sitemapsubmit", array("sitemap_id" => $row->getSitemapId())),
            'caption' => Mage::helper('adminhtml')->__('Submit Sitemap'),
        ),array(
            'url'     => $this->getUrl('*/sitemap/generate', array('sitemap_id' => $row->getSitemapId())),
            'caption' => Mage::helper('sitemap')->__('Generate'),
        )));
        
        return parent::render($row);
    }
}
