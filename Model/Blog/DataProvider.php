<?php

namespace Evince\Blogs\Model\Blog;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Evince\Blogs\Model\ResourceModel\Blog\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var \Evince\Blogs\Model\ResourceModel\Blog\Collection
     */
    protected $collection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data in the format expected by Magento UI grid:
     * ['totalRecords' => int, 'items' => array]
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection()->toArray();

        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_key_exists('items', $items) ? $items['items'] : $items,
        ];
    }
}