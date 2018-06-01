<html>
    <head>
        <title>Welcome</title>
    </head>
    <body>
    <ul>

        <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
    </body>
</html>