<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\UpSellingProductsRestApi\Api\Storefront\Exception;

use Spryker\ApiPlatform\Exception\GlueApiException;
use Spryker\Glue\UpSellingProductsRestApi\UpSellingProductsRestApiConfig;
use Symfony\Component\HttpFoundation\Response;

class UpSellingProductsExceptionFactory
{
    public function createCartNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_FOUND,
            UpSellingProductsRestApiConfig::RESPONSE_CODE_CART_NOT_FOUND,
            UpSellingProductsRestApiConfig::EXCEPTION_MESSAGE_CART_WITH_ID_NOT_FOUND,
        );
    }

    public function createCartIdMissingException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            UpSellingProductsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING,
            UpSellingProductsRestApiConfig::EXCEPTION_MESSAGE_CART_ID_MISSING,
        );
    }

    public function createAnonymousCustomerUniqueIdEmptyException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            UpSellingProductsRestApiConfig::RESPONSE_CODE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY,
            UpSellingProductsRestApiConfig::EXCEPTION_MESSAGE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY,
        );
    }
}
