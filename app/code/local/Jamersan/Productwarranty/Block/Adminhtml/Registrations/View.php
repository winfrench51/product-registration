<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Adminhtml_Registrations_View extends Mage_Adminhtml_Block_Widget_Container
{

    /**
     * Jamersan_Productwarranty_Block_Adminhtml_Registrations_View constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'productwarranty';
        $this->_controller = 'adminhtml_registrations';

    }

}