<?php
include($deep.'session.php');

session_unset();

header('Location: index.php');
exit();
?>
