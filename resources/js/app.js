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

    // Hero Staggered Reveal
    if (document.querySelector('.gsap-hero-title')) {
        tl.to('.gsap-hero-title', {
            y: 0,
            opacity: 1,
            duration: 1.2,
            ease: 'power4.out'
        })
            .to('.gsap-hero-text', {
                y: 0,
                opacity: 1,
                duration: 1,
                ease: 'power3.out'
            }, '-=0.8')
            .to('.gsap-search-form', {
                y: 0,
                opacity: 1,
                duration: 1,
                ease: 'back.out(1.7)'
            }, '-=0.8')
            .to('.gsap-hero-bg', {
                opacity: 0.4,
                duration: 2,
                ease: 'power2.inOut'
            }, '-=1.5');

        // Hero Parallax Effect
        document.addEventListener('mousemove', (e) => {
            const x = (window.innerWidth - e.pageX * 2) / 100;
            const y = (window.innerHeight - e.pageY * 2) / 100;

            gsap.to('.gsap-hero-bg', {
                x: x * 2,
                y: y * 2,
                duration: 1,
                ease: 'power2.out'
            });
        });
    }

    // Post Cards Scroll & Hover Animation
    const cards = document.querySelectorAll('.gsap-post-card');
    if (cards.length > 0) {
        // Scroll Appearance
        gsap.fromTo(cards,
            { y: 50, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.grid', // Trigger based on the container
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            }
        );

        // Hover Effect
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    y: -10,
                    scale: 1.02,
                    boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    y: 0,
                    scale: 1,
                    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)', // Reset to Tailwind default shadow-md approx
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });
    }

    // Button Hover Animations
    const buttons = document.querySelectorAll('.gsap-button');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            gsap.to(btn, {
                scale: 1.05,
                duration: 0.2,
                ease: 'back.out(1.7)'
            });
        });
        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, {
                scale: 1,
                duration: 0.2,
                ease: 'power2.out'
            });
        });
    });
});
