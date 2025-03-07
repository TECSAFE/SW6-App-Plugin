<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
#use Frosh\Rector\Set\ShopwareSetList;

return static function (RectorConfig $rectorConfig): void {
    // register single rule
    #$rectorConfig->rule(TypedPropertyFromStrictConstructorRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);

    // here we can define, what sets of rules will be applied
    // tip: use "SetList" class to autocomplete sets with your IDE
    $rectorConfig->sets([
        SetList::CODING_STYLE,
        #ShopwareSetList::SHOPWARE_6_5_0,
        SetList::PHP_82,
        SetList::TYPE_DECLARATION
    ]);
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    #$rectorConfig->import(__DIR__ . '/vendor/frosh/shopware-rector/config/v6.5/renaming.php');
};
