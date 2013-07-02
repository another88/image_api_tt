<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/css/bootstrap.css">
    </head>
    <body>
    <div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="/">Simple image api</a>
        <ul class="nav">
            <li <?php if($active == 'index'): ?>class="active"<?php endif; ?> >
            <a href="/">Add</a></li>
            <li <?php if($active == 'browse'): ?>class="active"<?php endif; ?> >
            <a href="/browse">Browse images</a></li>
        </ul>
    </div>
    </div>
    <div id="content">
        <?php echo $content; ?>
    </div>
    </body>
</html>
