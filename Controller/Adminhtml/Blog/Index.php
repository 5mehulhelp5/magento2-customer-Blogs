<?php

namespace Evince\Blogs\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Evince_Blogs::customer_blogs';

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Evince_Blogs::customer_blogs');
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Blogs'));

        return $resultPage;
    }
}
