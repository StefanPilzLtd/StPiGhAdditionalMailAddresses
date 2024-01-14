<?php

declare(strict_types=1);
/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPiGh\AdditionalMailAddresses\Subscriber;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigConfigSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly SystemConfigService $systemConfigService,
        private readonly Environment         $twig)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onControllerEvent',
        ];
    }

    public function onControllerEvent(ControllerEvent $event): void
    {

        if (!$event->isMainRequest()) {
            return;
        }

        $isPluginActive = (bool)$this->systemConfigService->get('StPiGhAdditionalMailAddresses.config.additionalMailAddressesActive');

        $this->twig->addGlobal('isStPiGhAdditionalMailAddressesActive', $isPluginActive);
    }
}
