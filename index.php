<?php
// Product Results Example
$products = [
    [
        'id' => 1,
        'name' => 'Alabaster Table',
        'price' => 12.99,
        'created' => '2019-01-04',
        'sales_count' => 32,
        'views_count' => 730,
    ],
    [
        'id' => 2,
        'name' => 'Zebra Table',
        'price' => 44.49,
        'created' => '2012-01-04',
        'sales_count' => 301,
        'views_count' => 3279,
    ],
    [
        'id' => 3,
        'name' => 'Coffee Table',
        'price' => 10.00,
        'created' => '2014-05-28',
        'sales_count' => 1048,
        'views_count' => 20123,
    ]
];

// Sorter interface for all sorters
interface Sorter {
    public function sort($products);
}

// Sorter implementation for sorting by price
class ProductPriceSorter implements Sorter
{
    /**
     * @param $products
     * @return mixed
     */
    public function sort($products): mixed
    {
        usort($products, function ($a, $b) {
            return $a['price'] <=> $b['price'];
        });
        return $products;
    }
}

// Sorter implementation for sorting by the ratio of sales per view
class ProductsSalesPerViewSorter implements Sorter
{
    /**
     * @param $products
     * @return mixed
     */
    public function sort($products): mixed
    {
        usort($products, function ($a, $b) {
            $ratioA = $a['sales_count'] / $a['views_count'];
            $ratioB = $b['sales_count'] / $b['views_count'];
            return $ratioA <=> $ratioB;
        });
        return $products;
    }
}

// Catalog class that uses the sorters
class Catalog
{
    /**
     * @param array $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * @param Sorter $sorter
     * @return mixed
     */
    public function getProducts(Sorter $sorter): mixed
    {
        return $sorter->sort($this->products);
    }
}


// Create the catalog using Product Price Sorter
$catalog = new Catalog($products);
$sortedProductsByPrice = $catalog->getProducts(new ProductPriceSorter());
echo "Sorted by price:\n";
echo "########################\n";
foreach ($sortedProductsByPrice as $product) {
    echo $product['name'] .' - '.  $product['price'] . "\n";
}

echo '\n';echo '\n';

// Create the catalog with Products Sales Per View Sorter
$catalog = new Catalog($products);
$sortedProductsBySalesPerView = $catalog->getProducts(new ProductsSalesPerViewSorter());
echo "Sorted by sales per view:\n";
echo "########################\n";
foreach ($sortedProductsBySalesPerView as $product) {
    echo $product['name'] . ' - ' . $product['sales_count']/$product['views_count']. "\n";
}