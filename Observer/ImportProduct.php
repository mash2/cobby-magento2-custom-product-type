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
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class ImportProduct implements ObserverInterface
{
    private $productCollectionFactory;

    public function __construct(
        CollectionFactory $productCollectionFactory
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
                $existingProduct['product_type'] = $productType;

                $result['rows'][] = $existingProduct;
            }
        }

        if ($newProducts) {
            foreach ($newProducts as $newProduct) {
                //here you can define, which product type should be set depending for example on the sku prefix
                //you can also use any other attribute and dependency
                if (strpos($newProduct['sku'], 'foo') !== false) {
                    $newProduct['product_type'] = 'virtual';
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