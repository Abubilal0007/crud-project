// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Initialize ScrollMagic controller
    var controller = new ScrollMagic.Controller();

    // Create a scene
    var scene = new ScrollMagic.Scene({
        triggerElement: '#trigger1', // point of execution
        duration: '100%', // pin the element for the window height - 1
        triggerHook: 0.5, // show, when scrolled 10% into view
        reverse: false // only do once
    })
    .setClassToggle('#animate1', 'fade-in') // the element we want to change
    .addTo(controller); // assign the scene to the controller
});
