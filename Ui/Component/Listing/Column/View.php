<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class View
 * @package Overdose\PreviewEmail\Ui\Component\Listing\Column
 */
class View extends Column
{
    const URL_PATH_VIEW = 'preview_email/index/view';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * View constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct (
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_VIEW,
                                [
                                    'id' => $item['id'],
                                    'type' => $item['type']
                                ]
                            ),
                            'label' => __('View')
                        ],

                    ];
                }
            }
        }
        return $dataSource;
    }
}
