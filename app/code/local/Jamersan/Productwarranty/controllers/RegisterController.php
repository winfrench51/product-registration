<?php

/**
 * *
 * @category    Jamersan
 * @package     Jamersan_Productwarranty
 * @copyright   Copyright (c) 2016 Jamersan LLC, (http://www.jamersan.com/)
 * @author      William French <will.french@jamersan.com>
 *
 */
class Jamersan_Productwarranty_RegisterController extends Mage_Core_Controller_Front_Action
{

    public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();

        if (Mage::getStoreConfig('productwarranty/general/enabled_guest_registration') == 0) {
            $loginUrl = Mage::helper('customer')->getLoginUrl();

            if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            }
        }
    }

    public function indexAction()
    {

        $this->loadLayout();
        $this->renderLayout();
    }

    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        $cid = Mage::getSingleton('customer/session')->getCustomer()->getId();
        if ($post) {

            if (isset($post['state_id'])) {

                $region = Mage::getModel('directory/region')->load($post['state_id']);
                $post['state'] = $region->getName();
            } elseif ($post['state'] != "") {
                $post['state'] = $post['state'];
            } else {
                unset($post['state']);
            }
            unset($post['state_id']);

            if ($cid) {
                $post['cid'] = $cid;
            }

            try {
                $error = false;

                if (!Zend_Validate::is(trim($post['firstname']), 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['lastname']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['address1']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['city']), 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['country']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['postcode']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['country']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }
                if ($error) {
                    throw new Exception();
                }

                if (isset($post['register_newsletter']) && $post['register_newsletter'] == 1) {
                    Mage::getModel('newsletter/subscriber')->subscribe($post['email']);
                }
                //save data
                $post['created_time'] = Mage::getModel('core/date')->timestamp(time());
                $model = Mage::getModel('productwarranty/productwarranty');
                $model->addData($post);
                $model->save();

                $lastId = $model->getId();

                $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $connection->beginTransaction();

                $k = 0;
                $fileArray = array();
                foreach ($post['hide'] as $row) {
                    if ($row == 1) {
                        if (isset($_FILES)) {

                            $fileUpload = "";

                            if (isset($_FILES['file_proof']['name'][$k]) && $_FILES['file_proof']['name'][$k] != "") {
                                $exten = pathinfo($_FILES['file_proof']['name'][$k], PATHINFO_EXTENSION);
                                $fileArr = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'txt');

                                if (in_array($exten, $fileArr)) {
                                    /*$uploader = new Varien_File_Uploader("file_proof");
                                    $uploader->setAllowedExtensions($fileArr);
                                    $uploader->setAllowRenameFiles(false);
                                    $uploader->setFilesDispersion(false);*/
                                    $path = Mage::getBaseDir("media") . DS;
                                    $fileName = time() . "-" . $k . "." . pathinfo($_FILES['file_proof']['name'][$k],
                                            PATHINFO_EXTENSION);
                                    $fileArray[$k] = $fileName;
                                    /*$uploader->save($path, $fileName);	*/
                                    $fileUpload = $path . $fileName;
                                    move_uploaded_file($_FILES["file_proof"]["tmp_name"][$k], $fileUpload);
                                }
                            }
                        }

                        //$productData = Mage::getModel('catalog/product')->load($post['product_id'][$k]);
                        $fields = array();
                        $fields['pw_id'] = $lastId;
                        $fields['product_sku'] = $post['product_sku'][$k];
                        if ($cid) {
                            $fields['customer_id'] = $cid;
                        }
                        //$fields['product_name']= $productData->getName();
                        //$fields['product_sku']= $productData->getSku();
                        $fields['serial_number'] = $post['serial_number'][$k];
                        $fields['purchase_date'] = date("Y-m-d", strtotime($post['purchase_date'][$k]));
                        $fields['purchased_from'] = $post['purchased_from'][$k];
                        if ($fileUpload != "") {
                            $fields['file_proof'] = $fileName;
                        }
                        $connection->insert(Mage::getConfig()->getTablePrefix() . 'productwarranty_products', $fields);
                        $connection->commit();
                        $k++;
                    }

                }

                if (Mage::getStoreConfig('productwarranty/general/product_warranty_email')) {
                    $to = Mage::getStoreConfig('productwarranty/general/product_warranty_email');
                } else {
                    $to = Mage::getStoreConfig('trans_email/ident_general/email');
                }

                $skinUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/default/default/';
                $body = '
<br>
<img src="' . $skinUrl . 'images/logo.gif" alt="Logo">
<h4>Customer Information</h4>
<hr>
<table cellspacing="0" cellpadding="0" border="0" style="width: 510px;">
        <tbody><tr id="ctl00_contentMain_uctlContact_countryRow">
			<td style="width:30%; padding: 0px 6px 12px 0px; text-align: right;color:#333;">
                Name: 
            </td>
			<td style="width: 70%; padding: 0px 6px 12px 0px;">' . $post['firstname'] . ' ' . $post['lastname'] . '</td>
		</tr>';

                $body .= '<tr id="ctl00_contentMain_uctlContact_pnlCompany">
			<td style="width:30%; padding: 6px 6px 6px 0px; text-align: right;color:#333;">Email: </td>
			<td style="width: 70%; padding: 6px 0px;">' . $post['email'] . '</td>
		</tr>
		
        <tr>
            <td style="width:30%; padding: 0px 6px 6px 0px; text-align: right;color:#333;">
                Address: 
            </td>
            <td style="width:70%; padding: 0px 0px 6px 0px;">' . $post['address1'] . " " . $post['address2'] . '<br/>' . $post['city'] . ', ' . $post['state'] . ', ' . $post['country'] . ' ' . $post['postcode'] . '</td>
        </tr>
        
   </tbody></table><h4>Product Information</h4><hr><table cellspacing="1" cellpadding="1" border="0" style="border:1px solid #ccc;width: 710px;">';

                $body .= "<tr bgcolor='#CCCCCC'><td><strong>Model#</strong></td><td><strong>Serial#</strong></td><td><strong>Date of Purchase</strong></td><td><strong>Purchased From</strong></td><td><strong>Proof of Purchase</strong></td></tr>";
                if (count($post['hide']) > 0) {
                    $i = 0;
                    foreach ($post['hide'] as $row) {
                        if ($row == 1) {
                            $product = Mage::getModel('catalog/product')->load($post['product_id'][$i]);

                            $body .= "<tr bgcolor='#EFFFFD'><td>" . $post['product_sku'][$i] . "</td><td>" . $post['serial_number'][$i] . "</td><td>" . $post['purchase_date'][$i] . "</td><td>" . $post['purchased_from'][$i] . "</td><td>";
                            if (isset($fileArray[$i]) && $fileArray[$i] != "") {
                                $body .= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $fileArray[$i];
                            }
                            $body .= "</td></tr>";
                        }

                        $i++;
                    }
                }
                $body .= "</table>";

                $subject = 'Product Registration';

                $mail = new Zend_Mail();
                //$mail->setBodyText($rq_msg);
                $mail->setBodyHtml($body);
                $mail->setFrom($post['email'], $post['firstname'] . " " . $post['lastname']);
                $mail->addTo($to, 'Some Recipient');
                $mail->setSubject($subject);

                $mail->send();

                Mage::getSingleton('core/session')->addSuccess('Your product registration has been submitted for processing successfully.');
                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                // $translate->setTranslateInline(true);
                Mage::getSingleton('core/session')->addError('Unable to submit your request. Please, try again later');
                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }

}