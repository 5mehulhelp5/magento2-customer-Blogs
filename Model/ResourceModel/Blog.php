<?php

namespace Evince\Blogs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blog extends AbstractDb
{
    /**
     * Initialize main table and primary key
     */
    protected function _construct()
    {
        $this->_init('evince_customer_blog', 'blog_id');
    }
}
