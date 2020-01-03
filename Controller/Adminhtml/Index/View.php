<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Email\Model\ResourceModel\Template\CollectionFactory;
use Magento\Email\Model\Template\Config;
use Magento\Framework\View\Result\PageFactory;
use Overdose\PreviewEmail\Model\EmailTemplate\DataProvider;


class View extends Action
{
    /**
     * @var EmailTemplateInterfaceFactory;
     */
    public $emailTemplateFactory;
    /**
     * @var
     */
    public $repository;
    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;
    /**
     * @var DataProvider
     */
    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var Config */
    protected $emailConfig;
    /**
     * @var
     */
    protected $templateCollectionFactory;

    /**
     * Index constructor.
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

    public function execute()
    {
        return $resultPage = $this->resultPageFactory->create();

    }


}