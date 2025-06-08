$(document).ready(function() {
    document.addEventListener('DOMContentLoaded', function() {
        // Accordion functionality for terms
        const termSections = document.querySelectorAll('.term-section');
        termSections.forEach(section => {
            const header = section.querySelector('.term-header');
            header.addEventListener('click', () => {
                section.classList.toggle('active');
            });
        });

        // Accordion functionality for privacy sections
        const privacySections = document.querySelectorAll('.privacy-section');
        privacySections.forEach(section => {
            const header = section.querySelector('.privacy-header');
            header.addEventListener('click', () => {
                section.classList.toggle('active');
                const toggle = header.querySelector('.privacy-toggle i');
                toggle.classList.toggle('fa-chevron-right');
                toggle.classList.toggle('fa-chevron-down');
            });
        });

        // Animate elements when they come into view
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.slide-up, .fade-in');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementPosition < windowHeight - 100) {
                    element.style.animationPlayState = 'running';
                }
            });
        };

        // Initial check
        animateOnScroll();
        
        // Check on scroll
        window.addEventListener('scroll', animateOnScroll);
    });
});