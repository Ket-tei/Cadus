gsap.registerPlugin(ScrollTrigger);

gsap.to(".sentence", {
  scrollTrigger: {
    trigger: ".sentence",
    start: "top 26%",
    end: "+=88%",
    pin: true,
    scrub: 1,
  },
});
