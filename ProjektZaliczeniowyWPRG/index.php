<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons (Optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB CSS (Optional, if using MDBootstrap) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet">
    <link href="../assets/postTileStyle.css" rel="stylesheet">
    <style>
        body {
        }

        .content {
            display: flex;
            flex-direction: row-reverse;
            justify-items: center;
            justify-content: center;
            flex-flow: column wrap;
        }

    </style>
</head>
<body>
<div class="content">
    <?php
    session_start();
    include 'includes/functions.php';
    include 'includes/db.php';
    $_SESSION['limit'] = 5;

    //Ustawienie zmiennej sesyjnej total_pages - ustawiamy na podstawie select count(*) from...
    //dzielimy wynik query przez LIMIT;
    //dodatkowe obsłużenie modulo. <- musimy obsłużyć również reszty. czyli jeżeli reszta z dzielenia przez 5!=0 to jest jeszcze jedna strona.
    //Czyli total_pages + 1

    //213 210 -> 5 / 3 ->>>

    if (!isset($_SESSION['offset'])) {
        $_SESSION['offset'] = 0;
    }
    if (!isset($_SESSION['actualPage'])) {
        $_SESSION['actualPage'] = 1;
    }
    if (array_key_exists('next', $_POST)) {
        nextPage();
    } else if (array_key_exists('previous', $_POST)) {
        previousPage();
    }

    //Tutaj wyrenderować template navbar.html z podaniem warunku
    //Warunek if(user_role != author){ false } else { true }
    function nextPage()
    {

        $_SESSION['offset'] = $_SESSION['offset'] + 5;
        $_SESSION['actualPage']++;
        return $_SESSION['actualPage'];
    }

    function previousPage()
    {
        if ($_SESSION['actualPage'] > 1) {
            if ($_SESSION['offset'] > 0) {
                $_SESSION['offset'] = $_SESSION['offset'] - 5;
            }

            $_SESSION['actualPage']--;
        }
        return $_SESSION['actualPage'];
    }

    $stmt = mysqli->prepare('SELECT * FROM posts ORDER BY creation_date DESC LIMIT ? OFFSET ?');
    $stmt->bind_param("ii", $_SESSION['limit'], $_SESSION['offset']);
    $stmt->execute();
    $posts = $stmt->get_result();

    foreach ($posts as $post) {
        echo render_template('templates/post_tile.html', $post);

    }

    ?>
    <form method="post">
        <input type="submit" name="previous"
               class="btn btn-secondary" value="Previous"/>
        <input type="submit" name="next"
               class="btn btn-primary" value="Next"/>
    </form>


    <p>Aktualna strona: <?php echo $_SESSION['actualPage']; ?></p>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
