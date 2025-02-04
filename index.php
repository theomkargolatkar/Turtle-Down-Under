<?php
function getRezdyProducts($apiKey) {
    $url = "https://api.rezdy-staging.com/v1/products/marketplace?apiKey=$apiKey";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        die("Error: Curl request failed: " . curl_error($ch));
    }
    curl_close($ch);
    $data = json_decode($response, true);
    if ($data === null) {
        die("Error: Failed to decode JSON response");
    }
    return $data;
}

$apiKey = "81c3566e60ef42e6afa1c2719e7843fd";
$productDetails = getRezdyProducts($apiKey);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Turtle Down Under</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .header {
            min-height: 100vh;
            background-image: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3)),url(images/banner_tdu.png);
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            padding: 0 10%;
        }

        .header h1 {
            font-size: 4vw;
            font-weight: 500;
            color: #ffeb3b; /* Changed the color to yellow for better visibility */
            text-align: center;
            margin-bottom: 20px;
        }

        .search-bar {
            background:#B7D3F2;
            width: 45%;
            margin: 0 auto;
            padding: 10px 30px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar form input, .search-bar form select {
            border: 0;
            outline: none;
            background: transparent;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            flex: 1;
            min-width: 100px;
        }

        .search-bar form button {
            padding: 12px;
            background: #177E89;
            border-radius: 42px;
            border: 0;
            outline: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-bar form button img {
            width: 20px;
        }

        .location-input {
            flex: 2;
        }

        .search-bar form label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .cal, .guest {
            padding-left: 10px;
            flex: 1;
        }
    </style>

    <?php require "header.php";?>

    <div class="header">
        <div class="container">
            <h1>Find Your Next Stay</h1>
            <div class="search-bar">
                <form action="results.php" method="GET">
                    <label>Product Type</label>
                    <div style="display: flex; align-items:center;">
                        <select name="productType" id="productType" class="form-control" required>
                            <option value="" hidden disabled selected>Select a Product Type</option>
                            <?php if (!empty($productDetails['products'])): ?>
                                <?php foreach ($productDetails['products'] as $product): ?>
                                    <option class="text-dark" value="<?php echo htmlspecialchars($product['productType']); ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No products available</option>
                            <?php endif; ?>
                        </select>
                        <button type="submit"><img src="images/search.png" alt="Search"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
