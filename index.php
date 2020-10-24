<html>
    <head>
        <title>Home</title>
        <meta charset="utf-8" name="viewport"
        content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/style.css?<?php echo time(); ?>" />
    </head>
    <body>
        <header>

            <h2>PolySnake <em>V0.01</em></h2>
        
            <form action="login.php" method="post">
                <p>Nickname: <input type="text" name="nickname"
                placeholder="dudule" required autofocus></p>
                <input class="formButton" type="submit" value="Log in">
            </form>
        </header>
    </body>
</html>