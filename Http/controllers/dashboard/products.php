<?php 


// Database connection
$servername = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "coffeeshop_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch products data
$sql = "SELECT * FROM tblproducts";
$statement = $pdo->prepare($sql);
$statement->execute();
$productsData = $statement->fetchAll(PDO::FETCH_ASSOC);
//Fetch inventory data
$sql = "SELECT * FROM tblinventory";
$inventoryStatement = $pdo->prepare($sql);
$inventoryStatement->execute();
$inventoryData = $inventoryStatement->fetchAll(PDO::FETCH_ASSOC);
// Fetch data from tblcategory_product
$sqlCategoryProduct = "SELECT * FROM tblcategory_product";
$categoryProductStatement = $pdo->prepare($sqlCategoryProduct);
$categoryProductStatement->execute();
$categoryProductData = $categoryProductStatement->fetchAll(PDO::FETCH_ASSOC);
// Fetch data from tblPromos
$sqlPromos = "SELECT * FROM tblpromo";
$promosStatement = $pdo->prepare($sqlPromos);
$promosStatement->execute();
$promosData = $promosStatement->fetchAll(PDO::FETCH_ASSOC);

//code that calculates whether a product is available, not available or ingredients are not set

foreach ($productsData as $productRow) {
    $sql = "SELECT *
    FROM
    tblproducts_inventory PI
    JOIN
    tblproducts P ON PI.products_id = P.product_Id
    JOIN
    tblInventory I ON PI.inventory_id = I.inventory_id
    WHERE
    PI.products_id = $productRow[product_id]
    ";
    $checkInventory = $pdo->prepare($sql);
    $checkInventory->execute();
    $productInventoryData = $checkInventory->fetchAll(PDO::FETCH_ASSOC);

    if ($checkInventory->rowCount() === 0) {
        $sqlChangeNull = "UPDATE tblproducts SET status = NULL WHERE tblproducts.product_id = $productRow[product_id]";
        $changeNull = $pdo->prepare($sqlChangeNull);
        $changeNull->execute();
    } else {
        foreach ($productInventoryData as $productInventoryRow) {
            if ($productInventoryRow['quantity'] > 0) {
                $sqlChangeAvailable = "UPDATE tblproducts SET status = 'Available' WHERE tblproducts.product_id = :productId;";
                $changeAvailable = $pdo->prepare($sqlChangeAvailable);
                $changeAvailable->bindParam(':productId', $productRow['product_id']);
                $changeAvailable->execute();
            } else {
                $sqlChangeNotAvailable = "UPDATE tblproducts SET status = 'Not Available' WHERE tblproducts.product_id = :productId;";
                $changeNotAvailable = $pdo->prepare($sqlChangeNotAvailable);
                $changeNotAvailable->bindParam(':productId', $productRow['product_id']);
                $changeNotAvailable->execute();
                break;
            }
        }
    }
}


