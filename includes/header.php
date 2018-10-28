<?php
session_start();
require_once dirname(__DIR__) . "/vendor/autoload.php";
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load(__DIR__ . '/..');
$s3_bucket = getenv('S3_BUCKET');
echo $s3_bucket;
exit;
include(dirname(__FILE__) . "/db.php");
include(dirname(__FILE__) . '/../admin/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog Home - Start Bootstrap Template</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="/cms/admin/css/bootstrap.css">
    <!-- Custom CSS -->
    <link href="css/styles.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>