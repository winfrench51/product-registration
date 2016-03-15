<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Adminhtml_Registrations_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Jamersan_Productwarranty_Block_Adminhtml_Registrations_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productwarrantyGrid');
        $this->setDefaultSort('productwarranty_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return mixed
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('productwarranty/productwarranty')->getCollection();

        $collection->getSelect()->columns(new Zend_Db_Expr("CONCAT(main_table.title,' ',main_table.firstname,' ',main_table.lastname) as fullname"));

        $collection->getSelect()->joinleft(
            array('prod' => Mage::getSingleton('core/resource')->getTableName('productwarranty_products')),
            'main_table.productwarranty_id = prod.pw_id',
            array('*')
        );

        $collection->distinct(true);
        //$collection->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->group('productwarranty_id');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return mixed
     */
    protected function _prepareColumns()
    {
        $this->addColumn('productwarranty_id', array(
            'header' => Mage::helper('productwarranty')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'productwarranty_id',
        ));

        $this->addColumn('fullname', array(
            'header'       => Mage::helper('productwarranty')->__('Customer Name'),
            'align'        => 'left',
            'index'        => 'fullname',
            'filter_index' => "CONCAT(main_table.title,' ',main_table.firstname,' ',main_table.lastname)"
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('productwarranty')->__('Customer Email'),
            'align'  => 'left',
            'index'  => 'email',

        ));

//	   $this->addColumn('product_name', array(
//          'header'    => Mage::helper('productwarranty')->__('Product Name'),
//          'align'     =>'left',
//          'index'     => 'product_name',
//		  'filter_index'=>'prod.product_name'
//
//      ));
        $this->addColumn('product_sku', array(
            'header'       => Mage::helper('productwarranty')->__('Product Sku'),
            'align'        => 'left',
            'index'        => 'product_sku',
            'filter_index' => 'prod.product_sku'

        ));

        $this->addColumn('serial_number', array(
            'header' => Mage::helper('productwarranty')->__('Serial Number'),
            'align'  => 'left',
            'index'  => 'serial_number',

        ));

        $this->addColumn('purchase_date', array(
            'header' => Mage::helper('productwarranty')->__('Purchase Date'),
            'width'  => '150px',
            'index'  => 'purchase_date',
            'type'   => 'date',

        ));

        $this->addColumn('purchased_from', array(
            'header' => Mage::helper('productwarranty')->__('Purchased From'),
            'align'  => 'left',
            'index'  => 'purchased_from',

        ));

        $this->addColumn('created_time', array(
            'header' => Mage::helper('productwarranty')->__('Created On'),
            'width'  => '150px',
            'index'  => 'created_time',
            'type'   => 'date',

        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('productwarranty')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('productwarranty')->__('View Details'),
                        'url'     => array('base' => '*/*/view'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

        $this->addExportType('*/*/exportCsv', Mage::helper('productwarranty')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('productwarranty')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productwarranty_id');
        $this->getMassactionBlock()->setFormFieldName('productwarranty');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => Mage::helper('productwarranty')->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('productwarranty')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productwarranty/status')->getOptionArray();

        return $this;
    }

    /**
     * @param $row
     *
     * @return mixed
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }

}