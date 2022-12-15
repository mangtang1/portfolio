<!DOCTYPE html>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/css/fonts.php"); ?>

<html lang='kor'>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="icon" href="/imgs/logo.png" > <!-- 브라우저 아이콘 -->
	<meta property="og:image" content="/imgs/logo.png"> <!-- 링크 이미지 -->
	<meta property="og:title" content="맹트코인"> <!-- 링크 타이틀 -->
	<meta property="og:description" content="교육용 암호화폐"> <!-- 링크 세부정보 -->
	<title>맹트코인 </title> <!-- 브라우저 타이틀 -->
	<!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/default.css?15">
	<link rel="stylesheet" href="/css/sidebar.css?50">
	<link rel="stylesheet" href="/css/content.css?29">
	<link rel="stylesheet" href="/css/block.css?4">
	<link rel="stylesheet" href="/css/modal.css?9">
	<link rel="stylesheet" href="/css/wallet.css?53">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
	integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />	   
	<!-- Bootstrap JS -->
	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	        <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="/js/default.js?1"></script>
	<script src="/js/modal.js?1"></script>
    <script src="/js/submit.js?20"></script>


	 <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


</head>
<?php
 if(!session_id())
 {
	 session_start();
 }
?>
