<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title><?php if(isset($title)) echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/bootstrap/css/bootstrap-theme.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/pickadate/themes/default.css'); ?>" id="theme_base">
    <link rel="stylesheet" href="<?php echo base_url('/assets/pickadate/themes/default.date.css'); ?>" id="theme_date">
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/ladda-themeless.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap3-editable/css/bootstrap-editable.css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/bootstrap/css/bootstrap-custom.css'); ?>">
<?php 
if (isset($cssFile)) {
    foreach ($cssFile as $f) { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/$f"); ?>.css">
<?php  
    }
}
?>
</head>
<body>
    