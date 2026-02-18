<?php

namespace Evince\Blogs\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * ID field name
     */
    protected $_idFieldName = 'blog_id';

    /**
     * Initialize collection model
     */
    protected function _construct()
    {
        $this->_init(
            \Evince\Blogs\Model\Blog::class,
            \Evince\Blogs\Model\ResourceModel\Blog::class
        );
    }
}
