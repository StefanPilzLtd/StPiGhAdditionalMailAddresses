<?php

declare(strict_types=1);

/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPi\AdditionalMailAddresses\Setup\CustomField;

use ReflectionClass;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use function array_filter;
use function array_map;
use function in_array;

class Definition
{
    public function __construct(private readonly EntityRepository $customFieldRepository)
    {
    }

    /**
     * @param Context $context
     * @return array[]
     */
    public function all(Context $context): array
    {
        return [
            $this->getCustomFieldSet('CustomFieldCustomer', $context),
        ];
    }



    private function findIdByNameAndMerge(array $fieldProps, Context $context): array
    {
        $id = $this->getFirstId($fieldProps['name'], $context);
        if ($id !== null) {
            $fieldProps['id'] = $id;
        }

        return $fieldProps;
    }

    private function getFirstId(string $name, Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', $name));

        return $this->customFieldRepository->searchIds($criteria, $context)->firstId();
    }

    private function getCustomFieldSet(string $classname, Context $context, array $only = []): array
    {
        $definitionClass = new ReflectionClass('StPi\AdditionalMailAddresses\Components\Definition\\'.$classname);

        $customFields = $definitionClass->getConstant('SET_CONTENT'); //NOSONAR
        if ($only !== []) {
            $customFields = array_filter($customFields, fn(array $customField): bool => in_array($customField['name'], $only, true));
            if ($customFields === []) {
                return [];
            }
        }
        $customFields = array_map(fn(array $customField) => $this->findIdByNameAndMerge($customField, $context), $customFields);

        return [
            'name' => $definitionClass->getConstant('SET_NAME'), //NOSONAR
            'active' => true,
            'config' => [
                'label' => [
                    'de-DE' => $definitionClass->getConstant('SET_LABEL_DE'), //NOSONAR
                    'en-GB' => $definitionClass->getConstant('SET_LABEL_GB'), //NOSONAR
                ],
                'translated' => true,
            ],
            'customFields' => $customFields,
            'relations' => [
                [
                    'id' => Uuid::randomHex(),
                    'entityName' => $definitionClass->getConstant('SET_ENTITY_NAME'), //NOSONAR
                ],
            ],
        ];
    }

}
