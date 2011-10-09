<?php session_start(); ?>
<html>
    <head>
        <title>CMS</title>
    </head>

    <body>
        <div id="logobar">
            <div id="logoblob">
                <h1>Comic Book Appreciation</h1>
            </div>
            <?php
                if(isset($_SESSION['name'])){
                    echo ' <div id="logowelcome">';
                    echo ' Currently logged in as : ' . $_SESSION['name'];
                    echo ' </div> ';
                }
            ?>
        </div>
        <div id ='navright'>
            <form method='get' action='search.php'>
                <p class='head'>Search</p>
                <p>
                    <input id='searchkeywords' type='text' name='keywords'
                    <?php
                        if(isset($_GET['keywords'])){
                            echo ' value=" ' .htmlspecialchars($_GET['keywords']) . '" ';
                        }
                    ?>
                    />
                    <input id='searchbutton' class='submit' type='submit' value='Search'/>
                </p>
            </form>
        </div>
        
        <div id='maincolumn'>
            <div id='navigation'>
                <?php
                    echo '<a href="index.php">Articles</a>';
                    if(!isset($_SESSION['user_id'])){
                        echo ' | <a href="login.php">Login</a> ';
                    }
                    else{
                        echo ' | <a href="compose.php">Compose Article</a>';
                        if($_SESSION['access_lvl'] > 1){
                            echo ' | <a href="pending.php">Review</a>';
                        }
                        if($_SESSION['access_lvl'] > 2){
                            echo ' | <a href="admin.php">Admin</a>';
                        }
                        echo ' | <a href="cpanel.php">Control Panel</a>';
                        echo ' | <a href="transact-user.php?action=Logout">Logout</a>';
                    }
                ?>
            </div>
            <div id="articles">

