<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/admin-inventory-style.css">
<title>Inventory</title>
</head>
    <body>
        <div class="sidenav">
            <a href="#">Inventory</a>
            <a href="#">Reports</a>
            <a href="#">Manage</a>
        </div>
        <div class="main-container">
            <div class="order">
            </div>
            <div class="stocks">
                <div class="card-title">
                    <h2>Current Stocks</h2>
                    <div class="button-container">
                        <button type="submit" name="add" value="add">Add New Products</button>
                    </div>
                </div>
                <div class="current-stocks">
                    <div class="item-details">
                         <img src="/images/white-bouquet.png" alt="White bouquet">
                        <h3 class="item-name">White bouquet</h3>
                        <p class="item-status">Active</p>
                        <p class="item-stock">10 in Stock</p>
                        <p class="item-price">500.00</p>
                    </div>
                    <div class="item-actions">
                        <a href="#" title="edit">
                         <img src="/images/icon_edit.png" alt="White bouquet">
                        </a>
                        <a href="#" title="delete">
                         <img src="/images/icon_delete.png" alt="White bouquet">
                        </a>
                    </div>
                </div>
            </div>
        </div>
</body>
</html> 
