<?php

namespace Evince\Blogs\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Evince\Blogs\Model\ResourceModel\Blog\CollectionFactory;

class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'Evince_Blogs::customer_blogs';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $count = 0;

        foreach ($collection as $item) {
            $item->delete();
            $count++;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 blog(s) have been deleted.', $count)
        );

        return $this->_redirect('*/*/');
    }
}