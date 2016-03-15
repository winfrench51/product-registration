<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Adminhtml_Productwarranty_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Jamersan_Productwarranty_Block_Adminhtml_Productwarranty_Edit_Tabs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productwarranty_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('productwarranty')->__('Item Information'));
    }

    /**
     * @return mixed
     */
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'   => Mage::helper('productwarranty')->__('Item Information'),
            'title'   => Mage::helper('productwarranty')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('productwarranty/adminhtml_productwarranty_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}