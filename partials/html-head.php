<?php /* Head */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <?php define( 'SCRIPT_ROOT', 'http://localhost/hci' ); ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?php echo '<link rel="stylesheet" type="text/css" href="'.SCRIPT_ROOT.'/css/base.css">'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="container">            
                <div class="row">
                    <div class="col-sm">
                    <a href="index.php" class="logotype"><img src="<?php echo SCRIPT_ROOT ?>/images/logotype.png" alt=""></a>
                    </div>
                    <div class="col-sm">
                        <ul>
                            <li>
                                <a href="myCourses.php"><i class="fas fa-user"></i> My Courses</a>
                            </li>
                            <li>
                                <a href="myCourses.php" class="inactive"><i class="fas fa-book"></i> My Profile</a>
                            </li>
                        </ul>
                    <!-- <form action="myCourses.php">
                        <input type="submit" value="My Courses" class="">
                    </form> -->
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
        <?php include 'partials/modals.php'; ?>