class SurfeyElement extends HTMLElement {
    connectedCallback() {
        this.element = document.getElementById((this.getAttribute('recordFieldId') || ''));

        if (!this.element) {
            return;
        }

        console.log(this.element);
    }
}

window.customElements.define('typo3-formengine-element-surfey', SurfeyElement);
