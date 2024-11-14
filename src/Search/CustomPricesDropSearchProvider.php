<?php 

namespace ScSpecials\Search;

use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchProviderInterface;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchResult;
use Context;
use Db;

class CustomPricesDropSearchProvider implements ProductSearchProviderInterface
{
    public function runQuery(ProductSearchQuery $query, Context $context)
    {
        $sortOrder = $query->getSortOrder();
        $sortField = $sortOrder->getField();

        $allowedSortFields = [
            'reduction_to' => 'sp.to',
        ];

        $sortField = $allowedSortFields[$sortField] ?? 'p.id_product';

        $sql = 'SELECT p.*, sp.to 
                FROM ' . _DB_PREFIX_ . 'product p
                JOIN ' . _DB_PREFIX_ . 'specific_price sp ON p.id_product = sp.id_product
                WHERE sp.to IS NOT NULL
                ORDER BY ' . $sortField . ' ' . $sortOrder->getDirection();

        $products = Db::getInstance()->executeS($sql);

        $result = new ProductSearchResult();
        $result->setProducts($products);
        $result->setTotalProductsCount(count($products));

        return $result;
    }
}
