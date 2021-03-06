<?php

$start = microtime(true);

require('conf.php');
require('inc/header.php');

if (!ctype_alnum($_GET['id']) || (strlen($_GET['id']) !== 5))
{
	$error = 'Oops, that ID appears to be invalid. IDs should have 5 characters and contain letters and numbers only.';
	require('inc/error.php');
	require('inc/footer.php');
	exit;
}

require('db.php');

$image_query = mysqli_query($db, 'SELECT `ext` FROM `images` WHERE `id` = "' . $_GET['id'] . '"');
++$db_queries;

if (mysqli_num_rows($image_query) === 0)
{
	$error = 'Hmm, no image exists with that ID. Maybe it was deleted or you typed in the URL incorrectly? IDs should have 5 characters and contain letters and numbers only.';
	require('inc/error.php');
	require('inc/footer.php');
	exit;
}

$image = mysqli_fetch_assoc($image_query);

mysqli_free_result($image_query);

$dimensions = getimagesize('images/' . $_GET['id'] . '.' . $image['ext']);
$size = (filesize('images/' . $_GET['id'] . '.' . $image['ext']) / 1024);

require('common.php');
require('inc/view.php');
require('inc/footer.php');

