describe('Тестирование логина', () => {
  it('Заполнение формы логина и авторизация', () => {
      cy.visit('https://www.saucedemo.com');

      cy.get('input[name="user-name"]').type('standard_user');
      cy.get('input[name="password"]').type('secret_sauce');

      cy.get('input[type="submit"]').click();

      cy.url().should('include', '/inventory.html');
      cy.get('.title').should('contain', 'Products');
  });
});

describe('Сортировка товаров', () => {
  beforeEach(() => {
      cy.visit('https://www.saucedemo.com');
      cy.get('input[name="user-name"]').type('standard_user');
      cy.get('input[name="password"]').type('secret_sauce');
      cy.get('input[type="submit"]').click();
  });

  it('Сортировка по цене (по возрастанию)', () => {

      cy.get('.product_sort_container').select('Price (low to high)');

      let prices = [];
      cy.get('.inventory_item_price').each(($el) => {
          prices.push(parseFloat($el.text().replace('$', '')));
      }).then(() => {
          const sortedPrices = [...prices].sort((a, b) => a - b);
          expect(prices).to.deep.equal(sortedPrices);
      });
  });

  it('Сортировка по цене (по убыванию)', () => {

      cy.get('.product_sort_container').select('Price (high to low)');
      let prices = [];
      cy.get('.inventory_item_price').each(($el) => {
          prices.push(parseFloat($el.text().replace('$', '')));
      }).then(() => {
          const sortedPrices = [...prices].sort((a, b) => b - a);
          expect(prices).to.deep.equal(sortedPrices);
      });
  });
});

describe('Добавление товаров в корзину', () => {
  beforeEach(() => {
      cy.visit('https://www.saucedemo.com');
      cy.get('input[name="user-name"]').type('standard_user');
      cy.get('input[name="password"]').type('secret_sauce');
      cy.get('input[type="submit"]').click();
  });

  it('Добавление двух товаров в корзину и создание заказа', () => {

      cy.get('.inventory_item').first().find('.btn_inventory').click();

      cy.get('.inventory_item').eq(1).find('.btn_inventory').click();

      cy.get('.shopping_cart_link').click();

      cy.get('.cart_item').should('have.length', 2);

      cy.get('.checkout_button').click();
      
      cy.get('#first-name').type('John');
      cy.get('#last-name').type('Doe');
      cy.get('#postal-code').type('12345');

      cy.get('.btn_primary.cart_button').click();

      cy.url().should('include', '/checkout-complete.html');
      cy.get('.complete-header').should('contain', 'Thank you for your order!');
  });
});