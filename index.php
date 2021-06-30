<?php

$path = './' . $_GET['path'];

if($_SESSION['logged_in'] == true){
    header('Location: login.php');
}

if($_GET['Delete']){
    unlink($path . '/' . $_GET['Delete']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fs Browser PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    <div>
        <table class="table">
            <thead class="table-dark"> 
                <tr> 
                    <td>Type</td> 
                    <td>Name</td> 
                    <td>Actions</td>
                </tr>
            </thead>

            <tbody> 
                <?php  
                $dirContent = scandir($path);
                foreach($dirContent as $pieceOfContent){
                    print('<tr>');
                    print('<td>' . (is_dir($pieceOfContent) ? "Dir" : "File") . '</td>');
                    print('<td>' . (is_dir($path . '/' . $pieceOfContent) ? '<a href="?path=' . $pieceOfContent . '">' . $pieceOfContent . '</a></td>' : $pieceOfContent));
                    print('<td>' . (!is_dir($pieceOfContent) ? '<a href="?delete=' . $pieceOfContent . '">Delete</a>' : '') . '</td>');
                    print('</tr>');
                }

                ?>
            </tbody>
        </table>

    </div>
    <div style="margin-top: 30px; margin-bottom: 30px ">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="img" style="display:none;" />
            <button style="display: block; width: 256px" type="btton">
                <label for="img" style="display: block; width: 100%">Choose file</label>
            </button>
            <button style="display: block; width: 256px" type="submit">Upload file</button>
            </form>
    </div>

    <!-- new directory -->
    <div>
        <form method="POST" style="width: 260px">
            <input type="text" placeholder="Name of new directory" />
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

<!-- logout -->
<div>
Click here to <a href="index.php?action=logout"> logout.
</div>


</body>
</html>   
   
    
    