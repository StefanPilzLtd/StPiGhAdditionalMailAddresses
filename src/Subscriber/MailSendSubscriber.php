<?php

declare(strict_types=1);
/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPiGh\AdditionalMailAddresses\Subscriber;


use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent;
use Shopware\Core\Content\MailTemplate\Service\Event\MailBeforeSentEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use StPiGh\AdditionalMailAddresses\Services\OrderCustomerService;

class MailSendSubscriber implements EventSubscriberInterface
{
    public function __construct(
        #[Autowire(service: OrderCustomerService::class)] private readonly OrderCustomerService $orderCustomerService,
        #[Autowire(service: SystemConfigService::class)] private readonly SystemConfigService   $systemConfigService
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MailBeforeSentEvent::class => 'onMailBeforeSend'
        ];
    }

    public function onMailBeforeSend(MailBeforeSentEvent $event): void
    {
        $isPluginActive = (bool)$this->systemConfigService->get('StPiGhAdditionalMailAddresses.config.additionalMailAddressesActive');
        if (!$isPluginActive) {
            return;
        }

        $message = $event->getMessage();
        $eventName = $this->getEventName($event);

        if (!$eventName) {
            //  mail.after.create.message
            return;
        }

        $orderId = $message->getMailAttachmentsConfig()?->getOrderId() ?? false;
        if (!$orderId) {
            return;
        }

        $customerCustomFields = $this->orderCustomerService->getCustomerCustomFieldsByOrderId($orderId);
        $mailAtt = $event->getContext()->getExtension('mail-attachments');
        if ($mailAtt) {
            $documentType = $this->getDocumentType($mailAtt->getDocumentIds());
        }
        $additionalRecipients = [];

        if (str_starts_with($eventName, 'state_enter.order_delivery.state.')) {
            $additionalRecipients = $this->getDeliveryRecipients($customerCustomFields);
        } elseif (str_starts_with($eventName, 'state_enter.order_transaction.state.')) {
            $additionalRecipients = $this->getTransactionRecipients($customerCustomFields);
        } elseif (str_starts_with($eventName, 'state_enter.order.state.') || CheckoutOrderPlacedEvent::EVENT_NAME === $eventName) {
            $additionalRecipients = $this->getOrderRecipients($customerCustomFields);
        }

        foreach ($additionalRecipients as $recipient) {
            $message->addCc($recipient);
        }
    }

    private function getDeliveryRecipients(array $customFields): array
    {
        $return = [];
        for ($i = 0; $i <= 2; $i++) {
            if (isset($customFields['stpi_additional_mailaddresses_mail_' . $i . '_delivery_status']) && $customFields['stpi_additional_mailaddresses_mail_' . $i . '_delivery_status']) {
                $return[] = $customFields['stpi_additional_mailaddresses_mail_' . $i];
            }
        }

        return $return;
    }

    private function getTransactionRecipients(array $customFields): array
    {
        $return = [];
        for ($i = 0; $i <= 2; $i++) {
            if (isset($customFields['stpi_additional_mailaddresses_mail_' . $i . '_payment_status']) && $customFields['stpi_additional_mailaddresses_mail_' . $i . '_payment_status']) {
                $return[] = $customFields['stpi_additional_mailaddresses_mail_' . $i];
            }
        }

        return $return;
    }

    private function getOrderRecipients(array $customFields): array
    {
        $return = [];
        for ($i = 0; $i <= 2; $i++) {
            if (isset($customFields['stpi_additional_mailaddresses_mail_' . $i . '_order_status']) && $customFields['stpi_additional_mailaddresses_mail_' . $i . '_order_status']) {
                $return[] = $customFields['stpi_additional_mailaddresses_mail_' . $i];
            }
        }

        return $return;
    }

    private function getEventName(MailBeforeSentEvent $event)
    {
        $logData = $event->getLogData();

        return $logData['eventName'];
    }

    // next Version
    private function getDocumentType(array $getDocumentIds)
    {
        return '';
    }
}
