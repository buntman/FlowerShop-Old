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
                    <div class="card">
                <?php foreach($queryResult as $row) :?>
                    <div class="item-details">
                        <img src="<?php echo $row['image_path']; ?>" alt="White bouquet">
                        <h3 class="item-name"><?php echo $row['bouquetName']; ?></h3>
                        <p class="item-status"><?php echo $row['status']; ?></p>
                        <p class="item-stock"><?php echo $row['stocks']; ?></p>
                        <p class="item-price"><?php  echo $row['price']; ?></p>
                    </div>
                    <div class="item-actions">
                        <a href="#" class="edit" title="edit">
                         <img src="/images/inventory-icons/icon_edit.png" alt="edit">
                        </a>
                        <a href="#" class="delete" title="delete">
                         <img src="/images/inventory-icons/icon_delete.png" alt="delete">
                        </a>
                    </div>
                    </div>
                        <hr>
                <?php endforeach;?>
                </div>
            </div>
        </div>
</body>
</html> 
