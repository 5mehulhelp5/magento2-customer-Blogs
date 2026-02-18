<?php

namespace Evince\Blogs\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class BlogActions extends Column
{
    const URL_PATH_VIEW   = 'blogs/blog/view';
    const URL_PATH_DELETE = 'blogs/blog/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['blog_id'])) {
                    $id = $item['blog_id'];
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href'  => $this->urlBuilder->getUrl(self::URL_PATH_VIEW, ['blog_id' => $id]),
                            'label' => __('View'),
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['blog_id' => $id]),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete Blog'),
                                'message' => __('Are you sure you want to delete this blog?'),
                            ],
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}