<?php 
    // Check if data is comming or not
    if( isset($_POST['file_submit_btn'])  ){
        //echo 'yes';
        //echo '<pre>';
        //var_dump($_POST);
        //echo '</pre>';

        echo '<pre>';
        var_dump($_FILES['photo']);
        echo '</pre>';
        
        //1. DB connection Open
        $conn = mysqli_connect('localhost','root','','ecom4_db') or die('Could not connect');

        //Alway filter/Sanitize the incomming data
        $name = mysqli_real_escape_string($conn,$_POST['fullname']);

        $photo_name = mysqli_real_escape_string($conn,$_FILES['photo']['name']);

        $photo_name = rand(10,1000000).$photo_name; // To give the filename unique

        // Please Move from Temprory Location to Uploads directory
        //Source = temprory location
        //$_FILES['photo']['tmp_name']
        $source = $_FILES['photo']['tmp_name'];
        //destination = Permanent Location  i.e uploads
        $destination = './uploads/'.$photo_name;
        move_uploaded_file($source,$destination);

        //2. Build the query
        $sql =  " INSERT INTO users_tbl(`name`,`photo`)VALUES('$name','$photo_name') ";

        //3. Execute the query
        mysqli_query($conn,$sql) or die(mysqli_error($conn));

        //4.Display the result
        echo 'File uploaded Successfully';


        //5. DB Connectin Close
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</head>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="w-50 offset-3">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="fullname" class="form-control" id="name" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" id="photo">
        </div>
        <button type="submit" name="file_submit_btn" class="btn btn-primary">Submit</button>
    </form>

</body>

</html>