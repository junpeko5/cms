<?php
ob_start();
require_once dirname(__DIR__) . "/../vendor/autoload.php";
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load(__DIR__ . '/../..');
$s3_bucket = getenv('S3_BUCKET');
include_once(dirname(__FILE__) . "/../../includes/db.php");
include_once(dirname(__FILE__) . "/../functions.php");
session_start();
if (!isset($_SESSION['user_role'])) {
    redirect("/cms/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Bootstrap Admin Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="/cms/admin/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/cms/admin/css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/cms/admin/css/styles.css" rel="stylesheet">

    <script src="/cms/admin/js/jquery.js"></script>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>
<body>