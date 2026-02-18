<?php

namespace Evince\Blogs\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Evince\Blogs\Model\BlogFactory;
use Magento\Framework\Exception\LocalizedException;

class Submit extends Action
{
    /**
     * @var BlogFactory
     */
    protected $blogFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param BlogFactory $blogFactory
     */
    public function __construct(
        Context $context,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
    }

    /**
     * Execute method
     *
     * @return Redirect
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->getRequest()->isPost()) {
            return $resultRedirect->setPath('blogs');
        }

        try {
            $data = $this->getRequest()->getPostValue();

            if (!$data) {
                throw new LocalizedException(__('Invalid form data.'));
            }

            /** Create model instance */
            $blog = $this->blogFactory->create();

            /** Set data manually (safer than setData($data)) */
            $blog->setBlogTopic($data['blog_topic'] ?? null);
            $blog->setMetaDescription($data['meta_description'] ?? null);
            $blog->setBlogContent($data['blog_content'] ?? null);
            $blog->setKeywords($data['keywords'] ?? null);
            $blog->setMetaTitle($data['meta_title'] ?? null);
            $blog->setAuthorName($data['author_name'] ?? null);
            $blog->setReviewTitle($data['review_title'] ?? null);

            $blog->save();

            $this->messageManager->addSuccessMessage(__('Your blog has been submitted successfully.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the blog.'));
        }

        return $resultRedirect->setPath('blogs');
    }
}
