<?php

namespace Evince\Blogs\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Evince\Blogs\Model\BlogFactory;

class View extends Action
{
    const ADMIN_RESOURCE = 'Evince_Blogs::customer_blogs';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var BlogFactory
     */
    protected $blogFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param BlogFactory $blogFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->blogFactory = $blogFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('blog_id');

        if (!$id) {
            $this->messageManager->addErrorMessage(__('Blog ID is missing.'));
            return $this->_redirect('*/*/');
        }

        $blog = $this->blogFactory->create()->load($id);

        if (!$blog->getId()) {
            $this->messageManager->addErrorMessage(__('This blog no longer exists.'));
            return $this->_redirect('*/*/');
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Evince_Blogs::customer_blogs');
        $resultPage->getConfig()->getTitle()->prepend(
            __('Blog: %1', $blog->getBlogTopic())
        );

        return $resultPage;
    }
}