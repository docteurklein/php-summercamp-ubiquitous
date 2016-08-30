Feature: A basket

    In order to ease buying of products
    As a visitor
    I can add products in my basket

    Scenario: Adding products to my basket
        Given a product named "White Marker" and priced €5 was added to the catalog
        When I add the "White Marker" product from the catalog to the picked up basket
        Then the overall basket price should be €9

    Scenario: Failing to add out-of-stock products
        Given an out-of-stock product
        When I try to add it to my cart
        Then the basket shouldn't be modified

    Scenario: Getting the delivery cost for a single product
        Given a product named "White Marker" and priced €5 was added to the catalog
        When I add the "White Marker" product from the catalog to the picked up basket
        Then the overall basket price should be €9
