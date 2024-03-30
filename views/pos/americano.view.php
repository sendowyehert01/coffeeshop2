<?php require "partials/head.php"; ?>
<?php require "partials/nav.php"; ?>

    <div class="sellables-container">
      <div class="sellables">
      <?php require "partials/nav2.php"; ?>

        <div class="item-group-wrapper">
          <div class="item-group">
            <a href="#" class="item">Iced Americano</a>
            <a href="#" class="item">Con Frappe</a>
            <a href="#" class="item">Classic Americano</a>
          </div>
          <div class="item-group">
            <a href="#" class="item">KAPE</a>
            <a href="#" class="item">KAPE</a>
            <a href="#" class="item">KAPE</a>
            <a href="#" class="item">KAPE</a>
            <a href="#" class="item">KAPE</a>
          </div>
        </div>
      </div>

      <div class="register-wrapper">
        <div class="customer">
          <input type="text" placeholder="John Doe" />
        </div>

        <div class="register">
          <div class="products">
            <div class="product-bar selected">
              <span>Salted Caramel</span>
              <span>$5.00</span>
            </div>

            <div class="product-bar">
              <span>Dark Caramel</span>
              <span>$5.00</span>
            </div>

            <div class="product-bar">
              <span>Cookies</span>
              <span>$5.00</span>
            </div>
          </div>

          <div class="pay-button">
            <a href="#">Pay $50.00</a>
          </div>
        </div>
      </div>
    </div>
<?php require "partials/foot.php"; ?>
