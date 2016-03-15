<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Adminhtml_Registrations extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Jamersan_Productwarranty_Block_Adminhtml_Registrations constructor.
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_registrations';
        $this->_blockGroup = 'productwarranty';
        $this->_headerText = Mage::helper('productwarranty')->__('Product Registrations');
        //$this->_addButtonLabel = Mage::helper('productwarranty')->__('Add Item');
        parent::__construct();
        $this->_removeButton('add');
    }
}