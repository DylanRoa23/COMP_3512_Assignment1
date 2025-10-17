<?php

// Get users
$users = UserControl::getAllUsers();

// For every user, display a user entry.
foreach ($users as $user) { ?>
    <div class='user'>
        <p><?= $user['firstname'] . ", " . $user['lastname']; ?></p>
        <a class='viewButton' href='portfolio.php?ref=<?= $user['id']; ?>'>Portfolio</a>
    </div>
<?php }

?>