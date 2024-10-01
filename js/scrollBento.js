gsap.registerPlugin(ScrollTrigger);

gsap.to(".sentence", {
  scrollTrigger: {
    trigger: ".sentence",
    start: "-59px 50%",
    end: "+=880",
    pin: true,
    scrub: true,
  },
});
