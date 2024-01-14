<?php

declare(strict_types=1);
/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPi\AdditionalMailAddresses;

use Doctrine\DBAL\Connection;
use Exception;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use StPi\AdditionalMailAddresses\Setup\CustomField\Definition;
use StPi\AdditionalMailAddresses\Setup\CustomField\Set;
use StPi\AdditionalMailAddresses\Setup\Installer;
use StPi\AdditionalMailAddresses\Setup\Uninstaller;

class StPiAdditionalMailAddresses extends Plugin
{

    /**
     * @throws Exception
     */
    public function install(InstallContext $installContext): void
    {
        (new Installer($this->createSetInstance(), $this->createDefinitionInstance()))
            ->run($installContext);

        parent::install($installContext);
    }



    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);
        if ($uninstallContext->keepUserData()) {
            (new Uninstaller($this->createSetInstance(), $this->createDefinitionInstance()))
                ->setInactive($uninstallContext);
            return;
        }

        (new Uninstaller($this->createSetInstance(), $this->createDefinitionInstance()))
            ->run($uninstallContext);

    }

    private function getUninstaller(): Uninstaller
    {
        return new Uninstaller($this->createSetInstance(), $this->createDefinitionInstance());
    }

    private function getConnection(): Connection
    {
        $connection = $this->container->get(Connection::class);
        if (!$connection instanceof Connection) {
            throw new Exception('DBAL connection service not found!');
        }

        return $connection;
    }

    /**
     * @throws Exception
     */
    private function createSetInstance(): Set
    {
        return new Set($this->getRepository('custom_field_set'), $this->getRepository('custom_field_set_relation'));
    }

    /**
     * @throws Exception
     */
    private function getRepository(string $repo): EntityRepository
    {
        $customFieldSetRepository = $this->container->get($repo . '.repository');
        if (!$customFieldSetRepository instanceof EntityRepository) {
            throw new Exception($repo . '.repository service not found!');
        }

        return $customFieldSetRepository;
    }

    /**
     * @throws Exception
     */
    private function createDefinitionInstance(): Definition
    {
        return new Definition($this->getRepository('custom_field'));
    }
}
