<?php

namespace Evince\Blogs\Model\Blog;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Evince\Blogs\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\Api\Filter;

class DataProvider extends AbstractDataProvider
{
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
     * Return data in format Magento UI grid expects.
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
            'items'        => array_key_exists('items', $items) ? $items['items'] : $items,
        ];
    }

    /**
     * Add filter to collection.
     *
     * @param Filter $filter
     * @return void
     */
    public function addFilter(Filter $filter)
    {
        $field     = $filter->getField();
        $condition = $filter->getConditionType() ?: 'eq';
        $value     = $filter->getValue();

        /**
         * Fulltext / keyword search box.
         * Correct OR format for Magento collections:
         *   addFieldToFilter(['col1','col2'], [['like'=>'%v%'],['like'=>'%v%']])
         * Each array element in the second param corresponds to the same-index field.
         */
        if ($field === 'fulltext') {
            $likeValue  = '%' . $value . '%';
            $fields     = ['blog_topic', 'author_name', 'keywords', 'meta_title', 'meta_description', 'blog_content'];
            $conditions = [];
            foreach ($fields as $f) {
                $conditions[] = ['like' => $likeValue];
            }
            $this->getCollection()->addFieldToFilter($fields, $conditions);
            return;
        }

        /**
         * Date range filter — UI sends gteq (from) and lteq (to) separately.
         */
        if (in_array($condition, ['gteq', 'lteq', 'from', 'to'], true)) {
            $this->getCollection()->addFieldToFilter($field, [$condition => $value]);
            return;
        }

        /**
         * Column text filters — UI sends conditionType='like' with raw value (no wildcards).
         */
        if ($condition === 'like') {
            $this->getCollection()->addFieldToFilter($field, ['like' => '%' . $value . '%']);
            return;
        }

        // Fallback
        $this->getCollection()->addFieldToFilter($field, [$condition => $value]);
    }

    /**
     * Add sort order.
     *
     * @param string $field
     * @param string $direction
     * @return void
     */
    public function addOrder($field, $direction)
    {
        $this->getCollection()->setOrder($field, strtoupper($direction));
    }

    /**
     * Set pagination.
     * $offset = current page number (not row offset).
     *
     * @param int $offset
     * @param int $size
     * @return void
     */
    public function setLimit($offset, $size)
    {
        $this->getCollection()->setPageSize($size)->setCurPage($offset);
    }
}