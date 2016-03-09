<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Model_Mysql4_Products extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     *
     */
    public function _construct()
    {
        // Note that the productwarranty_id refers to the key field in your database table.
        $this->_init('productwarranty/products', 'id');
    }
}