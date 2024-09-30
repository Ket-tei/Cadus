gsap.registerPlugin(ScrollTrigger);
const tl = gsap.timeline({
  scrollTrigger: {
    trigger: "#landing-page",
    start: "top top",
    endTrigger: "#bento",
    end: "top top",
    scrub: 1,
  },
});

tl.to(".sentence", {
  y: window.innerHeight * 0.88,
});
