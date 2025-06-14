<!doctype html>
<html>
    <head>
        <title>SCP CRUD Application</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/styles.css">
    </head>
    
    <body class='bg_image text-white'>
        <?php include "connection.php"?> <!-- imports contents into current script -->
        
        <div class='top-wrapper'>
            <!--Logo and heading container-->
            <div class='logo_h2-container'>
                <img src='./images/logo-Photoroom.png' class='img-fluid logo' alt='Logo Image'>
                <h2 class='p-3 bold'>Secure Contain Protect</h2>
            </div>
            <a class="create-btn" href='create.php'>+</a> 
        </div>
       
        <?php
            // sends query to return all data from database and stores it in each?
            $query = $connection->query("SELECT * FROM SCP");
            $scp_records = $query->fetch_all(MYSQLI_ASSOC); // turns query result into an array
            $card_classes = ['card-a','card-b','card-c','card-d','card-e','card-f','card-g','card-h','card-i','card-j'];
        ?>
        
        <!--start for cards on home page-->
        <div class='card-wrapper'>            
            <div class='flex-container'>                
                <!--iterates through database-->
                <?php for ($i = 0; $i < count($scp_records); $i++): 
                    $scp = $scp_records[$i];
                    $card_class = $card_classes[$i];
                ?>
                
                <a href="read.php?link=<?php echo $scp['scp_number']; ?>" class="text-decoration-none">
                    <div class="cards <?php echo $card_class; ?>" style="background-image: url('<?php echo $scp['image']; ?>');">
                        <div class="card-overlay-text p-2 text-white">
                            <h4><?php echo $scp['scp_number']; ?></h4>
                            <p><?php echo $scp['classification']; ?></p>
                        </div>
                    </div>
                </a>
                    
                <?php endfor; ?>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script>
          // Select all Bootstrap alerts on the page
          const alertElements = document.querySelectorAll('.alert');
        
          alertElements.forEach(alertEl => {
            // Wait 3 seconds, then remove 'show' class to trigger fade out
            setTimeout(() => {
              alertEl.classList.remove('show');
            }, 3000);
          });
        </script>
    </body>
</html>
