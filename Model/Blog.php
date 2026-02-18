<?php

namespace Evince\Blogs\Model;

use Magento\Framework\Model\AbstractModel;
use Evince\Blogs\Model\ResourceModel\Blog as ResourceModel;

class Blog extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
