import './bootstrap';

// Global HTML5 Validation message override for Indonesian language
document.addEventListener('invalid', function(e) {
    if (e.target.validity.valueMissing) {
        e.target.setCustomValidity('Harap isi bagian ini.');
    }
}, true);

document.addEventListener('input', function(e) {
    e.target.setCustomValidity('');
}, true);