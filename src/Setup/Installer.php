<?php

declare(strict_types=1);

/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPiGh\AdditionalMailAddresses\Setup;


use Shopware\Core\Framework\Plugin\Context\InstallContext;


class Installer extends Base
{

    public function run(InstallContext $context): void
    {
        $sets = $this->customField->all($context->getContext());
        $this->customFieldSet->upsert($this->searchSetIds($sets, $context), $context->getContext());
    }
}
