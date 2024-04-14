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

//cart
// Initialize variables and elements
const cartHead = document.getElementById('cartHead');
const cart = document.getElementById('cart');
const overlay = document.getElementById('overlay');
let offsetX = 0;
let offsetY = 0;

let chatboxOpen = false;
let cartOpen = false;

function toggleCart() {
    if (!chatboxOpen) { // Check if chatbox is not open
        cart.style.display = cart.style.display === 'block' ? 'none' : 'block';
        overlay.style.display = cart.style.display === 'block' ? 'block' : 'none'; // Toggle overlay
        cartOpen = !cartOpen;
        if (cart.style.display === 'block') {
            cart.style.zIndex = 9999;
            document.body.style.overflow = 'hidden';
        } else {
            cart.style.zIndex = '';
            document.body.style.overflow = 'auto';
        }
    }
}

function toggleChatbox() {
    if (!cartOpen) { // Check if cart is not open
        const chatBox = document.getElementById("chatBot");
        chatBox.style.display = chatBox.style.display === "none" ? "block" : "none";
        const overlay = document.getElementById("overlay");
        overlay.style.display = chatBox.style.display === "none" ? "none" : "block";
        chatboxOpen = !chatboxOpen;
        if (chatBox.style.display === "none") {
            resetForm(); // Reset form if chatbox is closed
        }
    }
}

function handleCloseCart() {
    cart.style.display = 'none';
    overlay.style.display = 'none';
    cartOpen = false; // Reset cart open state
    cart.style.zIndex = '';
    document.body.style.overflow = 'auto';
}

function handleMouseDown(event) {
    offsetX = event.clientX - cartHead.getBoundingClientRect().left;
    offsetY = event.clientY - cartHead.getBoundingClientRect().top;

    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseup', handleMouseUp);
}

function handleMouseMove(event) {
    const x = event.clientX - offsetX;
    const y = event.clientY - offsetY;

    cartHead.style.left = x + 'px';
    cartHead.style.top = y + 'px';
}

function handleMouseUp() {
    document.removeEventListener('mousemove', handleMouseMove);
    document.removeEventListener('mouseup', handleMouseUp);
}

document.getElementById('closeCart').addEventListener('click', handleCloseCart);
document.querySelector('.close-btn').addEventListener('click', handleCloseCart);

cartHead.addEventListener('mousedown', handleMouseDown);

cartHead.addEventListener('click', function() {
    toggleCart();
});

const toggleChat = document.getElementById("toggleChat");
toggleChat.addEventListener("click", toggleChatbox);

const closeChatBtn = document.querySelector(".close-chat-btn");
closeChatBtn.addEventListener("click", function() {
    toggleChatbox();
});

//chatbot form logic
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("chatForm");
    const steps = ["step1", "step2", "step3", "step4"];
    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            document.getElementById(step).style.display = index === stepIndex ? "block" : "none";
        });
    }

    function handleNext() {
        currentStep++;
        if (currentStep < steps.length) {
            showStep(currentStep);
        }
    }

    function resetForm() {
        form.reset();
        currentStep = 0; 
        showStep(currentStep);
    }

    function showConfirmation() {
        Swal.fire({
            icon: 'success',
            title: 'Custom coffee order submitted!',
            showConfirmButton: false,
            timer: 1500 
        }).then(() => {
            resetForm(); 
        });
    }

    const nextButtons = document.querySelectorAll(".next-btn");
    nextButtons.forEach(button => {
        button.addEventListener("click", handleNext);
    });

    const submitBtn = document.querySelector(".submit-btn");
    submitBtn.addEventListener("click", function(event) {
        event.preventDefault();
        showConfirmation();
    });

    showStep(currentStep);
});


//increment and decrement buttons 
document.addEventListener("DOMContentLoaded", function() {
    function handleIncrementDecrement(inputId, action) {
        const inputField = document.getElementById(inputId);
        let value = parseInt(inputField.value);
        if (action === "increment") {
            value++;
        } else if (action === "decrement" && value > 0) {
            value--;
        }
        inputField.value = value;
    }

    const incrementButtons = document.querySelectorAll("[id$='-increment']");
    incrementButtons.forEach(button => {
        button.addEventListener("click", function() {
            const inputId = button.id.replace("-increment", "");
            handleIncrementDecrement(inputId, "increment");
        });
    });

    const decrementButtons = document.querySelectorAll("[id$='-decrement']");
    decrementButtons.forEach(button => {
        button.addEventListener("click", function() {
            const inputId = button.id.replace("-decrement", "");
            handleIncrementDecrement(inputId, "decrement");
        });
    });
});
