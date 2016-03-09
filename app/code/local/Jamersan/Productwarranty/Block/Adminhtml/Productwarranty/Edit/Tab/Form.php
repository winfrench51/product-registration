<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_Block_Adminhtml_Productwarranty_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * @return mixed
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('productwarranty_form',
            array('legend' => Mage::helper('productwarranty')->__('Item information')));

        $fieldset->addField('title', 'text', array(
            'label'    => Mage::helper('productwarranty')->__('Title'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'title',
        ));

        $fieldset->addField('filename', 'file', array(
            'label'    => Mage::helper('productwarranty')->__('File'),
            'required' => false,
            'name'     => 'filename',
        ));

        $fieldset->addField('status', 'select', array(
            'label'  => Mage::helper('productwarranty')->__('Status'),
            'name'   => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('productwarranty')->__('Enabled'),
                ),

                array(
                    'value' => 2,
                    'label' => Mage::helper('productwarranty')->__('Disabled'),
                ),
            ),
        ));

        $fieldset->addField('content', 'editor', array(
            'name'     => 'content',
            'label'    => Mage::helper('productwarranty')->__('Content'),
            'title'    => Mage::helper('productwarranty')->__('Content'),
            'style'    => 'width:700px; height:500px;',
            'wysiwyg'  => false,
            'required' => true,
        ));

        if (Mage::getSingleton('adminhtml/session')->getProductwarrantyData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProductwarrantyData());
            Mage::getSingleton('adminhtml/session')->setProductwarrantyData(null);
        } elseif (Mage::registry('productwarranty_data')) {
            $form->setValues(Mage::registry('productwarranty_data')->getData());
        }
        return parent::_prepareForm();
    }
}