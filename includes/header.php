<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Student Management System' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="logo-text">
            <span class="logo-title">EduManager</span>
            <span class="logo-sub">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>index.php"
           class="nav-item <?= ($activePage === 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i><span>Dashboard</span>
        </a>
        <div class="nav-section-label">ACADEMICS</div>
        <a href="<?= BASE_URL ?>students/index.php"
           class="nav-item <?= ($activePage === 'students') ? 'active' : '' ?>">
            <i class="fas fa-user-graduate"></i><span>Students</span>
        </a>
        <a href="<?= BASE_URL ?>courses/index.php"
           class="nav-item <?= ($activePage === 'courses') ? 'active' : '' ?>">
            <i class="fas fa-book-open"></i><span>Courses</span>
        </a>
        <a href="<?= BASE_URL ?>grades/index.php"
           class="nav-item <?= ($activePage === 'grades') ? 'active' : '' ?>">
            <i class="fas fa-star"></i><span>Grades</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>auth/logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </a>
    </div>
</div>

<!-- Main Content Wrapper -->
<div class="main-wrapper">
    <!-- Top Bar -->
    <header class="topbar">
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></div>
        <div class="topbar-right">
            <div class="admin-badge">
                <i class="fas fa-user-shield"></i>
                <span><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
            </div>
        </div>
    </header>

    <main class="content">
