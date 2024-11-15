describe('template spec', () => {
  it('cy.request() - make an XHR request', () => {
    // https://on.cypress.io/request
    cy.request('https://izhgvozd.ru/')
      .should((response) => {
        expect(response.status).to.eq(200)
        // the server sometimes gets an extra comment posted from another machine
        // which gets returned as 1 extra object
        expect(response).to.have.property('headers')
        expect(response).to.have.property('duration')
      })
  })
  
  it('logo', () => {
      cy.visit('https://izhgvozd.ru');
      cy.get('#logo-main').should('be.visible'); // замените селектор на актуальный
  });

  it ("searchbar", () => {
    cy.visit('https://izhgvozd.ru/')
    cy.get("#search").type("Гвозди")
    cy.get(".btn.btn-default.search").click()
  })

  it ("allservises", () => {
    cy.visit('https://izhgvozd.ru/')
    cy.get(".catalog-all").click()
  })


  it('footer', () => {
    cy.visit('https://izhgvozd.ru');
    cy.get('.row').should('be.visible')
  });

  it('navbar"', () => {
    cy.visit('https://izhgvozd.ru');
    cy.get(".navbar-nav").eq(1).click()
  });
  it('socialmedialink"', () => {
      cy.visit('https://izhgvozd.ru');
      cy.get("img[src='assets/content/images/vk-logo.png']").click({ multiple: true })
    });
})