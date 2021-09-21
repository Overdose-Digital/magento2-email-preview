<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Sales\Model\OrderRepository;

/**
 * Class CreditMemo
 * @package Overdose\PreviewEmail\Model
 */
class CreditMemo implements \Overdose\PreviewEmail\Api\Data\PreviewTemplateVaribles
{
    /** @var Renderer */
    protected $_render;

    /** @var OrderRepository */
    private $orderRepository;

    /** @var PaymentHelper */
    private $paymentData;

    /**
     * Order constructor.
     * @param Renderer $renderer
     * @param OrderRepository $orderRepository
     * @param PaymentHelper $paymentHelper
     */
    public function __construct (
        Renderer $renderer,
        OrderRepository $orderRepository,
        PaymentHelper $paymentHelper
    ) {
        $this->_render = $renderer;
        $this->orderRepository = $orderRepository;
        $this->paymentData = $paymentHelper;
    }

    /**
     * @param $id
     * @return array
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getVars($id): array
    {
        $order = $this->orderRepository->get($id);

        /** @var \Magento\Sales\Model\Order\Creditmemo $creditMemo */
        $creditMemo = $order->getCreditmemosCollection()->getFirstItem();

        /** @var \Magento\Sales\Api\Data\CreditmemoCommentInterface[] $comments */
        $comments = $creditMemo->getComments();
        $comment = '';
        if (count($comments)) {
            /** @var \Magento\Sales\Model\Order\Creditmemo\Comment $comment */
            foreach ($comments as $comment) {
                $comment = $comment->getComment();
                break;
            }
        }

        return [
            'order' => $order,
            'creditmemo' => $creditMemo,
            'comment' => $comment,
            'billing' => $order->getBillingAddress(),
            'payment_html' => $this->getPaymentHtml($order),
            'store' => $order->getStore(),
            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
            'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
            'order_data' => [
                'customer_name' => $order->getCustomerName(),
                'is_not_virtual' => $order->getIsNotVirtual(),
                'email_customer_note' => $order->getEmailCustomerNote(),
                'frontend_status_label' => $order->getFrontendStatusLabel()
            ]
        ];
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return string|null
     */
    protected function getFormattedBillingAddress($order)
    {
        return $this->_render->format($order->getBillingAddress(), 'html');
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return string|null
     */
    protected function getFormattedShippingAddress($order)
    {
        return $this->_render->format($order->getShippingAddress(), 'html');
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return string
     * @throws \Exception
     */
    protected function getPaymentHtml($order): string
    {
        return $this->paymentData->getInfoBlockHtml(
            $order->getPayment(),
            $order->getStoreId()
        );
    }
}
