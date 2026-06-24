<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db = getDB();
$courses = $db->query("SELECT * FROM courses ORDER BY created_at DESC");
$total   = $db->query("SELECT COUNT(*) AS c FROM courses")->fetch_assoc()['c'];
$db->close();

$pageTitle  = 'Courses';
$activePage = 'courses';
include '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-book-open" style="color:var(--accent);margin-right:8px;"></i>Courses</h1>
        <p>Manage all course records</p>
    </div>
    <a href="add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Course</a>
</div>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i>
    <?= $_GET['success']==='added'?'Course added successfully!':($_GET['success']==='updated'?'Course updated!':'Course deleted.') ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>All Courses (<span id="rowCount"><?= $total ?></span>)</h2>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="tableSearch" placeholder="Search courses...">
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credit Hours</th>
                    <th>Department</th>
                    <th>Instructor</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row = $courses->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><strong><?= htmlspecialchars($row['course_code']) ?></strong></td>
                    <td><?= htmlspecialchars($row['course_name']) ?></td>
                    <td style="text-align:center;"><?= $row['credit_hours'] ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['instructor'] ?? '—') ?></td>
                    <td style="text-align:center;"><?= $row['semester'] ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="edit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete('delete.php?id=<?=$row['id']?>', '<?=htmlspecialchars($row['course_name'])?>')"
                                    class="btn btn-danger btn-sm btn-icon" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($total===0): ?>
                <tr><td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>No courses yet</h3>
                        <p><a href="add.php" class="btn btn-primary" style="margin-top:12px;"><i class="fas fa-plus"></i> Add First Course</a></p>
                    </div>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
