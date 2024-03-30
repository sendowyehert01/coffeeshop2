<?php require "partials/head.php"; ?>
<?php require "partials/nav.php"; ?>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5DC;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            color: #333;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /*edit button style*/
        .button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button.edit-button {
            background-color: #008CBA;
            color: white;
        }

        .button.delete-button {
            background-color: #FF6347;
            color: white;
        }

        .button.add-button {
            background-color: #4CAF50;
            color: white;
            margin-right: 5px;
        }

        /*STYLE FORDA OVER LAY FORM */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            overflow: auto;
            box-sizing: border-box;
        }

        .overlay-content {
            max-height: 100%;
            /* Adjust maximum height as needed */
            max-width: 100%;
            /* Adjust maximum width as needed */
            overflow-y: auto;
        }
    </style>
    <script>
        // toggle edit coffeeshop form
        document.addEventListener('DOMContentLoaded', function () {
            const editForm = document.getElementById('editInfo');
            const overlay = document.getElementById('editOverlay');
            const closeFormBtn = document.getElementById('closeFormBtn');
            const body = document.body;
            // Initially hide the overlay form
            overlay.style.display = 'none';

            // Show the overlay form when the button is clicked
            editForm.addEventListener('click', function () {
                overlay.style.display = 'flex';
                body.style.overflow = 'hidden';
            });

            // Close the overlay form when the close button is clicked
            closeFormBtn.addEventListener('click', function () {
                overlay.style.display = 'none';
                body.style.overflow = 'visible';
            });
        });
    </script>
    <!-- form edit coffeeshop overlay-->
    <div class="overlay" id="editOverlay">
        <div class="overlay-content">
            <div class="info-box">
                <button id="closeFormBtn" class="button delete-button">X</button>
                <h2>Add New Product</h2>
                <?php foreach ($coffeeshopData as $coffeeshop): ?>
                    <form method="post" action="">
                        <input type="hidden" class="form-control" name="editId" value="<?= $coffeeshop['coffeeshopid'] ?>">
                        <div class="form-group">
                            <label for="new_product">CoffeeShop Name:</label>
                            <input type="text" class="form-control" name="editShopName"
                                value="<?= $coffeeshop['shopname'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="new_productDescription">Branch:</label>
                            <input type="text" class="form-control" name="editBranch" value="<?= $coffeeshop['branch'] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="new_price">Address: </label>
                            <input type="text" class="form-control" name="editAddress" value="<?= $coffeeshop['address'] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="new_category">Contact Number: </label>
                            <input type="number" class="form-control" name="editContact"
                                value="<?= $coffeeshop['contact_no'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="new_category">Email: </label>
                            <input type="email" class="form-control" name="editEmail" value="<?= $coffeeshop['email'] ?>"
                                required>
                        </div>
                        <button type="submit" name="submit_edit" class="button edit-button"
                            style="width:100%;">💾Save</button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="dashboard">
        <div class="top-right">
            <a href="logout.php" class="login-button">Logout</a>
        </div>
        <div class="content">
            <h2>CoffeeShop Information
                <?php echo " (" . $_SESSION['user']['email'] . " the " . $_SESSION['user']['role'] . ") " ?>
            </h2>
            <?php foreach ($coffeeshopData as $coffeeshop): ?>
                <div class="info-box" style="width:inherit; height:inherit; margin-top:5em;">
                    <div style="display: flex; justify-content: space-between;">
                        <button type="button" class="button edit-button" id="editInfo">✎Edit</button>
                    </div>
                    <div>
                        <h4><b>CoffeeShop Name:</b>
                            <p style="color:#333; display: inline;">
                                <?php echo $coffeeshop['shopname']; ?>
                            </p>
                        </h4>
                    </div>
                    <div>
                        <h4><b>Branch:</b>
                            <p style="color:#333; display: inline;">
                                <?php echo $coffeeshop['branch']; ?>
                            </p>
                        </h4>
                    </div>
                    <div>
                        <h4><b>Address:</b>
                            <p style="color:#333; display: inline;">
                                <?php echo $coffeeshop['address']; ?>
                            </p>
                        </h4>
                    </div>
                    <div>
                        <h4><b>Contact Number:</b>
                            <p style="color:#333; display: inline;">
                                <?php echo $coffeeshop['contact_no']; ?>
                            </p>
                        </h4>
                    </div>
                    <div>
                        <h4><b>Email:</b>
                            <p style="color:#333; display: inline;">
                                <?php echo $coffeeshop['email']; ?>
                            </p>
                        </h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>