<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Preview
 * @package Overdose\PreviewEmail\Controller\Adminhtml\Index
 */
class Preview extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;

    /**
     * Preview constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct (
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Preview')));
        return $resultPage;
    }
}
