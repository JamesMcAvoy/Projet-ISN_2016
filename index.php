<?php
session_start();

echo '<p style="color:#000;font-size:20px"><a href="/minichat.txt">to do + infos</a>(je nutilise pas Github)<br /></p>';

if(!isset($_SESSION['on']))
	require './inc/connexion.php';
else {
	echo 'se déconnecter : <a href="./session/logout.php?token='.$_SESSION['token'].'">clic</a><br />';
	echo 'liste connectés : <br />' . file_get_contents('./data/connected.json');
}