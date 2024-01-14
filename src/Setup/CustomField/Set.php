<?php

declare(strict_types=1);

/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPiGh\AdditionalMailAddresses\Setup\CustomField;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenContainerEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use function array_map;

class Set
{
    public function __construct(private readonly EntityRepository $setRepo, private readonly EntityRepository $relationRepo)
    {
    }

    public function getFirstId(string $name, Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', $name));

        return $this->setRepo->searchIds($criteria, $context)->firstId();
    }

    public function getRelationId(string $setId, Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('customFieldSetId', $setId));

        return $this->relationRepo->searchIds($criteria, $context)->firstId();
    }

    public function getIds(string $setName, Context $context): array
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsAnyFilter('name', [$setName]));
        $customFieldSetIds = $this->setRepo->searchIds($criteria, $context);
        if ($customFieldSetIds->getTotal() === 0) {
            return [];
        }

        return array_map(static fn($id) => ['id' => $id], $customFieldSetIds->getIds());
    }

    public function upsert(array $data, Context $context): EntityWrittenContainerEvent
    {
        return $this->setRepo->upsert($data, $context);
    }
    public function update(array $data, Context $context): EntityWrittenContainerEvent
    {
        return $this->setRepo->update($data, $context);
    }

    public function delete(array $ids, Context $context): EntityWrittenContainerEvent
    {
        return $this->setRepo->delete($ids, $context);
    }
}
