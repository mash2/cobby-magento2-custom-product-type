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
    const CUSTOM_TYPE = 'customType';
    const SIMPLE = 'simple';

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();
        $result = array();

        foreach ($data as $productId => $productData) {

            if ($productData['_attributes']['cobby_custom_product_type'] != '') {
//                $productData['_type'] = $productData['_attributes']['cobby_custom_product_type'];
            }

            $result[$productId] = $productData;
        }

        $observer->getTransport()->setData($result);

        return $this;
    }
}