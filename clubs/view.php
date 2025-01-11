<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?1.0">
    <title>Soccer players form</title>
</head>
<body>
    <form id="form-player" action="../leagues/controller.php" method="POST" enctype="multipart/form-data">
        <label for="name">Soccer player's name</label>
        <input type="text" name="name" id="name" class="input-form"/>

        <label for="age">Age</label>
        <input type="number" name="age" id="age" class="input-form"/>

        <label for="photo">Photo</label>
        <input type="file" name="photos[]" id="photo" multiple/>
        
        <input type="submit" value="Submit"/>
    </form>
</body>
</html>
