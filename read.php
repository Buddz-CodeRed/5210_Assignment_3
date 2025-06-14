<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SCP CRUD Application</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/read.css">
    </head>
    <body class='bg_image text-white'>
        
        <?php include "connection.php"?>
        
        <?php
            $query = $connection->query("SELECT scp_number FROM SCP");
            $result = $query->fetch_all(MYSQLI_ASSOC);
        ?>
        
        <!--Navigation Bar-->
        <nav class="navbar navbar-dark">
            <div class="nav-logo-heading">
                
                    <!-- Navbar Brand -->
	            <div class="topside-wrapper gap-3">
                    <img src="./images/logo-Photoroom.png" class="logo" alt="Logo Image">
                    <h2 class="top-heading">Secure Contain Protect</h2>

                    <!-- Navbar Toggler -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            
                <!-- Offcanvas Menu -->
                <div class="offcanvas offcanvas-end text-white bg-dark d-flex offcanvas-bg" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">SCP Subjects</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="navbar-nav justify-content-center flex-grow-1 p-3 fw-semibold">
                            <span class='nav-item'>
                                <a class="nav-link" href='index.php'>Home</a> <!-- Link to index.php -->
                            </span>
            
                            <?php foreach($result as $link): ?>
                                <span class='nav-item'>
                                    <a class="nav-link" href="read.php?link=<?php echo $link['scp_number']; ?>"><?php echo $link['scp_number']; ?></a>
                                </span>
                            <?php endforeach; ?>
        
                            <span class='nav-item'>
                                <a class="nav-link" href='create.php'>Add New Record</a>    
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        
        <?php
        
            // enable error reporting
            error_reporting(E_ALL);
            // ini_set('display_errors', 1);
            
            // checks if link returns a value
            if (isset($_GET['link']))
            {
                // save GET value as a var | superglobal variable | GET method = retrieves values passed through the url
                $scp_number = $_GET['link'];
                
                // save query to var | connect to the database and execute the query
                $query = $connection->query("select * from SCP where scp_number='$scp_number'");
                
                // checks if a matching record exits | checks if there is more than 1 row in the database
                if($query && $query->num_rows > 0)
                {
                    // retrieves 1 row at a time | saves to a associative array
                    $array = $query->fetch_assoc();
                    $update = 'update.php?update=' . $array['id'];
                    $delete = 'read.php?del=' . $array['id'];
                    $imageSrc = !empty($array['image']) ? $array['image'] : 'default-image.jpg';
                    echo "
                        
                    
                        <div class='container card-container mt-1'>
                            <div class='card-wrapper text-center mt-5'>
                                <h1 id='scp-scpid-{$array['id']}'>{$array['scp_number']}</h1>
                                <h3 id='scp-classification-{$array['id']}'>{$array['classification']}</h3>
                                <p id='scp-procedure-{$array['id']}'>{$array['containment_procedure']}</p>
                                <div class='scp-image-container mb-2'><img id='scp-image-{$array['id']}' class='img-fluid rounded' src='{$array['image']}' alt='{$array['image']}'></div>
                                <p id='scp-description-{$array['id']}'>{$array['description']}</p>
                                <p class='d-flex justify-content-center align-items-center'>
                                    <a class='btn btn-warning admin-btn m-4' href='{$update}'>Update Record</a> || <a class='btn btn-danger m-4' href='{$delete}'>Delete Record</a>
                                </p>
                            </div>
                        </div> ";
                }
                else
                {
                    echo "<p>Error retrieving record</p>";
                }
            }
            else
            {
                // check connection   
                if ($connection->connect_error) 
                {
                    die("Connection failed: " . $connection->connect_error);
                }
            }
            
                        // delete record function
            if (isset($_GET['del'])) {
                $delID = $_GET['del'];
                $delete = $connection->prepare('DELETE FROM SCP WHERE id=?'); // query to delete
                $delete->bind_param('i', $delID);
            
                if ($delete->execute()) {
                    echo "
                        
                        <p class='alert alert-success alert-dismissible fade show position-fixed bottom-0 start-50 translate-middle-x text-center w-50 shadow' role='alert'>
                            Record Successfully Deleted
                        </p>";
                    
                    // Redirect after a delay
                    echo "
                    <script>
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                    </script>";
                    } else {
                    echo "<p class='alert alert-danger'>Error Deleting Record: " . $delete->error . "</p>";
                    }
                }
        
        ?>
        
        
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
