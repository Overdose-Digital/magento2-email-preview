<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Newsletter\Model\SubscriberFactory;

/**
 * Class SubscriptionSuccess
 * @package Overdose\PreviewEmail\Model
 */
class SubscriptionSuccess implements \Overdose\PreviewEmail\Api\Data\PreviewTemplateVaribles
{
    /** @var SubscriberFactory */
    private $subscriber;

    /**
     * SubscriptionSuccess constructor.
     * @param SubscriberFactory $subscriberFactory
     */
    public function __construct(
        SubscriberFactory $subscriberFactory
    ) {
        $this->subscriber = $subscriberFactory;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getVars(int $id): array
    {
        /** @var \Magento\Newsletter\Model\Subscriber $subscriber */
        $subscriber = $this->subscriber->create();
        $currentCustomer = $subscriber->loadByCustomerId($id);
        return [
            'subscriber' => $currentCustomer
        ];
    }

}
