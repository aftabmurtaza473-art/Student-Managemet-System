<?php
// ============================================================
//  Dashboard
// ============================================================
session_start();
define('BASE_URL', './');
require_once 'includes/config.php';
require_once 'includes/auth_check.php';

$db = getDB();

$totalStudents  = $db->query("SELECT COUNT(*) AS c FROM students")->fetch_assoc()['c'];
$activeStudents = $db->query("SELECT COUNT(*) AS c FROM students WHERE status='Active'")->fetch_assoc()['c'];
$totalCourses   = $db->query("SELECT COUNT(*) AS c FROM courses")->fetch_assoc()['c'];
$totalGrades    = $db->query("SELECT COUNT(*) AS c FROM grades")->fetch_assoc()['c'];

$recentStudents = $db->query(
    "SELECT student_id, full_name, department, semester, status, enrolled_at
     FROM students ORDER BY created_at DESC LIMIT 5"
);

$topGrades = $db->query(
    "SELECT s.full_name, c.course_name, g.marks, g.grade
     FROM grades g
     JOIN students s ON g.student_id = s.id
     JOIN courses c  ON g.course_id  = c.id
     ORDER BY g.marks DESC LIMIT 5"
);

$db->close();

$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
include 'includes/header.php';
?>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-info">
            <div class="value"><?= $totalStudents ?></div>
            <div class="label">Total Students</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <div class="value"><?= $activeStudents ?></div>
            <div class="label">Active Students</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-book-open"></i></div>
        <div class="stat-info">
            <div class="value"><?= $totalCourses ?></div>
            <div class="label">Total Courses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-star"></i></div>
        <div class="stat-info">
            <div class="value"><?= $totalGrades ?></div>
            <div class="label">Grade Records</div>
        </div>
    </div>
</div>

<!-- Two column layout -->
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; flex-wrap:wrap;">

    <!-- Recent Students -->
    <div class="card" style="min-width:0;">
        <div class="card-header">
            <h2><i class="fas fa-user-graduate" style="color:var(--accent);margin-right:8px;"></i>Recent Students</h2>
            <a href="students/index.php" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Dept</th>
                        <th>Sem</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $recentStudents->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['full_name']) ?></strong><br>
                            <small style="color:var(--text-muted);"><?= htmlspecialchars($row['student_id']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= $row['semester'] ?></td>
                        <td>
                            <?php
                            $s = $row['status'];
                            $c = $s==='Active'?'success':($s==='Graduated'?'info':'warning');
                            ?>
                            <span class="badge badge-<?=$c?>"><?=$s?></span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Grades -->
    <div class="card" style="min-width:0;">
        <div class="card-header">
            <h2><i class="fas fa-trophy" style="color:var(--warning);margin-right:8px;"></i>Top Performers</h2>
            <a href="grades/index.php" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $topGrades->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td style="font-size:12px;"><?= htmlspecialchars($row['course_name']) ?></td>
                        <td><strong><?= $row['marks'] ?></strong></td>
                        <td><span class="badge badge-success"><?= $row['grade'] ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
