<?php
/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('productwarranty')};
CREATE TABLE {$this->getTable('productwarranty')} (
  `productwarranty_id` int(11) unsigned NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `company_title` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `firstname` varchar(255) NOT NULL default '',
  `lastname` varchar(255) NOT NULL default '',
  `address1` varchar(255) NOT NULL default '',
  `address2` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `postcode` varchar(255) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `telephone` varchar(255) NOT NULL default '',
  `mobile` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `fax` varchar(255) NOT NULL default '', 
  `created_time` datetime NULL,  
  PRIMARY KEY (`productwarranty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('productwarranty_products')};
CREATE TABLE {$this->getTable('productwarranty_products')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `pw_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL default '',
  `product_name` varchar(255) NOT NULL default '',
  `product_sku` varchar(255) NOT NULL default '',
  `purchase_date` varchar(255) NOT NULL default '',
  `purchased_from` varchar(255) NOT NULL default '',
  `file_proof` varchar(255) NOT NULL default '',   
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    ");

$installer->addAttribute('catalog_product', 'warranty', array(
    'group'            => 'General',
    'type'             => 'int',
    'backend'          => '',
    'frontend'         => '',
    'label'            => 'Warranty',
    'input'            => 'boolean',
    'class'            => '',
    'source'           => '',
    'global'           => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'          => true,
    'required'         => false,
    'user_defined'     => true,
    'default'          => '0',
    'searchable'       => false,
    'filterable'       => false,
    'comparable'       => false,
    'visible_on_front' => false,
    'unique'           => false,
    'apply_to'         => 'simple,configurable,virtual,bundle,downloadable',
    'is_configurable'  => false
));
$installer->updateAttribute('catalog_product', 'warranty', 'is_global',
    Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->endSetup(); 