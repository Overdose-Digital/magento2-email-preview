<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 * @package Overdose\PreviewEmail\Controller\Adminhtml\Index
 */
class View extends Action
{
    /** @var PageFactory */
    protected $resultPageFactory;

    /**
     * View constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
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
        return $this->resultPageFactory->create();
    }
}
