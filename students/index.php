<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db = getDB();
$students = $db->query(
    "SELECT * FROM students ORDER BY created_at DESC"
);
$total = $db->query("SELECT COUNT(*) AS c FROM students")->fetch_assoc()['c'];
$db->close();

$pageTitle  = 'Students';
$activePage = 'students';
include '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-graduate" style="color:var(--accent);margin-right:8px;"></i>Students</h1>
        <p>Manage all student records</p>
    </div>
    <a href="add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Student</a>
</div>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i>
    <?= $_GET['success']==='added'?'Student added successfully!':($_GET['success']==='updated'?'Student updated successfully!':'Student deleted successfully!') ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>All Students (<span id="rowCount"><?= $total ?></span>)</h2>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="tableSearch" placeholder="Search students...">
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Enrolled</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><strong><?= htmlspecialchars($row['student_id']) ?></strong></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td style="font-size:13px;"><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td style="text-align:center;"><?= $row['semester'] ?></td>
                    <td>
                        <?php
                        $s = $row['status'];
                        $c = $s==='Active'?'success':($s==='Graduated'?'info':'warning');
                        ?>
                        <span class="badge badge-<?=$c?>"><?=$s?></span>
                    </td>
                    <td style="font-size:13px;"><?= $row['enrolled_at'] ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="edit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete('delete.php?id=<?=$row['id']?>', '<?=htmlspecialchars($row['full_name'])?>')"
                                    class="btn btn-danger btn-sm btn-icon" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($total === 0): ?>
                <tr><td colspan="9">
                    <div class="empty-state">
                        <i class="fas fa-user-graduate"></i>
                        <h3>No students yet</h3>
                        <p><a href="add.php" class="btn btn-primary" style="margin-top:12px;"><i class="fas fa-plus"></i> Add First Student</a></p>
                    </div>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
