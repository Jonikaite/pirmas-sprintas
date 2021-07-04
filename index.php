<?php
session_start();

if(!$_SESSION['logged_in']) {
    header('Location: login.php');
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

<?php 
$path = './' . $_GET['path'];
$dirContent = scandir($path);
print('<h2>Directory contents: ' . $path . '</h2>');
?>
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
                foreach($dirContent as $pieceOfContent){
                    print('<tr>');
                    print('<td>' . (is_dir($pieceOfContent) ? "Dir" : "File") . '</td>');
                    print('<td>' . (is_dir($path . '/' . $pieceOfContent) ? '<a href="?path=' . $pieceOfContent . '">' . $pieceOfContent . '</a></td>' : $pieceOfContent));
                    print('<td>' 
                    . (!is_dir($path . $pieceOfContent) ? 
                    '<form style="display: inline-block" action="" method="POST">
                    <input  type="hidden" name="delete" value=' . $pieceOfContent . '>
                    <button id="delete" type="submit">Delete</button>
                    </form>
                    <form style="display: inline-block" action="" method="POST">
                    <input type="hidden" name="download" value=' . $pieceOfContent . '>
                    <button id="download" type="submit">Download</button>
                   </form>'
                    : '' 
                    . '</td>'));
                    print('</tr>');
                }

//delete
if (isset($_POST['delete'])) {
    unlink('./' . $_GET['path'] . $_POST['delete']);
    header("Refresh:0.1");
}


//download

if(isset($_POST['download'])){
    // print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
    $file='./' . $_GET["path"] . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf'); 
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped));
    ob_end_flush();
    readfile($fileToDownloadEscaped);
    exit;
}
?>

            </tbody>
        </table>
    </div>
<div>
<!-- <INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);"> -->
</div>
    <div style="margin-top: 30px; margin-bottom: 30px ">
    <input style="margin-bottom: 20px; display: block; width: 256px; text-decoration-line: underline;" type="button"value="Back" onClick="history.go(-1);">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="img" id="img" style="display:none;" />
            <button style="display: block; width: 256px" type="button">
                <label for="img" style="display: block; width: 100%">Choose file</label>
            </button>
            <button style="display: block; width: 256px" type="submit">Upload file</button>
            </form>
    </div>
    <?php 

// Upload
if (isset($_FILES['img'])) {
    $errors = array();
    $file_name = $_FILES['img']['name'];
    $file_size = $_FILES['img']['size'];
    $file_tmp = $_FILES['img']['tmp_name'];
    $file_type = $_FILES['img']['type'];

    $file_ext = strtolower(end(explode('.', $_FILES['img']['name'])));
    $extensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }
    if ($file_size > 2097152) {
        $errors[] = 'File size must be smaller than 2 MB';
    }
    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, './' . $path . './' . $file_name);
        echo "Succes";
        header("Refresh:0.1");
    } else {
        print_r($errors);
    }
}
?>


    <!-- new directory -->
    <div>
        <form method="POST" style="width: 260px">
            <input type="text" id="create" name="create" placeholder="Name of new directory" />
            <button type="submit" value="create">Submit</button>
        </form>
    </div>


<?php
    function create()
    {
        if (isset($_POST['create'])) {
            if ($_POST['create'] === "") {
                echo "Folder name can't be emty string!";
            }
            if ($_POST['create'] != "") {
                $dirCreate = './' . $_GET['path'] . $_POST['create'];
                if (!is_dir($dirCreate)) {
                    mkdir($dirCreate);
                    echo 'Success! Folder created.';
                    header("Refresh:0.1");
                }
                if (is_dir($dirCreate)) {
                    echo "Folder already exist!";
                }
            }
        }
    }
    create();
?>

<!-- logout -->
<div>
Click here to <a href="login.php?action=logout"> logout.
</div>


</body>
</html>   
   
    
    