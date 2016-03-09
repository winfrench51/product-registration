<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Model_Productwarranty extends Mage_Core_Model_Abstract
{

    /**
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('productwarranty/productwarranty');
    }
}