// Fade in elements on page load
document.addEventListener('DOMContentLoaded', () => {
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach(element => {
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
    });
});

// Smooth transitions for cards
const cards = document.querySelectorAll('.action-card, .patient-row, .consultation-card');
cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-5px)';
        card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
    });
    
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 5px 10px rgba(0,0,0,0.05)';
    });
});

// Button click animation
const buttons = document.querySelectorAll('button, .form-button, .action-button');
buttons.forEach(button => {
    button.addEventListener('click', function(e) {
        let ripple = document.createElement('span');
        ripple.classList.add('ripple');
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

// Form submission loading animation
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    form.addEventListener('submit', () => {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.classList.add('loading');
    });
});
