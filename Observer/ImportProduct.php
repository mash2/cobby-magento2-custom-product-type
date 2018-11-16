<?php
/**
 * Created by PhpStorm.
 * User: slavko
 * Date: 13.11.18
 * Time: 10:53
 */

namespace Cobby\CustomProductType\Observer;

use Magento\Framework\Event\ObserverInterface;
use Mash2\Cobby\Model\Import\Product\ProductManagement;

class ImportProduct implements ObserverInterface
{
    const SIMPLE = 'simple';
    const CONFIGURABLE = 'configurable';
    const VIRTUAL = 'virtual';
    const PREFIX = 'foo';

    private $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();

        $result = array();
        $entityIds = array();
        $existingProducts = array();
        $newProducts = array();

        $typeModels = $data['type_models'];
        $usedSkus = $data['used_skus'];
        $products = $data['rows'];

        foreach ($products as $product) {
            if (isset($product[ProductManagement::COL_PRODUCT_ID])) {
                $entityIds[] = $product[ProductManagement::COL_PRODUCT_ID];
                $existingProducts[] = $product;
            } else {
                $newProducts[] = $product;
            }
        }

        if ($existingProducts) {
            $collection = $this->productCollectionFactory->create();
            $items = $collection
                ->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID)
                ->addAttributeToFilter('entity_id', array('in'=> $entityIds))
                ->load();

            $productData = $items->toArray(array('entity_id', 'sku', 'type_id'));

            foreach ($existingProducts as $existingProduct) {
                //this switches the import product type with the value from the backend
                $productType = $productData[$existingProduct['entity_id']]['type_id'];
                $product['product_type'] = $productType;

                $result['rows'][] = $product;
            }
        }

        if ($newProducts) {
            foreach ($newProducts as $newProduct) {
                //here you can define, which product type should be set depending for example on the sku prefix
                if (strpos($newProduct['sku'], self::PREFIX) !== false) {
                    $newProduct['product_type'] = self::VIRTUAL;
                }

                $result['rows'][] = $newProduct;
            }
        }

        $result['used_skus'] = $usedSkus;
        $result['type_models'] = $typeModels;

        $observer->getTransport()->setData($result);

        return $this;
    }
}