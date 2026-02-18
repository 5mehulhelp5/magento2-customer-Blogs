<?php

namespace Evince\Blogs\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Evince\Blogs\Model\BlogFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Evince_Blogs::customer_blogs';

    protected $blogFactory;

    public function __construct(
        Action\Context $context,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('blog_id');

        if ($id) {
            $this->blogFactory->create()->load($id)->delete();
            $this->messageManager->addSuccessMessage(__('Blog deleted successfully.'));
        }

        return $this->_redirect('*/*/');
    }
}
