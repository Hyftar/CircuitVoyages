describe('Login tests', () => {
  it('Creates an account', () => {
    cy.visit('/')
    cy.get('#menu-hamburger').click()
    cy.get('#nav-login-link').click()
    cy.get('#login-register-link').click()
    cy.get('#first-name').type('John')
    cy.get('#last-name').type('Doe')
    cy.get('#email').type('john_doe@example.com')
    cy.get('#date-of-birth').type('1992-02-17')
    cy.get('#phone').type('5148298543')
    cy.get('#country').type('Canada')
    cy.get('#region').type('Québec')
    cy.get('#city').type('Montréal')
    cy.get('#address-line-1').type('4200 Wellington')
    cy.get('#address-line-2').type('apartment 2')
    cy.get('#postal-code').type('H4G 2B4')
    cy.get('#password').type('j0HnnyDoe$')
    cy.get('#password-confirmation').type('j0HnnyDoe$')
    cy.get('#register-submit').click()
  })
  it.skip('Logs in', () => {
    cy.visit('/')
    cy.get('#nav-login-link').click()
    cy.get('#input-email').type('john_doe@example.com')
    cy.get('#input-password').type('Doe$123456{enter}')
    cy.get('#nav-login-link').should('not.be.visible')
  })
})
