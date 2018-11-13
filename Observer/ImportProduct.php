<?php
/**
 * Created by PhpStorm.
 * User: slavko
 * Date: 13.11.18
 * Time: 10:53
 */

namespace Cobby\CustomProductType\Observer;

use Magento\Framework\Event\ObserverInterface;

class ImportProduct implements ObserverInterface
{
    const SIMPLE = 'simple';

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();
        $result = array();
        foreach ($data as $productId => $productData) {
            $productData['_type'] = self::SIMPLE;
            $result[$productId] = $productData;
        }
        $observer->getTransport()->setData($result);
        return $this;
    }
}