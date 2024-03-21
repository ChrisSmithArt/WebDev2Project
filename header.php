<?php
// if(isset($_SESSION['userID'])){
//     $query = "SELECT * FROM users ORDER BY ID";
//     $statement = $db->prepare($query);
//     $statement->execute(); 
// }

?>

<header>
    <h1>Character Database</h1>
</header>
<nav>
    <ul>
        <li><a href="index.php">Main</a></li>
        <li><a href="content.php">Characters</a></li>
        <?php if($_SESSION && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'])): ?>
            <li><a href="logout.php">Log Out</a></li> 
            <li><a href="create.php">New NPC</a></li>
            <?php if(isset($_SESSION['Admin']) && ($_SESSION['Admin'])): ?>
                <li><a href="admin.php">Admin Access</a></li>
            <?php endif ?>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif ?>

    </ul>
        <!-- <h3>
            <?php if(isset($_SESSION['userID'])):?>
                <?php while($row = $statement->fetch()):?>
                    <?php if($row['ID'] === $_SESSION['userID']): ?>
                        User: <?= $row['Name']?> 
                    <?php endif ?>
                <?php endwhile ?>
            <?php else: ?>
                Not Logged In
            <?php endif ?>
        </h3> -->
</nav>