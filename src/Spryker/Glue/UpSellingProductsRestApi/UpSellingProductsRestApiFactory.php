<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\UpSellingProductsRestApi;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\UpSellingProductsRestApi\Dependency\Client\UpSellingProductsRestApiToCartsRestApiClientInterface;
use Spryker\Glue\UpSellingProductsRestApi\Dependency\Client\UpSellingProductsRestApiToProductRelationStorageClientInterface;
use Spryker\Glue\UpSellingProductsRestApi\Dependency\Client\UpSellingProductsRestApiToProductStorageClientInterface;
use Spryker\Glue\UpSellingProductsRestApi\Dependency\RestApiResource\UpSellingProductsRestApiToProductsRestApiResourceInterface;
use Spryker\Glue\UpSellingProductsRestApi\Processor\Quote\QuoteReader;
use Spryker\Glue\UpSellingProductsRestApi\Processor\Quote\QuoteReaderInterface;
use Spryker\Glue\UpSellingProductsRestApi\Processor\RestResponseBuilder\UpSellingProductRestResponseBuilder;
use Spryker\Glue\UpSellingProductsRestApi\Processor\RestResponseBuilder\UpSellingProductRestResponseBuilderInterface;
use Spryker\Glue\UpSellingProductsRestApi\Processor\UpSellingProduct\UpSellingProductReader;
use Spryker\Glue\UpSellingProductsRestApi\Processor\UpSellingProduct\UpSellingProductReaderInterface;

class UpSellingProductsRestApiFactory extends AbstractFactory
{
    public function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader($this->getCartsRestApiClient());
    }

    public function createUpSellingProductReader(): UpSellingProductReaderInterface
    {
        return new UpSellingProductReader(
            $this->createQuoteReader(),
            $this->getProductRelationStorageClient(),
            $this->createUpSellingProductRestResponseBuilder(),
        );
    }

    public function createUpSellingProductRestResponseBuilder(): UpSellingProductRestResponseBuilderInterface
    {
        return new UpSellingProductRestResponseBuilder(
            $this->getProductsRestApiResource(),
            $this->getResourceBuilder(),
        );
    }

    public function getProductRelationStorageClient(): UpSellingProductsRestApiToProductRelationStorageClientInterface
    {
        return $this->getProvidedDependency(UpSellingProductsRestApiDependencyProvider::CLIENT_PRODUCT_RELATION_STORAGE);
    }

    public function getProductStorageClient(): UpSellingProductsRestApiToProductStorageClientInterface
    {
        return $this->getProvidedDependency(UpSellingProductsRestApiDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }

    public function getCartsRestApiClient(): UpSellingProductsRestApiToCartsRestApiClientInterface
    {
        return $this->getProvidedDependency(UpSellingProductsRestApiDependencyProvider::CLIENT_CARTS_REST_API);
    }

    public function getProductsRestApiResource(): UpSellingProductsRestApiToProductsRestApiResourceInterface
    {
        return $this->getProvidedDependency(UpSellingProductsRestApiDependencyProvider::RESOURCE_PRODUCTS_REST_API);
    }
}
