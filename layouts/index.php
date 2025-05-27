<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$Title ?></title>

    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/base.css">
</head>
<body>
    <header class="header sticky-top">
        <div class="header-container d-flex">
            <navbar class="header-nav pt-4">
                <ul class="header-list d-flex">
                    <li>
                        <a href="/" class="nav-a m-3">home</a>
                    </li>
                    <li>
                        <a href="#" class="nav-a m-3">shop</a>
                    </li>
                </ul>
            </navbar>
            <div class="header-logo">
                <a href="/"><img src="/static/img/qwewwq.png" alt="" class="heavy-logo"></a>
            </div>
            <div class="header-profile">
                <a href="#" class="header-list m-3">login</a>
            </div>
        </div>
    </header>

    <main>
        <div class="container"><?=$Content ?></div>


        <img src="/static/img/frame1.png" class="frame1" alt="">
        <img src="/static/img/frame2.png" class="frame2" alt="">
        <img src="/static/img/frame3.png" class="frame3" alt="">
        <img src="/static/img/frame4.png" class="frame4" alt="">
    </main>

    <footer>
    </footer>

    <script src="/static/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
