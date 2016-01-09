Feature: Magento Fixtures

    Scenario: Build fixtures
    Given I setup a product fixture
      And I setup a customer fixture
      And I setup a customer fixture with address
      And I setup a product fixture with media
      And I setup a category fixture
      And I setup a configurable product fixture
      And I setup a bundle product fixture
      And I setup a guest sales order fixture
      And I setup a register sales order fixture
      And I setup a customer sales order fixture
      And I setup an api user fixture
      And I setup a grouped product fixture
