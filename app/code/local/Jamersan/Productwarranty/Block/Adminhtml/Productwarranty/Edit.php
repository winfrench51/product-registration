<?php
/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */

/**
 * Class Jamersan_Productwarranty_Block_Adminhtml_Productwarranty_Edit
 */
class Jamersan_Productwarranty_Block_Adminhtml_Productwarranty_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Jamersan_Productwarranty_Block_Adminhtml_Productwarranty_Edit constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'productwarranty';
        $this->_controller = 'adminhtml_productwarranty';

        $this->_updateButton('save', 'label', Mage::helper('productwarranty')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productwarranty')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class'   => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productwarranty_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productwarranty_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productwarranty_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('productwarranty_data') && Mage::registry('productwarranty_data')->getId()) {
            return Mage::helper('productwarranty')->__("Edit Item '%s'",
                $this->htmlEscape(Mage::registry('productwarranty_data')->getTitle()));
        } else {
            return Mage::helper('productwarranty')->__('Add Item');
        }
    }
}