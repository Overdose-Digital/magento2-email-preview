<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Sales\Model\OrderRepository;

/**
 * Class Order
 * @package Overdose\PreviewEmail\Model
 */
class Order
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
        $invoices = $order->getInvoiceCollection();

        $vars = [
            'order' => $order,
            'billing' => $order->getBillingAddress(),
            'payment_html' => $this->getPaymentHtml($order),
            'store' => $order->getStore(),
            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
            'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
            'created_at_formatted' => $order->getCreatedAtFormatted(2),
            'order_data' => [
                'customer_name' => $order->getCustomerName(),
                'is_not_virtual' => $order->getIsNotVirtual(),
                'email_customer_note' => $order->getEmailCustomerNote(),
                'frontend_status_label' => $order->getFrontendStatusLabel()
            ]
        ];

        /**
         * Since we are using same class for order confirmation and order shipment email template previews
         * so check if order has shipment available then pass the shipment variable as well.
         */
        if ($order->hasShipments()) {
            $vars['shipment'] = $order->getShipmentsCollection()->getFirstItem();
        }

        /**
         * Assuming there is only one invoice
         */
        $vars['invoice'] = $invoices->getFirstItem();
        return $vars;
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

    /**
     * @param int $entityId
     * @return \Magento\Sales\Api\Data\OrderInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOrderById(int $entityId): \Magento\Sales\Api\Data\OrderInterface
    {
        return $this->orderRepository->get($entityId);
    }
}
