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
    const CONFIGURABLE = 'configurable';

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();

        $result = array();

        $typeModels = $data['type_models'];
        $usedSkus = $data['used_skus'];
        $products = $data['rows'];


        foreach ($products as $product) {
            if ($product['product_type'] == self::SIMPLE ||
                    $product['product_type'] == self::CONFIGURABLE) {

                $result[] = $product;
                continue;
            }

            $product['attributes'][0]['cobby_custom_product_type'] = $product['product_type'];
            $product['product_type'] = self::SIMPLE;

            $result['rows'][] = $product;
        }

        foreach ($typeModels as $typeModel) {
            if ($typeModel == self::SIMPLE ||
                    $typeModel == self::CONFIGURABLE) {

                $result['type_models'][] = $typeModel;
                continue;
            }
            $typeModel = self::SIMPLE;

            $result['type_models'][] = $typeModel;
        }

        $result['used_skus'] = $usedSkus;

        $observer->getTransport()->setData($result);

        return $this;
    }
}