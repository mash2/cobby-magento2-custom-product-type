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

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();
        $result = array();
        foreach ($data as $productId => $productData) {
            $productData['_type'] = self::CUSTOM_TYPE;
            $result[$productId] = $productData;
        }
        $observer->getTransport()->setData($result);
        return $this;
    }
}