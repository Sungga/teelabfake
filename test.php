<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input name="submit" type="submit" value="aaa">
    </form>
</body>
</html>

<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "a";
        if(isset($_POST['submit'])) {
            echo "b";
        }
    }

?>