

// test le plugin ScrollTrigger de gsap
gsap.registerPlugin(ScrollTrigger);




if (window.innerWidth > 800) {
  runSentenceAnimations("+=88%");
  runBentoAnimations();
}
else {
  runSentenceAnimations("start start");
}


/**
 * Registers the ScrollTrigger plugin with GSAP and defines a series of animations
 * to be triggered based on scroll events.
 *
 * The animations include:
 * - Pinning a sentence element in place while scrolling.
 *
 *
 */
function runSentenceAnimations(endString) {
    // Animation fixed position de la ssentence
    gsap.to(".sentence", {
      scrollTrigger: {
        trigger: ".sentence",
        start: "top 26%",
        end: endString,
        pin: true,
        markers: true,
      },
    });
}


/**
 * Registers the ScrollTrigger plugin with GSAP and defines a series of animations
 * to be triggered based on scroll events.
 *
 * The animations include:
 * - Animating various compartments of a bento element.
 * - Animating an arrow element.
 *
 *
 */
function runBentoAnimations() {

    // Animation de la flèche
  // animation du haut de la flèche
  gsap.to("#arrow-top", {
    width: "0em",
    yPercent: 3000,
    scrollTrigger: {
      trigger: ".arrow",
      start: "25% 30%",
      end: "center 30%",
      scrub: 0.5,
    },
  });

  // animation du bas de la flèche
  gsap.to("#arrow-bottom", {
    width: "0em",
    yPercent: 3500,
    scrollTrigger: {
      trigger: ".arrow",
      start: "center 30%",
      end: "bottom-=10% 40%",
      scrub: 0.5,
    },
  });

  // animation de la rotation de la fleche de gauche
  gsap.to("#arrow-right", {
    rotation: -90,
    xPercent: -35,
    yPercent: 75,
    scrollTrigger: {
      trigger: ".arrow",
      start: "center 30%",
      end: "bottom 55%",
      scrub: 0.5,
    },
  });
  // animation de la disparition de la fleche de gauche
  gsap.to("#arrow-right", {
    opacity: 0,
    scrollTrigger: {
      trigger: ".arrow",
      start: "bottom-=16% 47%",
      end: "bottom-=10% 48%",
      scrub: 0.5,
    },
  });

  // animation de la rotation de la fleche de droite
  gsap.to("#arrow-left", {
    rotation: 90,
    xPercent: 30,
    yPercent: 75,
    scrollTrigger: {
      trigger: ".arrow",
      start: "center 30%",
      end: "bottom 55%",
      scrub: 0.5,
    },
  });
  // animation de la disparition de la fleche de droite
  gsap.to("#arrow-left", {
    opacity: 0,
    scrollTrigger: {
      trigger: ".arrow",
      start: "bottom-=16% 47%",
      end: "bottom-=10% 48%",
      scrub: 0.5,
    },
  });

  // animation du texte dans la fleche
  gsap.to(".arrow p", {
    yPercent: 300,
    scale: 0.5,
    opacity: 0,
    scrollTrigger: {
      trigger: ".arrow",
      start: "center 30%",
      end: "bottom-=15% 30%",
      scrub: 1,
    },
  });

  // Animation des differents compatiments du bento
  gsap.to(".b1", {
    xPercent: -250,
    scrollTrigger: {
      trigger: "#bento",
      toggleActions: "complete reverse restart none",
      start: "top-=100% 30%",
      end: "bottom-=115% 50%",
    },
    ease: "ease-out",
    duration: 0.5,
  });
  gsap.to(".b2", {
    xPercent: 250,
    scrollTrigger: {
      trigger: "#bento",
      toggleActions: "complete reverse restart none",
      start: "top-=100% 30%",
      end: "bottom-=105% 50%",
    },
    ease: "ease-out",
    duration: 0.8,
  });
  gsap.to(".b3", {
    yPercent: 150,
    scrollTrigger: {
      trigger: "#bento",
      toggleActions: "complete reverse restart none",
      start: "top-=100% 30%",
      end: "bottom-=95% 50%",
    },
    ease: "ease-out",
    duration: 0.7,
  });
  gsap.to(".b4", {
    yPercent: 100,
    scrollTrigger: {
      trigger: "#bento",
      toggleActions: "complete reverse restart none",
      start: "top-=100% 30%",
      end: "bottom-=80% 50%",
    },
    ease: "ease-out",
    duration: 0.8,
  });
  gsap.to(".b5", {
    xPercent: 200,
    scrollTrigger: {
      trigger: "#bento",
      toggleActions: "complete reverse restart none",
      start: "top-=100% 30%",
      end: "bottom-=75% 50%",
    },
    ease: "ease-out",
    duration: 0.85,
  });
}

