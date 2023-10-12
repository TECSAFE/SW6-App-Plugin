<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Install;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;

class ProductCustomFieldInstaller
{
    public const TECSAFE_OFCP_CUSTOM_FIELD_SET_NAME = 'tecsafe_ofcp_set';
    public function __construct(
        private readonly EntityRepository $productRepository,
        private readonly EntityRepository $customFieldSetRepository
    ) {
    }

    public function addOfcpCustomFieldSet(Context $context): void
    {
        $ids = $this->getOfcpCustomFieldSetId($context);

        if ($ids) {
            return;
        }

        $this->customFieldSetRepository->create([
            [
                'name' => self::TECSAFE_OFCP_CUSTOM_FIELD_SET_NAME,
                'config' => [
                    'label' => [
                        'en-GB' => 'Tecsafe OFCP',
                        'de-DE' => 'Tecsafe OFCP',
                    ]
                ],
                'customFields' => [
                    [
                        'name' => 'tecsafe_enabled',
                        'type' => CustomFieldTypes::BOOL,
                        'config' => [
                            'label' => [
                                'en-GB' => 'Enable OFCP',
                                'de-DE' => 'OFCP aktivieren',
                            ],
                            'customFieldPosition' => 0,
                        ]
                    ]
                ],
                'relations' => [
                    [
                        'id' => Uuid::randomHex(),
                        'entityName' => ProductDefinition::ENTITY_NAME,
                    ]
                ]
            ]
        ], $context);
    }

    public function deleteOfcpCustomFieldSet(Context $context): void
    {
        $ids = $this->getOfcpCustomFieldSetId($context);

        if ($ids) {
            $this->customFieldSetRepository->delete($ids, $context);
        }
    }

    public function getOfcpCustomFieldSetId(Context $context): ?array
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', self::TECSAFE_OFCP_CUSTOM_FIELD_SET_NAME));
        $ids = $this->customFieldSetRepository->searchIds($criteria, $context);

        if ($ids->getTotal() > 0) {
            return array_values($ids->getData());
        }

        return null;
    }

    public function getCustomFields(String $productId, Context $context): ?array
    {
        try {
            $criteria = new Criteria([$productId]);
            $criteria->addAssociation(self::TECSAFE_OFCP_CUSTOM_FIELD_SET_NAME);
            $product = $this->productRepository->search($criteria, $context);

            if ($product->getTotal() == 0) {
                return null;
            }

            return $product->get($productId)->customFields;
        } catch (\Exception $ignored) {
            return null;
        }
    }
}
