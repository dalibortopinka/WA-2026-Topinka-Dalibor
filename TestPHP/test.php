<?php
$name = "";
$message = "";
$age = 0;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["my_name"];
    if($name == "Dalibor"){
        $message = " Ahoj Dalibore";
        $age = $_POST["my_age"];
     } else {
            $message = " Neznám tě"; 
     }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test formuláře</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi nisi expedita fugit ut aperiam itaque numquam ratione incidunt corrupti saepe ab sunt officiis voluptates ea ex provident minima, natus vitae!</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusantium eaque facere a maiores laboriosam recusandae fugiat! Sed, consectetur ducimus, quasi officiis sint placeat aspernatur ab illo doloremque cupiditate autem.</p>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolores, placeat! Vitae eos, magni aspernatur dolor ullam aliquam commodi quis rerum id delectus, minima qui quisquam quo maxime sed, fugiat pariatur?</p>
    <form method="post">
        <input type="text" name="my_name" placeholder="Zadejte jméno">
        <input type="number" name="my_age" placeholder="Zadejte věk"> 
        <button type="submit">Odeslat</button>
    </form>

<p>
    <?php 
        echo "Výstup: "; 
        echo $message 
    ?>
</p>

<p>
    <?php 
        echo "Tvůj věk: "; 
        echo $age 
    ?>
</p>



</body>
</html>