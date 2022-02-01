export default class Block {
  constructor(el, destroyLast) {
    this.el = el;
    this.destroyLast = destroyLast;

    this.bindMethods()
    this.getElems()
    this.events()
  }

  onEnterCompleted() {}

  bindMethods() {}

  getElems() {}

  events() {}

  destroy() {}

  resize() {}

  scroll() {}

  update() {}
}
