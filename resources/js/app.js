import Alpine from 'alpinejs';
import { HSStaticMethods } from 'preline/non-auto';

window.Alpine = Alpine;

const initializePreline = () => HSStaticMethods.autoInit();

Alpine.start();

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializePreline, { once: true });
} else {
    initializePreline();
}
