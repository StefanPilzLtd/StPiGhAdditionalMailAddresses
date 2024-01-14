<?php

declare(strict_types=1);

/*
 * (c) Stefan Pilz Ltd. <plugins@stefanpilz.ltd>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StPiGh\AdditionalMailAddresses\Components\Definition;

use Shopware\Core\System\CustomField\CustomFieldTypes;

class CustomFieldCustomer implements CustomFieldInterface
{

    public const SET_NAME = 'stpi_additional_mailaddresses_customer';
    public const SET_LABEL_DE = 'StPi zusätzliche E-Mail-Adressen';
    public const SET_LABEL_GB = 'StPi additional e-mail addresses';
    public const SET_ENTITY_NAME = 'customer';



     public const SET_CONTENT = [
        self::MAILADDRESS_0,
        self::MAILADDRESS_0_PAYMENT_STATUS,
        self::MAILADDRESS_0_ORDER_STATUS,
        self::MAILADDRESS_0_DELIVERY,
        self::MAILADDRESS_1,
        self::MAILADDRESS_1_PAYMENT_STATUS,
        self::MAILADDRESS_1_ORDER_STATUS,
        self::MAILADDRESS_1_DELIVERY,
        self::MAILADDRESS_2,
        self::MAILADDRESS_2_PAYMENT_STATUS,
        self::MAILADDRESS_2_ORDER_STATUS,
        self::MAILADDRESS_2_DELIVERY
    ];
    final public const MAILADDRESS_0 = [
        'name' => 'stpi_additional_mailaddresses_mail_0',
        'type' => CustomFieldTypes::TEXT,
        'config' => [
            'type' => CustomFieldTypes::TEXT,
            'label' => [
                'de-DE' => 'E-Mail-Adresse 1',
                'en-GB' => 'E-mail address 1',
            ],
            'customFieldPosition' => 10,
        ],
    ];

    final public const MAILADDRESS_0_PAYMENT_STATUS = [
        'name' => 'stpi_additional_mailaddresses_mail_0_payment_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 1 Zahlungsstatus',
                'en-GB' => 'E-Mail 1 payment status',
            ],
            'customFieldPosition' => 11,
        ],
    ];

    final public const MAILADDRESS_0_ORDER_STATUS = [
        'name' => 'stpi_additional_mailaddresses_mail_0_order_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 1 Bestellstatus',
                'en-GB' => 'E-Mail 1 order status',
            ],
            'customFieldPosition' => 12,
        ],
    ];

    final public const MAILADDRESS_0_DELIVERY = [
        'name' => 'stpi_additional_mailaddresses_mail_0_delivery_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 1 Lieferstatus',
                'en-GB' => 'E-Mail 1 delivery status',
            ],
            'customFieldPosition' => 13,
        ],
    ];



    final public const MAILADDRESS_1 = [
        'name' => 'stpi_additional_mailaddresses_mail_1',
        'type' => CustomFieldTypes::TEXT,
        'config' => [
            'type' => CustomFieldTypes::TEXT,
            'label' => [
                'de-DE' => 'E-Mail-Adresse 2',
                'en-GB' => 'E-mail address 2',
            ],
            'customFieldPosition' => 20,
        ],
    ];

    final public const MAILADDRESS_1_PAYMENT_STATUS = [
        'name' => 'stpi_additional_mailaddresses_mail_1_payment_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 2 Zahlungsstatus',
                'en-GB' => 'E-Mail 2 payment status',
            ],
            'customFieldPosition' => 21,
        ],
    ];

    final public const MAILADDRESS_1_ORDER_STATUS = [
        'name' => 'stpi_additional_mailaddresses_mail_1_order_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 2 Bestellstatus',
                'en-GB' => 'E-Mail 2 order status',
            ],
            'customFieldPosition' => 22,
        ],
    ];

    final public const MAILADDRESS_1_DELIVERY = [
        'name' => 'stpi_additional_mailaddresses_mail_1_delivery_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 2 Lieferstatus',
                'en-GB' => 'E-Mail 2 delivery status',
            ],
            'customFieldPosition' => 23,
        ],
    ];


    final public const MAILADDRESS_2 = [
        'name' => 'stpi_additional_mailaddresses_mail_2',
        'type' => CustomFieldTypes::TEXT,
        'config' => [
            'type' => CustomFieldTypes::TEXT,
            'label' => [
                'de-DE' => 'E-Mail-Adresse 3',
                'en-GB' => 'E-mail address 3',
            ],
            'customFieldPosition' => 30,
        ],
    ];

    final public const MAILADDRESS_2_PAYMENT_STATUS = [
        'name' => 'stpi_additional_mailaddresses_mail_2_payment_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 3 Zahlungsstatus',
                'en-GB' => 'E-Mail 3 payment status',
            ],
            'customFieldPosition' => 31,
        ],
    ];

    final public const MAILADDRESS_2_ORDER_STATUS = [
        'name' => 'stpi_additional_mailaddresses_mail_2_order_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 3 Bestellstatus',
                'en-GB' => 'E-Mail 3 order status',
            ],
            'customFieldPosition' => 32,
        ],
    ];

    final public const MAILADDRESS_2_DELIVERY = [
        'name' => 'stpi_additional_mailaddresses_mail_2_delivery_status',
        'type' => CustomFieldTypes::BOOL,
        'config' => [
            'type' => CustomFieldTypes::CHECKBOX,
            'customFieldType' => CustomFieldTypes::CHECKBOX,
            'componentName' => 'sw-field',
            'label' => [
                'de-DE' => 'E-Mail 3 Lieferstatus',
                'en-GB' => 'E-Mail 3 delivery status',
            ],
            'customFieldPosition' => 33,
        ],
    ];

}
