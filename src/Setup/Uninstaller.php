<?php

declare(strict_types=1);
/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPi\AdditionalMailAddresses\Setup;

use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use StPi\AdditionalMailAddresses\Components\Definition\CustomFieldCustomer;

class Uninstaller extends Base
{

    public function run(UninstallContext $context): void
    {
        $customField = new CustomFieldCustomer;
        $customFieldSetId = $this->customFieldSet->getFirstId($customField::SET_NAME, $context->getContext());
        if ($customFieldSetId) {
            $this->customFieldSet->delete([['id' => $customFieldSetId]], $context->getContext());
        }
    }

    public function setInactive(UninstallContext $context): void
    {
        $customField = new CustomFieldCustomer;
        $customFieldSetId = $this->customFieldSet->getFirstId($customField::SET_NAME, $context->getContext());
        if ($customFieldSetId) {
            $data = [
                'id' => $customFieldSetId,
                'active' => false
            ];
            $this->customFieldSet->update([$data], $context->getContext());
        }

    }
}
