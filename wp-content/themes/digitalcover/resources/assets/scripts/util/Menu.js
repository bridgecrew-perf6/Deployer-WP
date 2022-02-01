export default class Menu {
  constructor() {
    this.menuOpen = false
    this.isAnimating = false

    this.bindMethods()
    this.getElems()
    this.addEvents()
  }

  bindMethods() {
    this.toggle = this.toggle.bind(this)
  }

  getElems() {}

  addEvents() {
    this.toggler && this.toggler.addEventListener('click', this.toggle)
  }

  /**
  * Toggle Menu to open or close it
  * @returns {any} null
  */
  toggle() {
    if (this.isAnimating) return

    if (this.menuOpen) this.close()
    else this.open()
  }

  /**
  * Open Menu
  * @returns {Promise} return Promise when open animation end
  */
  open() {
    return new Promise((resolve) => {
      this.menuOpen = true
      resolve()
    })
  }

  /**
  * Close Menu
  * @returns {Promise} return Promise when close animation end
  */
  close() {
    return new Promise((resolve) => {
      this.menuOpen = false
      resolve()
    })
  }

  resize() {}

  scroll() {}
}
