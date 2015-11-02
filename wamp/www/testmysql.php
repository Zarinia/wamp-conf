<?php
/**
 * Using "mysqli" instead of "mysql" that is obsolete.
 * Utilisation de "mysqli" à la place de "mysql" qui est obsolète.
 * Change the value of parameter 3 if you have set a password on the root userid
 * Changer la valeur du 3e paramètre si vous avez mis un mot de passe à root
 */
$mysqli = new mysqli('127.0.0.1', 'root', '');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
echo 'Connection OK';
$mysqli->close();
?>