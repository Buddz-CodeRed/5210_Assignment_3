<!doctype html>
<html>
    <head>
        <title>Update Record</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/read.css">
    
        <style>
        
        .btn {
            
            color: #ffffff;
            box-shadow: 
                0 0 10px rgba(192, 0, 255, 1),      /* bright core glow */
                0 0 20px 5px rgba(192, 0, 255, 0.8), /* mid glow */
                0 0 30px 15px rgba(192, 0, 255, 0.5); /* soft outer glow */
            transition: box-shadow 0.3s ease-in-out;

        }
        
        .glass-card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(17, 25, 40, 0.75);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .card {
            height: auto
        }
        
        </style>
    
    </head>
    <body class='container bg_image'>
        <?php
        include "connection.php";
        
        // Initialize variables
        $row = [];
        $success = false;
        $errorMessage = "";
        
        // Load record from DB if coming from index via GET
        if (isset($_GET['update']) && is_numeric($_GET['update'])) {
            $id = (int)$_GET['update'];
            
            $recordID = $connection->prepare("SELECT * FROM SCP WHERE id = ?");
            $recordID->bind_param("i", $id);
        
            if ($recordID->execute()) {
                $result = $recordID->get_result();
                $row = $result->fetch_assoc();
            } else {
                $errorMessage = "Error fetching record: " . $recordID->error;
            }
        }
        
        // Handle form submission
        if (isset($_POST['update'])) {
            $update = $connection->prepare("UPDATE SCP SET scp_number = ?, classification = ?, containment_procedure = ?, description = ?, image = ? WHERE id = ?");
            
            if (!$update) {
                $errorMessage = "Error preparing UPDATE: " . $connection->error;
            } else {
                $update->bind_param(
                    "sssssi",
                    $_POST['scp_number'],
                    $_POST['classification'],
                    $_POST['containment_procedure'],
                    $_POST['description'],
                    $_POST['image'],
                    $_POST['id']
                );
        
                if ($update->execute()) {
                    $success = true;
                    $row = $_POST; // To refill the form with the updated data
                } else {
                    $errorMessage = "Update failed: " . $update->error;
                }
            }
        }
        ?>

        <!-- Success/Error Alert: Place FIRST inside <body> -->
        <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show position-fixed w-50 mx-auto text-center" role="alert" style="top: 30px; left: 0; right: 0; z-index: 9999; pointer-events: auto;">
            Record updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php elseif (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show position-fixed w-50 mx-auto text-center" role="alert" style="top: 30px; left: 0; right: 0; z-index: 9999; pointer-events: auto;">
            <?php echo htmlspecialchars($errorMessage); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class='container min-vh-100 d-flex justify-content-center align-items-center'>
            <div class="card glass-card bg-transparent text-white shadow-lg p-4" style="max-width: 600px; width: 100%; border-radius: 20px;">
                <a href="index.php" class="btn mb-3 w-100">
                    ← Back to index page
                </a>
                <div class="container-md">
                    <h1 class='pb-4 text-center'>Update Record</h1>
                    <form method="post" action="update.php?update=<?php echo $_GET['update'] ?? ''; ?>">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">
                        <div class="mb-3">
                            <label class='form-label'>SCP Number</label>
                            <input type="text" name="scp_number" class='form-control' value="<?php echo $row['scp_number'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class='form-label'>Classification</label>
                            <input type="text" name="classification" class='form-control' value="<?php echo $row['classification'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class='form-label'>Special Containment Procedure</label>
                            <textarea name="containment_procedure" class='form-control'><?php echo $row['containment_procedure'] ?? ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class='form-label'>Description</label>
                            <textarea name="description"  class='form-control'><?php echo $row['description'] ?? ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class='form-label'>Image</label>
                            <input type='text' name='image' class='form-control' value='<?php echo $row['image'] ?? ''; ?>'>
                        </div>
                        <div class='d-flex justify-content-center'>
                            <input type='submit' class='btn w-100' name='update' value='Update Record'>
                        </div>
                    </form>
                </div>
            </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        </div>
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
