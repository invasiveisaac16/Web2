import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

Alpine.start();

// Hero Animations
document.addEventListener('DOMContentLoaded', () => {
    const tl = gsap.timeline();

    if (document.querySelector('.gsap-hero-title')) {
        tl.to('.gsap-hero-title', {
            y: 0,
            opacity: 1,
            duration: 1,
            ease: 'power3.out'
        })
            .to('.gsap-hero-text', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.gsap-search-form', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.gsap-hero-bg', {
                opacity: 0.3, // Restore original opacity
                duration: 2,
                ease: 'none',
                repeat: -1,
                yoyo: true
            }, '-=1');
    }

    // Post Cards Scroll Animation
    const cards = document.querySelectorAll('.gsap-post-card');
    if (cards.length > 0) {
        gsap.to(cards, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.1,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: '.gsap-post-card',
                start: 'top 85%', // Start animation when top of element hits 85% of viewport height
                toggleActions: 'play none none reverse'
            }
        });
    }
});
