<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\UpSellingProductsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class UpSellingProductsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @var string
     */
    public const RELATIONSHIP_NAME_UP_SELLING_PRODUCTS = 'up-selling-products';

    /**
     * @api
     *
     * @var string
     */
    public const CONTROLLER_CART_UP_SELLING_PRODUCTS = 'cart-up-selling-products';

    /**
     * @api
     *
     * @var string
     */
    public const CONTROLLER_GUEST_CART_UP_SELLING_PRODUCTS = 'guest-cart-up-selling-products';

    /**
     * @api
     *
     * @var string
     */
    public const ACTION_UP_SELLING_PRODUCTS_GET = 'get';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESPONSE_CODE_CART_NOT_FOUND
     */
    public const string RESPONSE_CODE_CART_NOT_FOUND = '101';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::EXCEPTION_MESSAGE_CART_WITH_ID_NOT_FOUND
     */
    public const string EXCEPTION_MESSAGE_CART_WITH_ID_NOT_FOUND = 'Cart with given uuid not found.';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING
     */
    public const string RESPONSE_CODE_CART_ID_MISSING = '104';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::EXCEPTION_MESSAGE_CART_ID_MISSING
     */
    public const string EXCEPTION_MESSAGE_CART_ID_MISSING = 'Cart uuid is missing.';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESPONSE_CODE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY
     */
    public const string RESPONSE_CODE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY = '109';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::EXCEPTION_MESSAGE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY
     */
    public const string EXCEPTION_MESSAGE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY = 'Anonymous customer unique id is empty.';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID
     */
    public const string HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID = 'X-Anonymous-Customer-Unique-Id';
}
