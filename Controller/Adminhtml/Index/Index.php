<?php

namespace Overdose\PreviewEmail\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Email\Model\Template\Config;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $templateConfig;
    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Config $templateConfig
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Config $templateConfig
    ) {
        $this->templateConfig = $templateConfig;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);

    }

    /**
     * @return Page
     */
    public function execute()
    {
        $this->templateConfig;
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Preview Email Template')));

        return $resultPage;
    }


}