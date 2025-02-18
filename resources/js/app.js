import './bootstrap';
import 'core-js/stable'; // Import Core-JS for polyfills
import 'regenerator-runtime/runtime'; // Needed for async/await support

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start(); // Only Alpine.js needs to be started
