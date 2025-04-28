var tl = gsap.timeline();

tl.from("nav a", {
    y: 20,
    opacity: 0,
    stagger: 0.3, // Adds a 0.3s delay between each "nav a" animation
    duration: 0.5 // Increased duration for better visibility
})
.from(".page1 h1", {
    y: 30, // Moves the element down by 30px
    rotate: 2, // Rotates the element by 2 degrees
    opacity: 0,
    duration: 1
}, "+=0.5"); // Adds a delay of 0.5s after the "nav a" animation completes

