<?php 

require_once('locklvl.php'); 

$MM_authorizedUsers =usuario(100);

require_once('lock.php'); ?>


<!DOCTYPE html>

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title><?php echo $titulo; ?> </title>
    <link href="../favicon.ico" rel="icon">


<link rel="stylesheet" href="../css/bootstrap.css" >

<!-- <link rel="stylesheet" href="../css/bootstrap.min.css" > -->

<link rel="stylesheet" href="../css/bootstrap-theme.min.css">

 <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
   <!-- Google Fonts -->
   <link href="../assets/fonts/OpenSans.css" rel="stylesheet">

<link rel="stylesheet" href="../css/custom.min.css">

<link rel="stylesheet" type="text/css" href="engine1/style.css" />

  </head>