<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>
<link href="css/chathead.css" rel="stylesheet">
<link href="css/table.css" rel="stylesheet">


<style>
    .category-btn-checkbox {
        display: none; /* hide the checkbox */
    }

    .category-btn-label {
        display: inline-block;
        padding: 10px 20px;
        background-color: red; /* primary button color */
        color: #fff;
        cursor: pointer;
    }

    .category-btn-label.selected {
        background-color: #ffffff; /* secondary button color */
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

                <div class="dashboard">
                    <div class="content">
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <script>
                    // Fetch product data from the backend
                    fetch('/get_products')
                        .then(response => response.json())
                        .then(products => {
                            const productContainer = document.getElementById('tbl_body');

                            // Loop through the products and display them
                            products.forEach(product => {
                                const productCard = document.createElement('tr');
                                // productCard.className = 'col-lg-4 col-md-6 mb-5';
                                productCard.innerHTML = `
                                                        <td><a href ="/show_product">${product.product_name}</a></td>
                                                        <td>${product.product_description}</td>
                                                        <td>${product.price}</td>
                                                        <td><img height="100px" src="uploads/${product.image}" alt="${product.product_name}"></td>
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

    
<!-- Coffee Shop Cart section start -->
<div id="overlay"></div>

<div class="container">
    <!--Cart-Head Starts-->
    <div class="position-fixed rounded-circle bg-primary text-white p-3 cart-head" id="cartHead">
        <i class="fas fa-shopping-cart"></i>
    </div>
    <!--Cart-Head End-->

    <!-- Cart (Hidden) -->
    <div class="position-fixed bottom-0 right-0 m-3 cart bg-light border rounded" id="cart" style="display: none;">
        <div class="cart-header bg-primary text-white p-2 rounded-top d-flex justify-content-between align-items-center">
            <h4 class="m-0">Your Cart</h4>
            <button class="close-btn btn btn-sm btn-light" id="closeCart">&times;</button>
        </div>
        <div class="cart-body p-3">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-footer p-2 bg-light border-top">
            <button id="checkoutBtn" class="btn btn-primary">Checkout</button>
        </div>
    </div>
</div>
<!-- Coffee Shop Cart section end -->

<!-- Chatbot section start -->
<div id="overlay"></div>

<div class="container">
    <div class="position-fixed bottom-0 end-0 p-2">
        <div class="chat-icon bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" id="toggleChat">
            <i class="fas fa-comment-alt"></i>
        </div>
    </div>
    <div class="chat-box bg-light border rounded position-fixed bottom-0 end-0" id="chatBot" style="display: none;">
        <div class="chat-header bg-primary text-white p-2 rounded-top d-flex justify-content-between align-items-center">
            <h4 class="m-0">Create your own coffee here</h4>
            <button class="close-chat-btn btn btn-link text-white">&times;</button>
        </div>
        <div class="chat-body p-3" id="chatBody">
            <form id="chatForm" action="/menu" method="POST">
                <!-- Step 1: Coffee Category -->
                <div id="step1">
                    <p>Select your coffee category:</p>
                    <div class="mb-3">

                        <label id="Americano" for="americano" class="category-btn-label">Americano</label>
                        <input id="americano" type="checkbox" name="category" class="category-btn-checkbox" value="Americano">
                        
                        <label id="Brewed" for="brewed" class="category-btn-label">Brewed</label>
                        <input id="brewed" type="checkbox" name="category" class="category-btn-checkbox" value="Brewed">
                        
                        <label id="Capuccino" for="capuccino" class="category-btn-label">Capuccino</label>
                        <input id="capuccino" type="checkbox" name="category" class="category-btn-checkbox" value="Capuccino">

                        <label id="Espresso" for="espresso" class="category-btn-label">Espresso</label>
                        <input id="espresso" type="checkbox" name="category" class="category-btn-checkbox" value="Espresso">

                        <label id="Frappe" for="frappe" class="category-btn-label">Frappe</label>
                        <input id="frappe" type="checkbox" name="category" class="category-btn-checkbox" value="Frappe">

                        <label id="Latte" for="latte" class="category-btn-label">Latte</label>
                        <input id="latte" type="checkbox" name="category" class="category-btn-checkbox" value="Latte">

                    </div>
                    <div class="text-end">
                        <button type="button" class="next-btn btn btn-primary">Next</button>
                    </div>
                </div>
                <!-- Step 2: Base Coffee -->
                <div id="step2" style="display: none;">
                    <p>Select base coffee:</p>
                    <div class="mb-3">
                        <div class="btn-group" id="base-coffee">

                        </div>
                        <div class="text-end">
                            <button type="button" class="next-btn btn btn-primary mt-3">Next</button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Size -->
                <div id="step3" style="display: none;">
                    <p>Select Size:</p>
                    <div class="btn-group" id="size-con">

                    </div>
                    <div class="text-end">
                        <!-- <button type="button" class="next-btn btn btn-primary mt-3">Next</button> -->
                        <button type="submit" class="submit-btn btn btn-primary mt-3">Submit</button>
                    </div>

                </div>

                <!-- Step 4: Customize Coffee -->
                <!-- <div id="step4" style="display: none;">
                    <p>Customize your coffee:</p>

                    <div class="row" id="prod_ingredients">

                        <div class="col-auto">
                            <label for="ingredient1" class="form-label">Ingredient 1:</label>
                        </div>
                        <div class="col">
                            <div class="input-group custom-input-group">
                                <button class="btn btn-outline-primary" type="button" id="ingredient1-decrement">-</button>
                                <input type="text" class="form-control text-center" id="ingredient1" value="0">
                                <button class="btn btn-outline-primary" type="button" id="ingredient1-increment">+</button>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="submit-btn btn btn-primary mt-3">Submit</button>
                </div> -->
            </form>
        </div>
    </div>
    <!-- Chatbot section end-->


</div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

     <!-- Template Javascript -->
    <?php require "js/main.php"; ?>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryCheckboxes = document.querySelectorAll('.category-btn-checkbox');
        const baseCoffeeContainer = document.getElementById('base-coffee');
        const ingredientsContainer = document.getElementById('prod_ingredients');

        const baseCoffeeOptions = <?= json_encode($products) ?>;

        // Function to update base coffee options based on selected categories
        function updateBaseCoffeeOptions() {
            const selectedCategories = Array.from(categoryCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            // Clear previous options
            baseCoffeeContainer.innerHTML = '';

            // Populate base coffee options for selected categories
            const filteredBaseCoffee = baseCoffeeOptions.filter(coffee => {
                return selectedCategories.includes(coffee.category);
            });

            filteredBaseCoffee.forEach(coffee => {
                const label = document.createElement('label');
                label.textContent = coffee.product_name;
                label.setAttribute('for', coffee.product_name.toLowerCase().replaceAll(' ', '-'));
                label.classList.add('category-btn-label');
                label.id = coffee.product_name.toLowerCase().replaceAll(' ', '_');

                const input = document.createElement('input');
                input.type = 'checkbox';
                input.name = 'base_coffee';
                input.classList.add('category-btn-checkbox');
                input.value = coffee.product_name.toLowerCase().replaceAll(' ', '_');
                input.id = coffee.product_name.toLowerCase().replaceAll(' ', '-');

                const input1 = document.createElement('input');
                input1.type = 'hidden';
                input1.name = 'base_coffee_id';
                input1.value = coffee.product_id;
                input1.id = coffee.product_id;

                const input2 = document.createElement('input');
                input2.type = 'hidden';
                input2.name = 'order_type';
                input2.value = "take-out";
                input2.id = coffee.product_id;

                const div = document.createElement('div');
                div.classList.add('btn-group');
                div.appendChild(label);
                div.appendChild(input);
                div.appendChild(input1);
                div.appendChild(input2);

                baseCoffeeContainer.appendChild(div);

            });

            $('input[name=base_coffee]').change(function() {
                if ($(this).is(':checked')) {
                    const amer = document.getElementById(this.value);
                    amer.classList.add("selected");
                    $('.category-btn-label').not('#' + this.value).removeClass('selected');
                }
                });
        }

        // Event listener for category checkboxes change
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBaseCoffeeOptions);
        });

        // Initially update base coffee options
        updateBaseCoffeeOptions();

        sizes = ["Small", "Medium", "Large"];
        const baseSizeContainer = document.getElementById('size-con');

        sizes.forEach(size => {
                const label = document.createElement('label');
                label.textContent = size;
                label.setAttribute('for', size);
                label.classList.add('category-btn-label');
                label.id = size.toLowerCase();;

                const input = document.createElement('input');
                input.type = 'checkbox';
                input.name = 'size';
                input.classList.add('category-btn-checkbox');
                input.value = size.toLowerCase();
                input.id = size;

                const div = document.createElement('div');
                div.classList.add('btn-group');
                div.appendChild(label);
                div.appendChild(input);

                baseSizeContainer.appendChild(div);

                $('input[name=size]').change(function() {
                if ($(this).is(':checked')) {
                    const amer = document.getElementById(this.value);
                    amer.classList.add("selected");
                    $('.category-btn-label').not('#' + this.value).removeClass('selected');
                }
                });

            });
    });

</script>


<?php require 'partials/foot.php'; ?>
