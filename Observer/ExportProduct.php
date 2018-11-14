<?php
/**
 * Created by PhpStorm.
 * User: mash2
 * Date: 09.11.18
 * Time: 12:00
 */

namespace Cobby\CustomProductType\Observer;

use Magento\Framework\Event\ObserverInterface;

class ExportProduct implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();
        $result = array();

        foreach ($data as $productId => $productData) {

            //checking custom product type in admin store
            if ($productData['_attributes'][0]['cobby_custom_product_type'] != '') {
                $productData['_type'] = $productData['_attributes'][0]['cobby_custom_product_type'];
            }

            $result[$productId] = $productData;
        }

        $observer->getTransport()->setData($result);

        return $this;
    }
}