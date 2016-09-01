# [emergent design](http://slides.com/florianklein/websc-2016#/)


    git clone git@github.com:docteurklein/php-summercamp-ubiquitous.git
    composer install
    docker-compose up -d

> __Note__: If you already cloned it before:

    git fetch origin master
    git reset --hard origin/master

## Exercise 1

    git checkout -b exercise/1 c9bcb9c634a7b983bf57c107d610288084c376cf

> __Note__: You can optionally `git checkout master` and `rm -rf src/App/Domain spec/App/Domain features/Context/Domain`.

1. Implement the core logic of [Scenario 1](https://github.com/docteurklein/php-summercamp-ubiquitous/blob/master/features/cart.feature#L7):

```gherkin
Scenario: Adding products to my basket
    Given a product named "White Marker" and priced €5 was added to the catalog
    When I add the "White Marker" product from the catalog to the picked up basket
    Then the overall basket price should be €9
```

2. Use behat and phpspec to discover the ideal public API of your domain.

3. Repeat the red/green loop until every step passes.

4. Use `behat -s ui` to test the same scenario against the web UI.

5. Repeat step 3.

## Solution 1

A first working implementation resides in the master branch.


## Exercise 2

    git checkout -b exercise/2 master

1. Implement the core logic of [Scenario 2](https://github.com/docteurklein/php-summercamp-ubiquitous/blob/master/features/cart.feature#L12):

```gherkin
Scenario: Failing to add out-of-stock products
    Given an out-of-stock product
    When I try to add it to my cart
    Then the basket shouldn't be modified
```