// Sa add,edit,delete button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_add'])) {
        // Sa Add action to
        $newProduct = $_POST['new_product'];
        $newDescription = $_POST['new_productDescription'];
        $newPrice = $_POST['new_price'];
        $newStatus = $_POST['new_status'];
        $newCategory = $_POST['new_category'];

        try {

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
    
            // Check if file already exists
            if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
            }
    
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
            }
    
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }
    
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $upload_file = basename($_FILES["fileToUpload"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            }

            $sqlAdd = "INSERT INTO tblproducts (product_name, product_description ,price, image,  category) VALUES (:newProduct, :newDescription, :newPrice, :image, :newCategory)";
            $statementAdd = $pdo->prepare($sqlAdd);
            $statementAdd->bindParam(':newProduct', $newProduct);
            $statementAdd->bindParam(':newDescription', $newDescription);
            $statementAdd->bindParam(':newPrice', $newPrice);
            $statementAdd->bindParam(':image', $upload_file);
            $statementAdd->bindParam(':newCategory', $newCategory);
            $statementAdd->execute();

            //add user log [added a new product]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has added a new product.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            header("Location: /admin_dashboard/products");
            exit(); // Ensure to stop script execution after redirection
        } catch (PDOException $e) {
            // Handle the exception/error
            echo "Error: " . $e->getMessage();
            // You can log the error or perform additional actions based on your requirements
        }
    }

    // Ito sa edit action
    if (isset($_POST['submit_edit'])) {
        $editProductId = $_POST['edit_product_id'];
        $editedProduct = $_POST['edited_product'];
        $editedDescription = $_POST['edited_description'];
        $editedPrice = $_POST['edited_price'];
        $editedCategory = $_POST['edited_category'];

        try {
            $sqlEdit = "UPDATE tblproducts SET product_name = :editedProduct, product_description = :editedDescription, price = :editedPrice, category = :editedCategory WHERE product_id = :editProductId";
            $statementEdit = $pdo->prepare($sqlEdit);
            $statementEdit->bindParam(':editProductId', $editProductId);
            $statementEdit->bindParam(':editedProduct', $editedProduct);
            $statementEdit->bindParam(':editedDescription', $editedDescription);
            $statementEdit->bindParam(':editedPrice', $editedPrice);
            $statementEdit->bindParam(':editedCategory', $editedCategory);

            $statementEdit->execute();

            //add user log [edited a product]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has edited a product.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            header("Location: /admin_dashboard/products");
            exit(); // Ensure to stop script execution after redirection
        } catch (PDOException $e) {
            // Handle the exception/error
            echo "Error: " . $e->getMessage();
            // You can log the error or perform additional actions based on your requirements
        }
    }


    // Sa delete 
    if (isset($_POST['submit_delete'])) {
        try {
            $deleteItemId = $_POST['delete_product_id'];

            //also reset the ingredients from the product
            try {
                $deleteProductIngredients = $deleteItemId;

                $sqlDelete = "DELETE FROM tblproducts_inventory WHERE products_id = :deleteItemId";
                $statementReset = $pdo->prepare($sqlDelete);
                $statementReset->bindParam(':deleteItemId', $deleteProductIngredients);
                $statementReset->execute();

                //add user log [reset ingredients for a product]
                $DateTime = new DateTime();
                $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
                $DateTime->setTimeZone($philippinesTimeZone);

                $currentDateTime = $DateTime->format('Y-m-d H:i:s');
                $employeeid = $_SESSION['employeeID'];
                $loginfo = $_SESSION['username'] . ' has reset a product ingredients.';

                try {
                    $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                    $statementLogAdd = $pdo->prepare($sqlLogAdd);
                    $statementLogAdd->bindParam(':loginfo', $loginfo);
                    $statementLogAdd->bindParam(':employeeid', $employeeid);
                    $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                    $statementLogAdd->execute();
                } catch (PDOException $e) {
                    // Handle the exception/error
                    echo "Error: " . $e->getMessage();
                }

                foreach ($productsData as $productRow) {
                    $sql = "SELECT *
                    FROM
                    tblproducts_inventory PI
                    JOIN
                    tblproducts P ON PI.products_id = P.product_Id
                    JOIN
                    tblInventory I ON PI.inventory_id = I.inventory_id
                    WHERE
                    PI.products_id = $productRow[product_id]
                    ";
                    $checkInventory = $pdo->prepare($sql);
                    $checkInventory->execute();
                    $productInventoryData = $checkInventory->fetchAll(PDO::FETCH_ASSOC);

                    if ($checkInventory->rowCount() === 0) {
                        $sqlChangeNull = "UPDATE tblproducts SET status = NULL WHERE tblproducts.product_id = $productRow[product_id]";
                        $changeNull = $pdo->prepare($sqlChangeNull);
                        $changeNull->execute();
                    } else {
                        foreach ($productInventoryData as $productInventoryRow) {
                            if ($productInventoryRow['quantity'] > 0) {
                                $sqlChangeAvailable = "UPDATE tblproducts SET status = 'Available' WHERE tblproducts.product_id = :productId;";
                                $changeAvailable = $pdo->prepare($sqlChangeAvailable);
                                $changeAvailable->bindParam(':productId', $productRow['product_id']);
                                $changeAvailable->execute();
                            } else {
                                $sqlChangeNotAvailable = "UPDATE tblproducts SET status = 'Not Available' WHERE tblproducts.product_id = :productId;";
                                $changeNotAvailable = $pdo->prepare($sqlChangeNotAvailable);
                                $changeNotAvailable->bindParam(':productId', $productRow['product_id']);
                                $changeNotAvailable->execute();
                                break;
                            }
                        }
                    }
                }

                $sqlDelete = "DELETE FROM tblproducts WHERE product_id = :deleteItemId";
                $statementDelete = $pdo->prepare($sqlDelete);
                $statementDelete->bindParam(':deleteItemId', $deleteItemId);
                $statementDelete->execute();

                //add user log [delete a product]
                $DateTime = new DateTime();
                $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
                $DateTime->setTimeZone($philippinesTimeZone);

                $currentDateTime = $DateTime->format('Y-m-d H:i:s');
                $employeeid = $_SESSION['employeeID'];
                $loginfo = $_SESSION['username'] . ' has deleted a product.';

                try {
                    $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                    $statementLogAdd = $pdo->prepare($sqlLogAdd);
                    $statementLogAdd->bindParam(':loginfo', $loginfo);
                    $statementLogAdd->bindParam(':employeeid', $employeeid);
                    $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                    $statementLogAdd->execute();
                } catch (PDOException $e) {
                    // Handle the exception/error
                    echo "Error: " . $e->getMessage();
                }



                header("Location: /admin_dashboard/products");
                exit(); // Ensure that code stops executing after redirection
            } catch (PDOException $e) {
                // Handle any potential errors here
                echo "Error: " . $e->getMessage();
                // You might want to log the error or redirect to an error page
            }

            // Redirect to Products.php after successful deletion
            header("Location: /admin_dashboard/products");
            exit(); // Ensure that code stops executing after redirection


        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            // You might want to log the error or redirect to an error page
        }
    }

    //insert ingredients
    if (isset($_POST['submit_insert'])) {
        $productId = $_POST['insert_product_id'];

        try {
            // Loop through posted data to get the selected values
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'select') === 0) {
                    $inventoryId = $value; // Assuming the value is the inventory_id

                    // Prepare and execute the insert query
                    $sqlInsert = "INSERT INTO tblproducts_inventory (products_id, inventory_id) VALUES (:productId, :inventoryId)";
                    $statementInsert = $pdo->prepare($sqlInsert);
                    $statementInsert->bindParam(':productId', $productId);
                    $statementInsert->bindParam(':inventoryId', $inventoryId);
                    $statementInsert->execute();

                    //add user log [insert ingredients for a product]
                    $DateTime = new DateTime();
                    $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
                    $DateTime->setTimeZone($philippinesTimeZone);

                    $currentDateTime = $DateTime->format('Y-m-d H:i:s');
                    $employeeid = $_SESSION['employeeID'];
                    $loginfo = $_SESSION['username'] . ' has inserted ingredients for a product.';

                    try {
                        $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                        $statementLogAdd = $pdo->prepare($sqlLogAdd);
                        $statementLogAdd->bindParam(':loginfo', $loginfo);
                        $statementLogAdd->bindParam(':employeeid', $employeeid);
                        $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                        $statementLogAdd->execute();
                    } catch (PDOException $e) {
                        // Handle the exception/error
                        echo "Error: " . $e->getMessage();
                    }

                    foreach ($productsData as $productRow) {
                        $sql = "SELECT *
                        FROM
                        tblproducts_inventory PI
                        JOIN
                        tblproducts P ON PI.products_id = P.product_Id
                        JOIN
                        tblInventory I ON PI.inventory_id = I.inventory_id
                        WHERE
                        PI.products_id = $productRow[product_id]
                        ";
                        $checkInventory = $pdo->prepare($sql);
                        $checkInventory->execute();
                        $productInventoryData = $checkInventory->fetchAll(PDO::FETCH_ASSOC);

                        if ($checkInventory->rowCount() === 0) {
                            $sqlChangeNull = "UPDATE tblproducts SET status = NULL WHERE tblproducts.product_id = $productRow[product_id]";
                            $changeNull = $pdo->prepare($sqlChangeNull);
                            $changeNull->execute();
                        } else {
                            foreach ($productInventoryData as $productInventoryRow) {
                                if ($productInventoryRow['quantity'] > 0) {
                                    $sqlChangeAvailable = "UPDATE tblproducts SET status = 'Available' WHERE tblproducts.product_id = :productId;";
                                    $changeAvailable = $pdo->prepare($sqlChangeAvailable);
                                    $changeAvailable->bindParam(':productId', $productRow['product_id']);
                                    $changeAvailable->execute();
                                } else {
                                    $sqlChangeNotAvailable = "UPDATE tblproducts SET status = 'Not Available' WHERE tblproducts.product_id = :productId;";
                                    $changeNotAvailable = $pdo->prepare($sqlChangeNotAvailable);
                                    $changeNotAvailable->bindParam(':productId', $productRow['product_id']);
                                    $changeNotAvailable->execute();
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            header("Location: /admin_dashboard/products");
            exit(); // Ensure to stop script execution after redirection
        } catch (PDOException $e) {
            // Handle the exception/error
            echo "Error: " . $e->getMessage();
            // You can log the error or perform additional actions based on your requirements
        }
    }

    //RESET INGREDIENTS
    if (isset($_POST['reset_ingredients'])) {
        try {
            $deleteProductIngredients = $_POST['deleteProductIngredients'];

            $sqlDelete = "DELETE FROM tblproducts_inventory WHERE products_id = :deleteItemId";
            $statementReset = $pdo->prepare($sqlDelete);
            $statementReset->bindParam(':deleteItemId', $deleteProductIngredients);
            $statementReset->execute();

            //add user log [reset ingredients for a product]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has reset a product ingredients.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            foreach ($productsData as $productRow) {
                $sql = "SELECT *
                FROM
                tblproducts_inventory PI
                JOIN
                tblproducts P ON PI.products_id = P.product_Id
                JOIN
                tblInventory I ON PI.inventory_id = I.inventory_id
                WHERE
                PI.products_id = $productRow[product_id]
                ";
                $checkInventory = $pdo->prepare($sql);
                $checkInventory->execute();
                $productInventoryData = $checkInventory->fetchAll(PDO::FETCH_ASSOC);

                if ($checkInventory->rowCount() === 0) {
                    $sqlChangeNull = "UPDATE tblproducts SET status = NULL WHERE tblproducts.product_id = $productRow[product_id]";
                    $changeNull = $pdo->prepare($sqlChangeNull);
                    $changeNull->execute();
                } else {
                    foreach ($productInventoryData as $productInventoryRow) {
                        if ($productInventoryRow['quantity'] > 0) {
                            $sqlChangeAvailable = "UPDATE tblproducts SET status = 'Available' WHERE tblproducts.product_id = :productId;";
                            $changeAvailable = $pdo->prepare($sqlChangeAvailable);
                            $changeAvailable->bindParam(':productId', $productRow['product_id']);
                            $changeAvailable->execute();
                        } else {
                            $sqlChangeNotAvailable = "UPDATE tblproducts SET status = 'Not Available' WHERE tblproducts.product_id = :productId;";
                            $changeNotAvailable = $pdo->prepare($sqlChangeNotAvailable);
                            $changeNotAvailable->bindParam(':productId', $productRow['product_id']);
                            $changeNotAvailable->execute();
                            break;
                        }
                    }
                }
            }

            header("Location: /admin_dashboard/products");
            exit(); // Ensure that code stops executing after redirection
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            // You might want to log the error or redirect to an error page
        }
    }

    //add edit delete sa categories
    //add category
    if (isset($_POST['addCategory'])) {
        try {
            $newCategory = $_POST['new_category'];

            $sqlAddCategory = "INSERT INTO tblcategory_product (category) VALUES (:newCategory)";
            $statementAddCategory = $pdo->prepare($sqlAddCategory);
            $statementAddCategory->bindParam(':newCategory', $newCategory);
            $statementAddCategory->execute();

            //add user log [added a new product category]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has added a new product category.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }
            header("Location: Products.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //delete category
    if (isset($_POST['categoryDelete'])) {
        try {
            $deleteCategoryId = $_POST['delete_category_id'];

            $sqlDeleteCategory = "DELETE FROM tblcategory_product WHERE categoryProduct_id = :deleteCategoryId";
            $statementDeleteCategory = $pdo->prepare($sqlDeleteCategory);
            $statementDeleteCategory->bindParam(':deleteCategoryId', $deleteCategoryId);
            $statementDeleteCategory->execute();

            //add user log [deleted a product category]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has deleted a product category.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            // Redirect to Products.php after successful deletion
            header("Location: Products.php");
            exit(); // Ensure that code stops executing after redirection
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            // You might want to log the error or redirect to an error page
        }
    }

    //save edit category
    if (isset($_POST['update_product'])) {
        try {
            $editCategoryId = $_POST['update_category_id'];
            $editedCategory = $_POST['update_productCategory'];


            $sqlEditCategory = "UPDATE tblcategory_product SET category = :editedCategory WHERE categoryProduct_id = :editCategoryId";
            $statementEditCategory = $pdo->prepare($sqlEditCategory);
            $statementEditCategory->bindParam(':editCategoryId', $editCategoryId);
            $statementEditCategory->bindParam(':editedCategory', $editedCategory);
            $statementEditCategory->execute();

            //add user log [edit a product category]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has edited a product category.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            header("Location: Products.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //add edit delete sa promos
    //add promos
    if (isset($_POST['addPromo'])) {
        try {
            $newPromoName = $_POST['new_promoName'];
            $newPromoDesc = $_POST['new_promoDesc'];
            $newPromoCode = $_POST['new_promoCode'];
            $newPromoValue = $_POST['new_value'];
            $newPromoStartDate = $_POST['new_startDate'];
            $newPromoEndDate = $_POST['new_endDate'];

            $sqlAddPromo = "INSERT INTO tblpromo (promoname, promodesc, promocode, value, startdate, enddate) VALUES (:newPromoName, :newPromoDesc, :newPromoCode, :newPromoValue, :newPromoStartDate, :newPromoEndDate)";
            $statementAddPromo = $pdo->prepare($sqlAddPromo);
            $statementAddPromo->bindParam(':newPromoName', $newPromoName);
            $statementAddPromo->bindParam(':newPromoDesc', $newPromoDesc);
            $statementAddPromo->bindParam(':newPromoCode', $newPromoCode);
            $statementAddPromo->bindParam(':newPromoValue', $newPromoValue);
            $statementAddPromo->bindParam(':newPromoStartDate', $newPromoStartDate);
            $statementAddPromo->bindParam(':newPromoEndDate', $newPromoEndDate);
            $statementAddPromo->execute();

            //add user log [add new promo]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has added a new promo.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            header("Location: /admin_dashboard/products");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //delete promos
    if (isset($_POST['promoDelete'])) {
        try {
            $deletePromoId = $_POST['delete_promo_id'];

            $sqlDeletePromo = "DELETE FROM tblpromo WHERE promoid = :deletePromoId";
            $statementDeletePromo = $pdo->prepare($sqlDeletePromo);
            $statementDeletePromo->bindParam(':deletePromoId', $deletePromoId);
            $statementDeletePromo->execute();

            //add user log [delete a promo]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has deleted a promo.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            // Redirect to Products.php after successful deletion
            header("Location: /admin_dashboard/products");
            exit(); // Ensure that code stops executing after redirection
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            // You might want to log the error or redirect to an error page
        }
    }

    //save edit promos
    if (isset($_POST['update_promo'])) {
        try {
            $editedPromoId = $_POST['update_promo_id'];
            $editedPromoName = $_POST['update_promoName'];
            $editedPromoDesc = $_POST['update_promoDesc'];
            $editedPromoCode = $_POST['update_promoCode'];
            $editedPromoValue = $_POST['update_promoValue'];
            $editedPromoStartDate = $_POST['update_promoStartDate'];
            $editedPromoEndDate = $_POST['update_promoEndDate'];

            $sqlEditPromo = "UPDATE tblpromo SET promoname = :editedPromoName, promodesc = :editedPromoDesc, promocode = :editedPromoCode, value = :editedPromoValue, startdate = :editedPromoStartDate, enddate = :editedPromoEndDate WHERE promoid = :editedPromoId";
            $statementEditPromo = $pdo->prepare($sqlEditPromo);
            $statementEditPromo->bindParam(':editedPromoId', $editedPromoId);
            $statementEditPromo->bindParam(':editedPromoName', $editedPromoName);
            $statementEditPromo->bindParam(':editedPromoDesc', $editedPromoDesc);
            $statementEditPromo->bindParam(':editedPromoCode', $editedPromoCode);
            $statementEditPromo->bindParam(':editedPromoValue', $editedPromoValue);
            $statementEditPromo->bindParam(':editedPromoStartDate', $editedPromoStartDate);
            $statementEditPromo->bindParam(':editedPromoEndDate', $editedPromoEndDate);

            //add user log [edited a promo]
            $DateTime = new DateTime();
            $philippinesTimeZone = new DateTimeZone('Asia/Manila'); // Set to the Philippines time zone
            $DateTime->setTimeZone($philippinesTimeZone);

            $currentDateTime = $DateTime->format('Y-m-d H:i:s');
            $employeeid = $_SESSION['employeeID'];
            $loginfo = $_SESSION['username'] . ' has edited a promo.';

            try {
                $sqlLogAdd = "INSERT INTO tbluserlogs (log_datetime, loginfo, employeeid) VALUES (:currentDateTime, :loginfo, :employeeid)";
                $statementLogAdd = $pdo->prepare($sqlLogAdd);
                $statementLogAdd->bindParam(':loginfo', $loginfo);
                $statementLogAdd->bindParam(':employeeid', $employeeid);
                $statementLogAdd->bindParam(':currentDateTime', $currentDateTime);
                $statementLogAdd->execute();
            } catch (PDOException $e) {
                // Handle the exception/error
                echo "Error: " . $e->getMessage();
            }

            $statementEditPromo->execute();
            header("Location: /admin_dashboard/products");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

view('dashboard/products.view.php',[
    'inventoryData' => $inventoryData,
    'categoryProductData' => $categoryProductData,
    'productsData' => $productsData,
    'promosData' => $promosData,
]);