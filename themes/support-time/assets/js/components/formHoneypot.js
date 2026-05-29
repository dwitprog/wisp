export const FORM_HONEYPOT_SELECTOR = '.form-honeypot input[name="privacy_ack"]';

/**
 * @param {HTMLFormElement|null|undefined} formElement
 * @returns {boolean}
 */
export function isFormHoneypotTriggered(formElement) {
    if (!formElement) {
        return false;
    }
    const trap = formElement.querySelector(FORM_HONEYPOT_SELECTOR);
    return Boolean(trap && trap.checked);
}
