import './bootstrap';
import * as fabric from 'fabric';
import customizer from './customizer';

window.fabric = fabric;
window.Alpine.data('customizer', customizer);
window.Alpine.start();
