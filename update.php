<!doctype html>
<html>
    <head>
        <title>Update Record</title>
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
        
        </style>
    
    </head>
    <body class='container bg_image'>
        
        <?php
        
            // error reporting
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            
            include "connection.php";
            
            // initialize empty array
            $row = [];
            
            // if directed from index page via edit button
            if(isset($_GET['update']))
            {
                $id = $_GET['update'];
                
                // based on id select appropriate record from db
                $recordID = $connection->prepare("SELECT * FROM SCP WHERE id = ?");
                
                $recordID->bind_param("i", $id);
                
                if($recordID->execute())
                {
                    $temp = $recordID->get_result();
                    $row = $temp->fetch_assoc();
                }
                else
                {
                    echo "
                    
                        <p class='alert alert-danger'>Error: {$recordID->error}</p>
                    ";
                }
            }
            
            // form submission to update
            if (isset($_POST['update'])){
                $update = $connection->prepare("UPDATE SCP SET scp_number = ?,  classification= ?, containment_procedure = ?, description = ?, image = ? WHERE id = ?");            
                // checks if the query works
                if (!$update){
                    echo "<p class='alert alert-danger'>Error preparing UPDATE: {$connection->error}</p>";
                    exit;
                }
                
                $update->bind_param("sssssi",
                $_POST['scp_number'],
                $_POST['classification'],
                $_POST['containment_procedure'],
                $_POST['description'],
                $_POST['image'],
                $_POST['id']
                );
                
                if ($update->execute()) {
                    echo "<p class='alert alert-success fade show alert-dismissible position-fixed bottom-0 start-50 translate-middle-x w-50 p-3' role='alert'>Record update successfully!</p>";
                }
                else {
                    echo "<p class='alert alert-danger'>Update failed: {$update->error}</p>";
                }
                
                // reload updated row
                $row = $_POST;
            }
            
        ?>
        
        
        
        
        <div class='container min-vh-100 d-flex justify-content-center align-items-center'>
            <div class="card glass-card bg-transparent text-white shadow-lg p-4" style="max-width: 600px; width: 100%; border-radius: 20px;">
                <a href="index.php" class="btn mb-3 w-100">
                    ← Back to index page
                </a>
                <h1 class='pb-5 text-center'>Update Record</h1>
                <form method="post" action="update.php?update=<?php echo $_GET['update'] ?? ''; ?>">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>"class='form-group p-3 border rounded shadow'>
                    <label class='form-label'>SCP Number</label>
                    <br>
                    <input type="text" name="scp_number" class='form-control' value="<?php echo $row['scp_number'] ?? ''; ?>"class='form-group p-3 border rounded shadow'>
                    <br>
                    <label class='form-label'>classification</label>
                    <br>
                    <input type="text" name="classification" class='form-control' value="<?php echo $row['classification'] ?? ''; ?>">
                    <br>
                    <label class='form-label'>Special Containment Procedure</label>
                    <br>
                    <textarea name="containment_procedure" class='form-control'><?php echo $row['containment_procedure'] ?? ''; ?></textarea>
                    <br>
                    <label class='form-label'>Description</label>
                    <br>
                    <textarea name="description"  class='form-control'><?php echo $row['description'] ?? ''; ?></textarea>
                    <br>
                    <label class='form-label'>Image</label>
                    <br>
                    <input type='text' name='image' class='form-control' value='<?php echo $row['image'] ?? ''; ?>'>
                    <br>
                    <div class=' d-flex justify-content-center'>
                        <input type='submit' class='btn w-100' name='update' value='Update Record'>
                    </div>
                </form>
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