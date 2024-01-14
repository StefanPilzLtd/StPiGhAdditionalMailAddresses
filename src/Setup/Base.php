<?php

declare(strict_types=1);

/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPiGh\AdditionalMailAddresses\Setup;

use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use StPiGh\AdditionalMailAddresses\Exception\CustomFieldSetNotFoundException;
use StPiGh\AdditionalMailAddresses\Setup\CustomField\Definition;
use StPiGh\AdditionalMailAddresses\Setup\CustomField\Set;

abstract class Base
{
    public function __construct(protected Set $customFieldSet, protected Definition $customField)
    {
    }

    protected function searchSetIds(array $sets, InstallContext $context): array
    {
        foreach ($sets as &$set) {
            $id = $this->customFieldSet->getFirstId($set['name'], $context->getContext());
            if ($id === null) {
                if ($context instanceof UpdateContext) {
                    throw new CustomFieldSetNotFoundException($set['name']);
                }

                continue;
            }
            $set['id'] = $id;
            if (!isset($set['relations'])) {
                continue;
            }
            foreach ($set['relations'] as &$relation) {
                $relationId = $this->customFieldSet->getRelationId($set['id'], $context->getContext());
                if ($relationId !== null) {
                    $relation['id'] = $relationId;
                }
            }
            if (empty($set['relations'])) {
                unset($set['relations']);
            }
        }

        return $sets;
    }


}
