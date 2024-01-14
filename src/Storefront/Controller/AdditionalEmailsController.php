<?php

declare(strict_types=1);
/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPi\AdditionalMailAddresses\Storefront\Controller;


use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\Adapter\Translation\AbstractTranslator;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class AdditionalEmailsController extends StorefrontController
{
    private Context $context;

    public function __construct(
        #[Autowire(service: 'customer.repository')] private readonly EntityRepository $customerRepository,
        #[Autowire(service: 'translator')] private readonly AbstractTranslator  $translator
    )
    {
        $this->context = Context::createDefaultContext();
    }

    #[Route(path: '/account/additional-emails', name: 'frontend.account.stpi.additional_emails.page', options: ["scope" => "storefront"], methods: ['GET'])]
    public function additionalEmails(Request $request): Response
    {
        /** @var CustomerEntity $userD */
        $userD = $request->attributes->get('sw-sales-channel-context')->getCustomer();

        if(!$userD){
            $this->addFlash(self::DANGER,$this->translator->trans('StPiAdditionalMailAddresses.messages.login'));
            return $this->redirectToRoute('frontend.account.login.page');
        }

        $customFields = $userD->getCustomFields();
        $additionalEmails = [];
        for ($i = 0; $i <= 2; $i++) {
            $additionalEmails[$i] = [
                'stpi_additional_mailaddresses_mail_' . $i => $customFields['stpi_additional_mailaddresses_mail_' . $i] ?? '',
                'stpi_additional_mailaddresses_mail_' . $i . '_payment_status' => $customFields['stpi_additional_mailaddresses_mail_' . $i . '_payment_status'] ?? '0',
                'stpi_additional_mailaddresses_mail_' . $i . '_order_status' => $customFields['stpi_additional_mailaddresses_mail_' . $i . '_order_status'] ?? '0',
                'stpi_additional_mailaddresses_mail_' . $i . '_delivery_status' => $customFields['stpi_additional_mailaddresses_mail_' . $i . '_delivery_status'] ?? '0',
            ];
        }

        return $this->render('@StPiAdditionalMailAddresses/storefront/page/account/additional_emails/account-layout.html.twig', [
            'additionalEmails' => $additionalEmails,
        ]);
    }

    #[Route(path: '/account/additional-emails/save', name: 'frontend.stpi.additional_emails.save', methods: ['POST'])]
    public function saveAdditionalEmails(Request $request): Response
    {
        /** @var CustomerEntity $userD */
        $userD = $request->attributes->get('sw-sales-channel-context')->getCustomer();

        if(!$userD){
            $this->addFlash(self::DANGER,$this->translator->trans('StPiAdditionalMailAddresses.messages.login'));
            return $this->redirectToRoute('frontend.account.login.page');
        }

        $customFields = $userD->getCustomFields() ?? [];
        $additionalEmails = array();
        $i = 0;
        foreach ($request->request->all() as $key => $additionalEmail)
        {
            $defaults = [
                'stpi_additional_mailaddresses_mail_' . $i  => '',
                'stpi_additional_mailaddresses_mail_' . $i . '_payment_status' => false,
                'stpi_additional_mailaddresses_mail_' . $i . '_order_status' => false,
                'stpi_additional_mailaddresses_mail_' . $i . '_delivery_status' => false,
            ];

            foreach ($defaults as $field => $defaultValue) {
                if(isset($additionalEmail[$field]) && is_bool($defaultValue)){
                    $additionalEmails[$field] = (bool) $additionalEmail[$field]; // for checkboxes
                }else{
                    $additionalEmails[$field] = $additionalEmail[$field] ?? $defaultValue;
                }
            }

            $i++;
        }

        $data = [
            'id' => $userD->getId(),
            'customFields' => array_merge($customFields, $additionalEmails)

        ];
        $entityWrittenContainerEvent = $this->customerRepository->update([$data], $this->context);

        if(!empty($entityWrittenContainerEvent->getErrors())){
            $this->addFlash(self::DANGER,$this->translator->trans('StPiAdditionalMailAddresses.messages.saveAdditionalEmails.danger'));
        }else{
            $this->addFlash(self::SUCCESS,$this->translator->trans('StPiAdditionalMailAddresses.messages.saveAdditionalEmails.success'));
        }


        return $this->redirectToRoute('frontend.account.stpi.additional_emails.page');
    }


}
