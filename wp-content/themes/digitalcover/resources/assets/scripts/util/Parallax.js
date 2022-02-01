import gsap from 'gsap'

import { debounce } from 'throttle-debounce'
import Inertia from './Inertia'

export default class Parallax {

  /**
    * Initializes the parallax on this page
    *
    * @param {String} selector - (Default: `.parallax-el`) The selector to get your parallaxed elems with
    * @param {Node} parent - (Default: `document`) The parent node in which retreive the parallaxed elems
    * @param {Number} disableUnder - (Default: `0`) If given, the parallax will deactivate itself when the window width is under `disableUnder` value
		* @param {Boolean} willChange - (Default: `false`) If true, enables the `will-change` CSS property for performance
    */
  constructor({ selector = '.parallax-el', parent = document, disableUnder = 0, willChange = false } = {}) {
    this.scroll = this.scroll.bind(this)
    this.scrollEnded = this.scrollEnded.bind(this)
    this.scrollEnded = debounce(150, this.scrollEnded)
    this.render = this.render.bind(this)

    this.selector = selector
    this.parent = parent
    this.disableUnder = disableUnder
    this.willChange = willChange

    this.setup()
    this.init()
  }

	setup() {
		this.scrollY = window.scrollY || window.pageYOffset
		this.lastScrollY = 0
		
		this.scrollStrength = 0
		this.maxScrollAmplitude = 250
		this.skew = {
			min: -7,
			max: 7
		}
		this.skew.range = this.skew.max - this.skew.min

		this.elems = []
		this.class = this.selector.replace('.', '')
		this.class = this.class.replace('#', '')
	}

  init(parent = this.parent) {
    if (this.active) return

    this.active = true
    this.parent = parent

    this.createElements()

		if (!this.elems.length) return

    if (window.innerWidth <= this.disableUnder) return

    window.addEventListener('scroll', this.scroll)
    if (this.willChange) window.addEventListener('scroll', this.scrollEnded)

    this.resize()
    this.animateParralax(true)
  }

	createElements() {
		const elements = this.parent.querySelectorAll(this.selector)

		if (elements.length === 0) return

		for (let i = 0; i < elements.length; i++) {
			const el = elements[i]
			const speed = el.dataset.parallaxSpeed ? Number(el.dataset.parallaxSpeed) : (Math.random() * (0.25 - 0.05) + 0.05).toFixed(3)
			const drag = el.dataset.parallaxDrag ? Number(el.dataset.parallaxDrag) : 0.3
			const acceleration = el.dataset.parallaxAcceleration ? Number(el.dataset.parallaxAcceleration) : 0.17
			const inertia = new Inertia({
				min: -window.innerHeight * Math.abs(speed),
				max: window.innerHeight * Math.abs(speed),
				acceleration,
				drag
			})
			let horizontalSkewInertia = null

			if (el.dataset.parallaxHorizontal) {
				horizontalSkewInertia = new Inertia({
					min: this.skew.min,
					max: this.skew.max
				})
			}

			this.elems.push({
				el,
				parent: el.parentElement.classList.contains(this.class) ? el.parentElement.parentElement : el.parentElement,
				inertia,
				speed,
				horizontal: el.dataset.parallaxHorizontal || false,
				horizontalSkewInertia,
				active: false
			})
		}
	}

	setParallaxPos(force) {
		for (let i = 0; i < this.elems.length; i++) {
			const el = this.elems[i]
			const parentTopOffset = el.horizontal ? el.el.getBoundingClientRect().top + this.scrollY : el.parent.getBoundingClientRect().top + this.scrollY
			const height = el.el.offsetHeight

			el.posY = parentTopOffset + (height - window.innerHeight) / 2

			if (!el.minActiveScrollPos || force) el.minActiveScrollPos = el.posY - window.innerHeight
			if (!el.maxActiveScrollPos || force) el.maxActiveScrollPos = el.horizontal ? el.posY + window.innerHeight * 2 : el.posY + window.innerHeight
			if (!el.distanceBetweenMinAndMax || force) el.distanceBetweenMinAndMax = el.maxActiveScrollPos - el.minActiveScrollPos
		}
	}

  initStartPositions() {
    for (let i = 0; i < this.elems.length; i++) {
      const el = this.elems[i]
      const posY = el.inertia.setValue(el.inertia.maxV)

      gsap.set(el.el, {
        y: posY,
        force3D: true
      })
    }
  }

  render() {
    if (this.active) this.animateParralax()
  }

  animateParralax(force) {
		for (let i = 0; i < this.elems.length; i++) {
			const el = this.elems[i]

			if (el.active || force) {
				const value = el.posY - this.scrollY
				const normalizedValue = el.inertia.maxV * (value / (el.distanceBetweenMinAndMax / 2))
				const posY = force ? el.inertia.setValue(normalizedValue) : el.inertia.update(normalizedValue)
				let params = { y: el.speed < 0 ? -posY : posY }

				if (el.horizontal) {
					let skew = force ? el.horizontalSkewInertia.setValue(this.scrollStrength) : el.horizontalSkewInertia.update(this.scrollStrength)

					if (el.speed < 0) skew *= -1

					params = {
						x: el.speed < 0 ? -posY : posY,
						skewX: skew + 'deg'
					}
				}

				params.force3D = true

				gsap.set(el.el, params)
			}
		}
  }

  scroll() {
		this.scrollY = window.scrollY || window.pageYOffset

		// Strength normalized between 0 and 1
		const scrollStrength = (this.lastScrollY - this.scrollY) / this.maxScrollAmplitude

		// Strength normalized between `this.minSkew` and `this.maxSkew`
		// this is NOT bound checked
		this.scrollStrength = scrollStrength * this.skewRange + this.minSkew + Math.abs(this.skewRange / 2)

		this.lastScrollY = this.scrollY

		for (let i = 0; i < this.elems.length; i++) {
			const el = this.elems[i]

			el.active = this.scrollY > el.minActiveScrollPos && this.scrollY < el.maxActiveScrollPos

			if (this.willChange) el.el.style.willChange = 'transform'
		}
  }

	scrollEnded() {
		if (!this.willChange) return

		this.scrollStrength = 0

		for (let i = 0; i < this.elems.length; i++) {
			this.elems[i].el.style.willChange = 'auto'
		}
	}

  resize() {
    this.setParallaxPos()
    this.scroll()

    if (window.innerWidth <= this.disableUnder) this.destroy()
    else this.init()
  }

	reset(parent) {
		this.destroy()
		this.init(parent)
	}

	destroy() {
		if (!this.active) return

		window.removeEventListener('scroll', this.scroll)
		if (this.willChange) window.removeEventListener('scroll', this.scrollEnded)

		for (let i = 0; i < this.elems.length; i++) {
			const el = this.elems[i]
			const pos = el.inertia.setValue(0)
			let params = { y: pos }

			if (el.horizontal) {
				params = {
					x: pos,
					skewX: '0deg'
				}

				el.horizontalSkewInertia.setValue(0)
			}

			params.force3D = true

			gsap.set(el.el, params)
		}

		this.scrollY = 0
		this.lastScrollY = 0
		this.scrollStrength = 0
		this.elems = []
		this.active = false
	}
}
