<?php

namespace Evince\Blogs\Block\Adminhtml\Blog;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Evince\Blogs\Model\BlogFactory;

class ViewDetail extends Template
{
    /**
     * @var BlogFactory
     */
    protected $blogFactory;

    /**
     * @var \Evince\Blogs\Model\Blog|null
     */
    protected $blog = null;

    /**
     * @param Context $context
     * @param BlogFactory $blogFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        BlogFactory $blogFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blogFactory = $blogFactory;
    }

    /**
     * Load and return the blog model
     *
     * @return \Evince\Blogs\Model\Blog
     */
    public function getBlog()
    {
        if ($this->blog === null) {
            $id = $this->getRequest()->getParam('blog_id');
            $this->blog = $this->blogFactory->create()->load($id);
        }
        return $this->blog;
    }
}