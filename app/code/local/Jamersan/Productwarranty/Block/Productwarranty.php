<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Productwarranty extends Mage_Core_Block_Template
{

    /**
     * Jamersan_Productwarranty_Block_Productwarranty constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('productwarranty/productwarranty.phtml');
        $collection = $this->getCollection();
        $this->setCollection($collection);

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('productwarranty')->__('My Register Products'));
    }

    /**
     * @return mixed
     */
    protected function getCollection()
    {
        $cid = Mage::getSingleton('customer/session')->getCustomer()->getId();

        $data = Mage::getModel('productwarranty/products')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('main_table.customer_id', array('eq' => $cid))
            ->setOrder('main_table.id', 'desc');

        return $data;

    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($this->__('My Register Products'));
        }

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(10 => 10, 20 => 20, 50 => 50, 100 => 100, 'all' => 'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
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