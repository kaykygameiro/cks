class Slide {
    constructor(slideSelector, wrapperSelector) {
        this.slide = document.querySelector(slideSelector);
        this.wrapper = document.querySelector(wrapperSelector);
        this.dist = { finalPosition: 0, startX: 0, movement: 0 };
        this.activeClass = "active";
        this.changeEvent = new Event("changeEvent");
    }

    transition(active) {
        this.slide.style.transition = active ? "transform .3s" : "";
    }

    moveSlide(position) {
        this.dist.movePosition = position;
        this.slide.style.transform = `translate3d(${position}px, 0, 0)`;
    }

    updatePosition(clientX) {
        this.dist.movement = 1.6 * (this.dist.startX - clientX);
        return this.dist.finalPosition - this.dist.movement;
    }

    onStart(event) {
        let moveType;
        if (event.type === "mousedown") {
            event.preventDefault();
            this.dist.startX = event.clientX;
            moveType = "mousemove";
        } else {
            this.dist.startX = event.changedTouches[0].clientX;
            moveType = "touchmove";
        }
        this.wrapper.addEventListener(moveType, this.onMove);
        this.transition(false);
    }

    onMove(event) {
        const pointerX = event.type === "mousemove" ? event.clientX : event.changedTouches[0].clientX;
        const finalPosition = this.updatePosition(pointerX);
        this.moveSlide(finalPosition);
    }

    onEnd(event) {
        const moveType = event.type === "mouseup" ? "mousemove" : "touchmove";
        this.wrapper.removeEventListener(moveType, this.onMove);
        this.dist.finalPosition = this.dist.movePosition;
        this.transition(true);
        this.changeSlideOnEnd();
    }

    changeSlideOnEnd() {
        if (this.dist.movement > 120 && this.index.next !== undefined) {
            this.activeNextSlide();
        } else if (this.dist.movement < -120 && this.index.prev !== undefined) {
            this.activePrevSlide();
        } else {
            this.changeSlide(this.index.active);
        }
    }

    addSlideEvents() {
        this.wrapper.addEventListener("mousedown", this.onStart);
        this.wrapper.addEventListener("touchstart", this.onStart);
        this.wrapper.addEventListener("mouseup", this.onEnd);
        this.wrapper.addEventListener("touchend", this.onEnd);
    }

    slidePosition(slide) {
        const margin = (this.wrapper.offsetWidth - slide.offsetWidth) / 2;
        return -(slide.offsetLeft - margin);
    }

    slidesConfig() {
        this.slideArray = [...this.slide.children].map(element => ({
            position: this.slidePosition(element),
            element
        }));
    }

    slidesIndexNav(index) {
        const last = this.slideArray.length - 1;
        this.index = {
            prev: index > 0 ? index - 1 : undefined,
            active: index,
            next: index < last ? index + 1 : undefined
        };
    }

    changeSlide(index) {
        const slide = this.slideArray[index];
        this.moveSlide(slide.position);
        this.slidesIndexNav(index);
        this.dist.finalPosition = slide.position;
        this.changeActiveClass();
        this.wrapper.dispatchEvent(this.changeEvent);
    }

    changeActiveClass() {
        this.slideArray.forEach(item => item.element.classList.remove(this.activeClass));
        this.slideArray[this.index.active].element.classList.add(this.activeClass);
    }

    activePrevSlide() {
        if (this.index.prev !== undefined) this.changeSlide(this.index.prev);
    }

    activeNextSlide() {
        if (this.index.next !== undefined) this.changeSlide(this.index.next);
    }

    onResize() {
        setTimeout(() => {
            this.slidesConfig();
            this.changeSlide(this.index.active);
        }, 1000);
    }

    addResizeEvent() {
        window.addEventListener("resize", this.onResize);
    }

    bindEvents() {
        this.onStart = this.onStart.bind(this);
        this.onMove = this.onMove.bind(this);
        this.onEnd = this.onEnd.bind(this);
        this.activePrevSlide = this.activePrevSlide.bind(this);
        this.activeNextSlide = this.activeNextSlide.bind(this);
        this.onResize = this.debounce(this.onResize.bind(this), 200);
    }

    debounce(func, wait) {
        let timeout;
        return (...args) => {
            if (timeout) clearTimeout(timeout);
            timeout = setTimeout(() => {
                func(...args);
                timeout = null;
            }, wait);
        };
    }

    init() {
        if (this.slide) {
            this.bindEvents();
            this.transition(true);
            this.addSlideEvents();
            this.slidesConfig();
            this.addResizeEvent();
            this.changeSlide(0);
        }
        return this;
    }
}

// Export for global usage
window.Slide = Slide;