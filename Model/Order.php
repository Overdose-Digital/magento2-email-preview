<?php
declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\OrderRepository;

class Order
{
    /**
     * @var Renderer
     */
    protected $_render;
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var PaymentHelper
     */
    private $paymentData;
    /**
     * @var Invoice
     */
    private $invoice;

    /**
     * Order constructor.
     * @param Renderer $renderer
     */
    public function __construct
    (
        Renderer $renderer,
        OrderRepository $orderRepository,
        PaymentHelper $paymentHelper,
        Invoice $invoice
    ) {
        $this->_render = $renderer;
        $this->orderRepository = $orderRepository;
        $this->paymentData = $paymentHelper;
        $this->invoice = $invoice;
    }

    /**
     * Get Order Vars
     * @param $id
     * @return array
     */
    public function getVars($id)
    {
        $order = $this->orderRepository->get($id);
        $invoices = $order->getInvoiceCollection();

        $vars = [
            'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
            'payment_html' => $this->getPaymentHtml($order),
            'order' => $order,
        ];
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
     */
    protected function getPaymentHtml($order)
    {
        return $this->paymentData->getInfoBlockHtml(
            $order->getPayment(),
            $order->getStoreId()
        );
    }
}
