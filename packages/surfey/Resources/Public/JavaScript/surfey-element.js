import Modal from '@typo3/backend/modal.js';
import {Types} from '@typo3/backend/modal.js';
import AjaxRequest from '@typo3/core/ajax/ajax-request.js';
import Notification from '@typo3/backend/notification.js';
import * as FormEditor from '@typo3/form/backend/form-editor.js';

class SurfeyElement extends HTMLElement {
    connectedCallback() {
        this.addEventListener('click', (e) => {
            e.preventDefault();
            this.openModal();
        });
    }

    openModal() {
        Modal.advanced({
            type: Types.iframe,
            size: Modal.sizes.large,
            content: this.getAttribute('modal-uri'),
            buttons: [],
            staticBackdrop: true,
            callback: async (modal) => {
                const iframe = modal.querySelector('.t3js-modal-body iframe');
                if (iframe) {
                    iframe.addEventListener('load', () => {
                        const iframeDocument = iframe.contentDocument;
                        iframeDocument.querySelector('a[data-identifier="closeButton"]').addEventListener('click', (e) => {
                            e.preventDefault();
                            top.TYPO3.Modal.dismiss();
                        });
                    });
                }
            }
        });
    }
}

window.customElements.define('typo3-formengine-element-surfey', SurfeyElement);
