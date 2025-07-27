[![Master](https://github.com/adrianturnes/mytheresa/actions/workflows/master.yml/badge.svg?branch=master)](https://github.com/adrianturnes/mytheresa/actions/workflows/master.yml)

# PROJECT DESCRIPTION
We want you to implement a REST API endpoint that given a list of products, applies some discounts to them and can be filtered.
You are free to choose whatever language and tools you are most comfortable with. Please add instructions on how to run it and publish it in Github.

# EXPECTATIONS
* Code structure/architecture must fit this use case, as simple or as complex needed to complete what is asked for.
* Test are a must. Code must be testable without requiring networking or the filesystem. Tests should be runnable with 1 command.
* The project must be runnable with 1 simple command from any machine.
* Explanations on decisions taken

# GIVEN THAT
* Products in the boots category have a 30% discount.
* The product with sku = 000003 has a 15% discount.
* When multiple discounts collide, the bigger discount must be applied.

# Envinronment
* PHP 8.4
* Symfony 7.3
* Docker

# Installation
There is a prebuild docker image in order to accelerate the installation process.
To install the project, you can use the following command:
```
make install
```

# Explanation
The solution is a symfony application that is using Doctrine as ORM to manage the products.
The products are stored in a MySQL database and for the tests I'm using PHPUNIT with doctrine test bundle.

* The project is based on a `DDD` approach using `CQS` principle.
* Tests are build following the same structure as the application having different layers.
* Promotions are stored in a database table and calculated when they are read via a `PromotionResolver`. This is done to avoid having to update all the products when a promotion is added or removed.
* Promotions are done using the doctrine inheritance mapping, so we have the domain logic in each type of promotion and we can add new promotions in the future without changing the previous code. We only need to add a new column and create a new promotion class extending the `Promotion` class.


# Tests execution
To run the tests, application must be running and you can use the following command: `make test`
```
PHPUnit 12.2.7 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.5
Configuration: /var/www/phpunit.dist.xml

............................                                      28 / 28 (100%)

Time: 00:01.001, Memory: 46.50 MB

OK (28 tests, 69 assertions)
```

Also added a github workflow to run the tests automatically on every push to master and added a badge to README.

# Test coverage
To generate the test coverage report, you can use the following command:
```
make coverage
```
Then you will find the report in the `coverage` folder.

**Note:** Current coverage is 100%

# Structure
```scala
src // Application source code
|-- Shared // Shared code between different applications
|   |-- Application
|   |   `-- Dto
|   |       |-- PaginatorTransformer.php
|   |       `-- Transformer.php
|   |-- Domain
|   |   |-- Exception
|   |   |   |-- ConflictException.php
|   |   |   `-- NotFoundException.php
|   |   `-- ValueObject
|   |       |-- Paginate.php
|   |       `-- PaginationResult.php
|   |-- Infrastructure
|   |   `-- Middleware
|   |       `-- ErrorMiddleware.php
|   `-- UserInterface
|       `-- Http
|           |-- Controller.php
|           `-- ExceptionHandler.php
`-- Store // Bounded context: Products and Promotions
    |-- Application
    |   |-- Command // Commands to create products
    |   |   |-- CreateProductCommand.php
    |   |   |-- CreateProductListCommand.php
    |   |   `-- Handler
    |   |       |-- CreateProductCommandHandler.php
    |   |       `-- CreateProductListCommandHandler.php
    |   |-- Dto // Data Transfer Objects for transforming data for Queries
    |   |   |-- ProductListTransformer.php
    |   |   `-- ProductTransformer.php
    |   `-- Query // Queries to get products
    |       |-- GetProductListQuery.php
    |       |-- GetProductQuery.php
    |       `-- Handler
    |           |-- GetProductListQueryHandler.php
    |           `-- GetProductQueryHandler.php
    |-- Domain
    |   |-- Entity
    |   |   |-- Product
    |   |   |   |-- Price.php
    |   |   |   `-- Product.php
    |   |   `-- Promotion
    |   |       |-- CategoryPromotion.php
    |   |       |-- Promotion.php
    |   |       `-- SkuPromotion.php
    |   |-- Exception
    |   |   |-- ProductAlreadyExistsException.php
    |   |   `-- ProductNotFoundException.php
    |   |-- Repository // Repository Interfaces for products and promotions
    |   |   |-- ProductRepository.php
    |   |   `-- PromotionRepository.php
    |   `-- Service
    |       `-- PromotionResolver.php
    |-- Infrastructure
    |   `-- Persistence
    |       `-- Doctrine
    |           |-- DataFixtures
    |           |   |-- ProductFixtures.php
    |           |   `-- PromotionFixtures.php
    |           |-- Mapping
    |           |   |-- Product.Price.orm.xml
    |           |   |-- Product.Product.orm.xml
    |           |   |-- Promotion.CategoryPromotion.orm.xml
    |           |   |-- Promotion.Promotion.orm.xml
    |           |   `-- Promotion.SkuPromotion.orm.xml
    |           `-- Repository
    |               |-- DoctrineProductRepository.php
    |               `-- DoctrinePromotionRepository.php
    `-- UserInterface
        `-- Http
            `-- Controller
                |-- CreateProductListController.php
                |-- GetProductController.php
                `-- GetProductListController.php
                
tests // Test cases for the application
|-- Acceptance
|   `-- Store
|       `-- Application
|           |-- Command
|           |   `-- CreateProductListTest.php
|           `-- Query
|               |-- GetProductListTest.php
|               `-- GetProductTest.php
|-- Integration
|   `-- Store
|       `-- Application
|           `-- Command
|               `-- CreateProductListCommandHandlerTest.php
|-- Unit // Unit tests for the application replicating the structure of the application
|   |-- Shared
|   |   `-- UserInterface
|   |       `-- Http
|   |           `-- ExceptionHandlerTest.php
|   `-- Store
|       |-- Application
|       |   |-- Command
|       |   |   `-- Handler
|       |   |       |-- CreateProductCommandHandlerTest.php
|       |   |       `-- CreateProductListCommandHandlerTest.php
|       |   |-- Dto
|       |   |   |-- ProductListTransformerTest.php
|       |   |   `-- ProductTransformerTest.php
|       |   `-- Query
|       |       `-- Handler
|       |           |-- GetProductListQueryHandlerTest.php
|       |           `-- GetProductQueryHandlerTest.php
|       `-- Domain
|           |-- Entity
|           |   |-- Product
|           |   |   |-- PriceTest.php
|           |   |   `-- ProductTest.php
|           |   `-- Promotion
|           |       |-- CategoryPromotionTest.php
|           |       `-- SkuPromotionTest.php
|           |-- Exception
|           |   |-- ProductAlreadyExistsExceptionTest.php
|           |   `-- ProductNotFoundExceptionTest.php
|           `-- Service
|               `-- PromotionResolverTest.php
```

# Possible improvements
* Add an elasticsearch or algolia to fully separate the read and write models to improve the reading performance and change from a CQS to a CQRS.
* The endpoint to create products could be improved making the command asynchronous and using a message queue to handle the creation of products in the background. This will allow to have hundreds or thousands of products created without blocking the API response.
* Due to timing, all the events are missing, but they could be used to notify the system about the changes in the products, so that other systems can react to those changes.
* Migrate configs to bounded contexts, so that each bounded context has its own configuration.

# API Documentation
Application host: `http://localhost:8080`
### POST /products
Endpoint to create a list of products
```
Request body:
{
    "products": [
        {
            "sku": "000501",
            "name": "BV Lean leather ankle boots",
            "category": "boots",
            "price": 89000,
        },
        {
            "sku": "000502",
            "name": "BV Lean leather ankle boots",
            "category": "boots",
            "price": 99000
        }
    ]
}
```

### GET /product/{sku}
Endpoint to get a product by its SKU
#### Response body:
```
{
    "sku": "000002",
    "name": "BV Lean leather ankle boots",
    "category": "boots",
    "price": {
        "original": 99000,
        "final": 69300,
        "discount_percentage": "30%",
        "currency": "EUR"
    }
}
```

### GET /Products
This endpoint returns all products with their final price after applying the discounts when needed.

Query parameters:

|    Parameter     | Default  | Description                |
|:----------------:|:--------:| :-------------------------:|
|limit             | 5        | items per page             |
|       page       | 1        | page number                |
|     category     |          | product category           |
|  priceLessThan   |          | price before discounts     |

#### Response example:
```
GET /products?category=boots&priceLessThan=90000&page=1&limit=2
```
#### Response body:
```
{
    "total":2,
    "page":1,
    "total_pages":1,
    "limit":2,
    "items": [
        {
            "sku":"000001",
            "name":"BV Lean leather ankle boots",
            "category":"boots",
            "price": {
                "original":89000,
                "final":62300,
                "discount_percentage":"30%",
                "currency":"EUR"
            }
        },
        {
            "sku":"000003",
            "name":"Ashlington leather ankle boots",
            "category":"boots",
            "price": {
                "original":71000,
                "final":49700,
                "discount_percentage":"30%",
                "currency":"EUR"
            }
        }
    ]
}
```
