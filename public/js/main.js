(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });
    

    // Date and time picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        margin: 30,
        dots: true,
        loop: true,
        center: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);

//ChatHead Functions
const chatHead = document.getElementById('chatHead');
const chatBox = document.getElementById('chatBox');
const overlay = document.getElementById('overlay');

// Function to toggle chat box visibility
function toggleChatBox() {
    chatBox.style.display = chatBox.style.display === 'block' ? 'none' : 'block';
    overlay.style.display = chatBox.style.display === 'block' ? 'block' : 'none'; // Toggle overlay
    if (chatBox.style.display === 'block') {
        // Bring chat box to front
        chatBox.style.zIndex = 9999;
        // Hide other content
        document.body.style.overflow = 'hidden';
    } else {
        // Reset z-index
        chatBox.style.zIndex = '';
        // Show other content
        document.body.style.overflow = 'auto';
    }
}

// Function to handle mouse down event on chat head
function handleMouseDown(event) {
    // Store the initial mouse position relative to the chat head
    offsetX = event.clientX - chatHead.getBoundingClientRect().left;
    offsetY = event.clientY - chatHead.getBoundingClientRect().top;

    // Add event listeners for mouse move and mouse up events
    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseup', handleMouseUp);
}

// Function to handle mouse move event
function handleMouseMove(event) {
    // Calculate new position of the chat head based on mouse position
    const x = event.clientX - offsetX
    const y = event.clientY - offsetY;

// Function to handle closing the chat box
function handleCloseChatBox() {
    chatBox.style.display = 'none';
    overlay.style.display = 'none'; // Hide overlay
    // Reset z-index
    chatBox.style.zIndex = '';
    // Show other content
    document.body.style.overflow = 'auto';
}
// Add event listener to close button
document.getElementById('closeChatBox').addEventListener('click', handleCloseChatBox);
// Add event listener to close button
document.getElementById('closeChatBox').addEventListener('click', handleCloseChatBox);


// Set the position of the chat head
chatHead.style.left = x + 'px';
chatHead.style.top = y + 'px';
}

// Function to handle mouse up event
function handleMouseUp() {
// Remove event listeners for mouse move and mouse up events
document.removeEventListener('mousemove', handleMouseMove);
document.removeEventListener('mouseup', handleMouseUp);
}

// Add event listener for mouse down event on chat head
chatHead.addEventListener('mousedown', handleMouseDown);

// Add event listener to toggle chat box visibility when chat head is clicked
chatHead.addEventListener('click', function() {
toggleChatBox();
});
