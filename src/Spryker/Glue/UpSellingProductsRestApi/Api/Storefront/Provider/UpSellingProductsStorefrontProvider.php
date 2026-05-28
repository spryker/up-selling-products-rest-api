<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\UpSellingProductsRestApi\Api\Storefront\Provider;

use ApiPlatform\Metadata\GetCollection;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\ApiPlatform\State\Provider\AbstractStorefrontProvider;
use Spryker\Client\CartsRestApi\CartsRestApiClientInterface;
use Spryker\Client\ProductRelationStorage\ProductRelationStorageClientInterface;
use Spryker\Glue\ProductsRestApi\Api\Storefront\Provider\AbstractProductsStorefrontProvider;
use Spryker\Glue\UpSellingProductsRestApi\Api\Storefront\Exception\UpSellingProductsExceptionFactory;
use Spryker\Glue\UpSellingProductsRestApi\UpSellingProductsRestApiConfig;

class UpSellingProductsStorefrontProvider extends AbstractStorefrontProvider
{
    protected const string KEY_CART_ID = 'cartId';

    protected const string KEY_GUEST_CART_ID = 'guestCartId';

    /**
     * @uses \Spryker\Shared\PersistentCart\PersistentCartConfig::PERSISTENT_CART_ANONYMOUS_PREFIX
     */
    protected const string ANONYMOUS_CUSTOMER_REFERENCE_PREFIX = 'anonymous:';

    public function __construct(
        protected CartsRestApiClientInterface $cartsRestApiClient,
        protected ProductRelationStorageClientInterface $productRelationStorageClient,
        protected AbstractProductsStorefrontProvider $abstractProductsProvider,
        protected UpSellingProductsExceptionFactory $exceptionFactory,
    ) {
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return array<\Generated\Api\Storefront\AbstractProductsStorefrontResource>
     */
    protected function provideCollection(): array
    {
        $quoteTransfer = $this->buildQuoteTransfer();
        $quoteResponseTransfer = $this->cartsRestApiClient->findQuoteByUuid($quoteTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createCartNotFoundException();
        }

        $abstractProductIds = $this->productRelationStorageClient->findUpSellingAbstractProductIds(
            $quoteResponseTransfer->getQuoteTransferOrFail(),
        );

        if ($abstractProductIds === []) {
            return [];
        }

        return (array)$this->abstractProductsProvider->provide(
            new GetCollection(),
            $this->uriVariables,
            array_merge($this->context, [AbstractProductsStorefrontProvider::CONTEXT_KEY_ABSTRACT_PRODUCT_IDS => $abstractProductIds]),
        );
    }

    protected function buildQuoteTransfer(): QuoteTransfer
    {
        if ($this->hasUriVariable(static::KEY_CART_ID)) {
            return $this->buildAuthenticatedQuoteTransfer();
        }

        return $this->buildGuestQuoteTransfer();
    }

    protected function buildAuthenticatedQuoteTransfer(): QuoteTransfer
    {
        $cartId = (string)$this->getUriVariable(static::KEY_CART_ID);

        if ($cartId === '') {
            throw $this->exceptionFactory->createCartIdMissingException();
        }

        $customerReference = $this->getCustomerReference();

        return (new QuoteTransfer())
            ->setUuid($cartId)
            ->setCustomerReference($customerReference)
            ->setCustomer(
                (new CustomerTransfer())
                    ->setCustomerReference($customerReference)
                    ->setIdCustomer($this->getCustomer()->getIdCustomer()),
            );
    }

    protected function buildGuestQuoteTransfer(): QuoteTransfer
    {
        if (!$this->hasUriVariable(static::KEY_GUEST_CART_ID)) {
            throw $this->exceptionFactory->createCartIdMissingException();
        }

        $guestCartId = (string)$this->getUriVariable(static::KEY_GUEST_CART_ID);

        if ($guestCartId === '') {
            throw $this->exceptionFactory->createCartIdMissingException();
        }

        $anonymousCustomerReference = $this->resolveAnonymousCustomerReference();

        return (new QuoteTransfer())
            ->setUuid($guestCartId)
            ->setCustomerReference($anonymousCustomerReference)
            ->setCustomer((new CustomerTransfer())->setCustomerReference($anonymousCustomerReference));
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function resolveAnonymousCustomerReference(): string
    {
        $anonymousCustomerUniqueId = $this->getRequest()->headers->get(
            UpSellingProductsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
        );

        if ($anonymousCustomerUniqueId === null || $anonymousCustomerUniqueId === '') {
            throw $this->exceptionFactory->createAnonymousCustomerUniqueIdEmptyException();
        }

        return static::ANONYMOUS_CUSTOMER_REFERENCE_PREFIX . $anonymousCustomerUniqueId;
    }
}
