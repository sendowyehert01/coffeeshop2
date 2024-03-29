<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>
    
    <!--ChatHead CSS-->
    <link rel="stylesheet" href="chathead.css">

    <style>
        .auto-format {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            flex-wrap: wrap;
        }
    </style>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5"
            style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Menu</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Home</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Menu</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Menu Start -->
    <div id="product-container" class="container-fluid pt-5">
        <div class="container" id="product-list">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Menu & Pricing</h4>
                <h1 class="display-4">Competitive Pricing</h1>

                <script>
                    // Fetch product data from the backend
                    fetch('get_products.php')
                        .then(response => response.json())
                        .then(products => {
                            const productContainer = document.getElementById('product-list');

                            // Loop through the products and display them
                            products.forEach(product => {
                                const productCard = document.createElement('div');
                                productCard.className = 'col-lg-4 col-md-6 mb-5';
                                productCard.innerHTML = `
                                                        <h4><a href ="products_page.html">${product.product_name}</a></h4>
                                                        <p>${product.product_description}</p>
                                                        <h5 class="menu-price">${product.price}</h5>
                                                    `;
                                productContainer.appendChild(productCard);
                            });
                        })
                        .catch(error => console.error('Error:', error));
                </script>
            </div>

        </div>
    </div>

    <!-- Menu End -->

    
    <!-- Chathead section start -->
    <div id="overlay"></div>

    <div class="container">
        <!--Chat-Head Starts-->
        <div class="position-fixed rounded-circle bg-primary text-white p-3 chat-head" id="chatHead">
            <i class="fas fa-coffee lg"></i>
        </div>
        <!--Chat-Head End-->

        <!-- Chat Box (Hidden) -->
        <div class="position-fixed bottom-0 right-0 m-3 chat-box bg-light border rounded" id="chatBox" style="display: none;">
            <div class="chat-header bg-primary text-white p-2 rounded-top d-flex justify-content-between align-items-center">
                <h4 class="m-0">Chat</h4>
                <button class="close-btn btn btn-sm btn-light" id="closeChatBox">&times;</button>
            </div>
            <div class="chat-body p-3">
            </div>
            <div class="chat-footer p-2 bg-light border-top">
                <input type="text" class="form-control mr-2" placeholder="Type your message...">
                <button id="sendBtn" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
    <!-- Chathead section end -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

<?php require 'partials/foot.php'; ?>
