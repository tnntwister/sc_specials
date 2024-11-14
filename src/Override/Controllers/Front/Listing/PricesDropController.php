<?php

namespace ScSpecials\Override\Controllers\Front\Listing;

use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

class PricesDropController extends \PricesDropControllerCore
{
    public function getProductSearchQuery()
    {
        $query = new ProductSearchQuery();
        $query->setQueryType('prices-drop')
              ->setSortOrder(new SortOrder('specific_price', 'to', 'asc')); // Tri par date de fin de promotion.

        return $query;
    }
}