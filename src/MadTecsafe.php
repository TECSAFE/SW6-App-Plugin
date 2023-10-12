<?php

declare(strict_types=1);

namespace Madco\Tecsafe;

use Madco\Tecsafe\Install\ProductCustomFieldInstaller;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class MadTecsafe extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        $productCustomFieldInstaller = $this->createProductCustomFieldInstaller();

        $productCustomFieldInstaller->addOfcpCustomFieldSet($installContext->getContext());
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if ($uninstallContext->keepUserData()) {
            return;
        }

        $productCustomFieldInstaller = $this->createProductCustomFieldInstaller();
        $productCustomFieldInstaller->deleteOfcpCustomFieldSet($uninstallContext->getContext());
    }

    private function createProductCustomFieldInstaller(): ProductCustomFieldInstaller
    {
        $productRepository = $this->container->get('product.repository');
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        if (!$productRepository instanceof EntityRepository) {
            throw new \RuntimeException("Not an instance of EntityRepository");
        }

        if (!$customFieldSetRepository instanceof EntityRepository) {
            throw new \RuntimeException("Not an instance of EntityRepository");
        }

        return new ProductCustomFieldInstaller(
            $productRepository,
            $customFieldSetRepository
        );
    }
}
