<?php

declare(strict_types=1);

namespace Overdose\PreviewEmail\Model;

/**
 * Class ConfigPaths
 * @package Overdose\PreviewEmail\Model
 */
class ConfigPaths
{
    /**
     * @return string
     */
    public static function guestOrderConfirmationEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\OrderIdentity::XML_PATH_EMAIL_GUEST_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function orderConfirmationEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\OrderIdentity::XML_PATH_EMAIL_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function guestInvoiceEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\InvoiceIdentity::XML_PATH_EMAIL_GUEST_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function invoiceEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\InvoiceIdentity::XML_PATH_EMAIL_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function guestShipmentEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\ShipmentIdentity::XML_PATH_EMAIL_GUEST_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function shipmentEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\ShipmentIdentity::XML_PATH_EMAIL_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function guestCreditMemoEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\CreditmemoIdentity::XML_PATH_EMAIL_GUEST_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function creditMemoEmailConfigPath(): string
    {
        return \Magento\Sales\Model\Order\Email\Container\CreditmemoIdentity::XML_PATH_EMAIL_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function registerEmailTemplate(): string
    {
        return \Magento\Customer\Model\EmailNotification::XML_PATH_REGISTER_EMAIL_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function resetPasswordEmailTemplate(): string
    {
        return \Magento\Customer\Model\EmailNotification::XML_PATH_RESET_PASSWORD_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function contactFormEmailTemplate(): string
    {
        return \Magento\Contact\Model\ConfigInterface::XML_PATH_EMAIL_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function subscriptionSuccessEmailTemplate(): string
    {
        return \Magento\Newsletter\Model\Subscriber::XML_PATH_SUCCESS_EMAIL_TEMPLATE;
    }
}
