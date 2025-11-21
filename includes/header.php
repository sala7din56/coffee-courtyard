<?php
/**
 * Coffee CourtYard - Header
 */

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Coffee CourtYard - Your Everyday Escape</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link href="<?php echo BASE_URL; ?>/public/css/dist.css" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 flex items-center justify-center border-b border-solid border-primary/20 bg-background-light/80 px-4 py-3 backdrop-blur-sm dark:bg-background-dark/80 dark:border-primary/20">
        <div class="flex w-full max-w-6xl items-center justify-between whitespace-nowrap">
            <a href="<?php echo BASE_URL; ?>/public/index.php" class="flex items-center gap-3 text-text-primary-light dark:text-text-primary-dark">
                <span class="material-symbols-outlined text-primary text-2xl">local_cafe</span>
                <h2 class="text-lg font-bold tracking-tight">Coffee CourtYard</h2>
            </a>
            <div class="hidden items-center gap-8 md:flex">
                <a class="text-sm font-medium text-text-primary-light transition-colors hover:text-text-accent-light dark:text-text-primary-dark dark:hover:text-text-accent-dark" href="<?php echo BASE_URL; ?>/public/index.php#story">Our Story</a>
                <a class="text-sm font-medium text-text-primary-light transition-colors hover:text-text-accent-light dark:text-text-primary-dark dark:hover:text-text-accent-dark" href="<?php echo BASE_URL; ?>/public/index.php#menu">Menu</a>
                <a class="text-sm font-medium text-text-primary-light transition-colors hover:text-text-accent-light dark:text-text-primary-dark dark:hover:text-text-accent-dark" href="<?php echo BASE_URL; ?>/public/index.php#visit">Visit Us</a>
            </div>
            <a href="<?php echo BASE_URL; ?>/public/order.php" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-text-primary-light text-sm font-bold tracking-wide transition-opacity hover:opacity-90">
                <span class="truncate">Order Online</span>
            </a>
        </div>
    </header>
    <main class="flex flex-1 justify-center py-5">
        <div class="flex w-full max-w-6xl flex-col gap-12 px-4">
