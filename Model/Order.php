<?php declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Sales\Model\Order\Invoice;
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
            'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
            'payment_html' => $this->getPaymentHtml($order),
            'order' => $order,
        ];

        /** @var Invoice $invoice */
        foreach ($invoices->getItems() as $invoice) {
            $vars['invoice'] = $invoice;
        }
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
}
