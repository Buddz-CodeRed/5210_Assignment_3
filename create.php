<!doctype html>
<html>
    <head>
        <title>Add New Record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/styles.css">
        
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
        
            include "connection.php";
            
            if(isset($_POST['create']))
            {
                // prepare sql query to insert new data to the table
                $insert = $connection->prepare("insert into SCP(scp_number, classification, containment_procedure, description, image) values(?,?,?,?,?)");
                $insert->bind_param("sssss", $_POST['scp_number'], $_POST['classification'], $_POST['containment_procedure'], $_POST['description'], $_POST['image']);
                
                if($insert->execute()) // send insert statement to database for execution
                {
                    echo "
                        <p class='alert alert-success fade show alert-dismissible position-fixed bottom-0 start-50 translate-middle-x w-50 p-3' role='alert' style='z-index: 1055;'>Record Successfully Created</p>
                    ";
                }
                else
                {
                    echo "
                    <p class='alert alert-danger p-3>Error: {$insert->error}</p>
                    ";
                }
            }
        ?>
        
            
            
        <div class="container min-vh-100 d-flex justify-content-center align-items-center">
            <div class="card glass-card bg-transparent text-white shadow-lg p-4" style="max-width: 600px; width: 100%; border-radius: 20px;">
                <a href="index.php" class="btn mb-3">
                    ← Back to index page
                </a>
                <div class="container-md">
                    <h1 class="pb-4 text-center">Add New Records</h1>
                    <form method="post" action="create.php">
                        <label class="form-label">SCP Number</label>
                        <input type="text" class="form-control mb-3" name="scp_number" placeholder="Enter SCP Number" required>
        
                        <label class="form-label">Classification</label>
                        <input type="text" class="form-control mb-3" name="classification" placeholder="Enter Classification">
        
                        <label class="form-label">Special Containment Procedures</label>
                        <textarea name="containment_procedure" class="form-control mb-3" placeholder="Enter Procedures"></textarea>
        
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control mb-3" placeholder="Enter Description"></textarea>
        
                        <label class="form-label">Image</label>
                        <input type="text" name="image" class="form-control mb-4" placeholder="Add Image URL">
        
                        <input type="submit" class="btn w-100" name="create" value="Create New Record">
                    </form>
                </div>
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