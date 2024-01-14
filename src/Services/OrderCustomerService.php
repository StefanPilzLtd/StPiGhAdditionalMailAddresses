<?php

/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace StPiGh\AdditionalMailAddresses\Services;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderCustomer\OrderCustomerEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;


class OrderCustomerService
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $orderCustomerRepository;

    /**
     * @var EntityRepository
     */
    private EntityRepository $customerRepository;
    private Context $context;

    public function __construct(EntityRepository $orderCustomerRepository, EntityRepository $customerRepository)
    {
        $this->orderCustomerRepository = $orderCustomerRepository;
        $this->customerRepository = $customerRepository;
        $this->context = Context::createDefaultContext();
    }

    /**
     * @param string $orderId
     * @return array
     */
    public function getCustomerCustomFieldsByOrderId(string $orderId): array
    {
        /** @var OrderCustomerEntity $orderCustomer */
        $orderCustomer = $this->getOrderCustomerByOrderId($orderId);

        if (empty($orderCustomer)) {
            return [];
        }

        $customer = $this->getOrderCustomerById($orderCustomer->getCustomerId());

        return $customer->getCustomFields() ?? [];

    }


    /**
     * @param string $orderId
     * @return OrderCustomerEntity|null
     */
    public function getOrderCustomerByOrderId(string $orderId): ?OrderCustomerEntity
    {

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('orderId', $orderId));
        $orderCustomer = $this->orderCustomerRepository->search($criteria, $this->context);

        return $orderCustomer->first();
    }


    /**
     * @param string $customerId
     * @return CustomerEntity|null
     */
    public function getOrderCustomerById(string $customerId): ?CustomerEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('id', $customerId));
        $customer = $this->customerRepository->search($criteria, $this->context);

        return $customer->first();
    }
}
