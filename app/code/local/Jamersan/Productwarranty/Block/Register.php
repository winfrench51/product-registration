<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Register extends Mage_Core_Block_Template
{

    /**
     * @return mixed
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return mixed
     */
    public function getProductwarranty()
    {
        if (!$this->hasData('productwarranty')) {
            $this->setData('productwarranty', Mage::registry('productwarranty'));
        }
        return $this->getData('productwarranty');

    }
}