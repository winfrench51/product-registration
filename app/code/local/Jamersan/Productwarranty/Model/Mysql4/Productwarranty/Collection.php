<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Model_Mysql4_Productwarranty_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('productwarranty/productwarranty');
    }

    /**
     * @return mixed
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        //added
        $countSelect->reset(Zend_Db_Select::GROUP);
        //end

        $countSelect->resetJoinLeft();
        return $countSelect;
    }
}