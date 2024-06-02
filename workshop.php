<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop & Sell</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div id="header-items">
        <h1>WORKSHOP & SELL</h1>
        <div id="header-buttons">
            <a href="./company_control.php"><button>COMPANY CONTROL CENTER</button></a>
            <a href="./workshop.php"><button>WORKSHOP & SELL</button></a>
            <a href="./mission_control.php"><button>MISSION CONTROL CENTER</button></a>
        </div>
    </div>
</header>
<section class="crafting-items">
    <h2>CRAFT ITEMS</h2>
    <?php
    include "connect.php";

    // Fetch user's resources
    $resources_query = mysqli_query($connection, "SELECT * FROM main_base_resources WHERE id = 1");
    $resources_row = mysqli_fetch_array($resources_query);
    $user_resources = [
        'metals' => $resources_row['metals'],
        'synthetics' => $resources_row['synthetics']
    ];

    // Fetch researched items
    $researched_query = mysqli_query($connection, "SELECT * FROM research WHERE is_owned = 1");
    $researched_items = [];
    while ($row = mysqli_fetch_array($researched_query)) {
        $researched_items[] = $row['id'];
    }

    if (empty($researched_items)) {
        echo "<p>No items have been researched yet. Please research items in the Company Control Center to craft them.</p>";
    } else {
        // Fetch crafting items
        $items_query = mysqli_query($connection, "SELECT * FROM research");
        while ($item = mysqli_fetch_array($items_query)) {
            if (in_array($item['id'], $researched_items)) {
                $create_cost_query = mysqli_query($connection, "SELECT * FROM create_costs WHERE id = " . $item['craftID']);
                $create_cost = mysqli_fetch_array($create_cost_query);
                
                $can_afford = ($user_resources['metals'] >= $create_cost['metal_cost']) && ($user_resources['synthetics'] >= $create_cost['synthetics_cost']);
                echo "<div class='item'>
                        <img id='item-icon' src='./img/Item.png' style='width: 250px;'>
                        <div>
                            <p id='nazwa'>{$item['name']}</p>
                            <p id='koszt'>{$create_cost['metal_cost']}<img src='./img/Mineral.png' style='width: 22px;' id='itemCost'> {$create_cost['synthetics_cost']}<img src='./img/Synthetics.png' style='width: 22px;' id='itemCost'></p>
                            <p id='koszt'>SELL COST: {$item['cost']}<img src='./img/Money.png' style='width: 22px;' id='itemCost'></p>
                        </div>
                        <form method='POST' action='craft_item.php'>
                            <label>COUNT: </label>
                            <input required type='number' name='item_count' style='width: 20%;' min='1' max='31'> 
                            <input type='hidden' name='item_id' value='{$item['id']}'>
                            <input type='hidden' name='item_cost_metals' value='{$create_cost['metal_cost']}'>
                            <input type='hidden' name='item_cost_synthetics' value='{$create_cost['synthetics_cost']}'>
                            <button type='submit' style='width: 80%;' " . ($can_afford ? "" : "disabled") . ">CRAFT</button>
                        </form>
                    </div>";
            }
        }
    }
    ?>
</section>

<section class="selling-items">
    <h2>SELL ITEMS</h2>
    <?php
    // Fetch inventory items
    $inventory_query = mysqli_query($connection, "SELECT m.id, m.name, i.quantity, m.cost FROM main_base_inventory i JOIN research m ON i.itemID = m.id");
    
    if (mysqli_num_rows($inventory_query) > 0) {
        while ($item = mysqli_fetch_array($inventory_query)) {
            echo "<div class='item'>
                    <p id='nazwa'>{$item['name']}</p>
                    <p id='koszt'>Available: {$item['quantity']}</p>
                    <p id='koszt'>SELL COST: {$item['cost']}<img src='./img/Money.png' style='width: 22px;' id='itemCost'></p>
                    <form method='POST' action='sell_item.php'>
                        <label>COUNT: </label>
                        <input required type='number' name='item_count' style='width: 20%;' min='1' max='{$item['quantity']}'> 
                        <input type='hidden' name='item_id' value='{$item['id']}'>
                        <input type='hidden' name='item_cost' value='{$item['cost']}'>
                        <button type='submit' style='width: 80%;'>SELL</button>
                    </form>
                </div>";
        }
    } else {
        echo "<p>No items available to sell.</p>";
    }
    ?>
</section>

<script src="script.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>
</body>
</html>
