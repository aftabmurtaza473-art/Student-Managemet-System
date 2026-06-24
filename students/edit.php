<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db = getDB();
$id = (int)($_GET['id'] ?? 0);
$student = $db->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();

if (!$student) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id  = trim($_POST['student_id']);
    $full_name   = trim($_POST['full_name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $department  = trim($_POST['department']);
    $semester    = (int)$_POST['semester'];
    $status      = $_POST['status'];
    $enrolled_at = $_POST['enrolled_at'];

    $stmt = $db->prepare(
        "UPDATE students SET student_id=?, full_name=?, email=?, phone=?, department=?, semester=?, status=?, enrolled_at=?
         WHERE id=?"
    );
    $stmt->bind_param("sssssissi", $student_id, $full_name, $email, $phone, $department, $semester, $status, $enrolled_at, $id);
    if ($stmt->execute()) {
        header("Location: index.php?success=updated");
        exit();
    } else {
        $error = "Could not update student. Student ID or Email may already exist.";
    }
}
$db->close();

$pageTitle  = 'Edit Student';
$activePage = 'students';
include '../includes/header.php';
$d = $_POST ?: $student; // use POST on error, else DB data
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-edit" style="color:var(--warning);margin-right:8px;"></i>Edit Student</h1>
        <p>Update information for <?= htmlspecialchars($student['full_name']) ?></p>
    </div>
    <a href="index.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<?php if($error): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h2>Student Information</h2></div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="form-grid">
                <div class="form-group">
                    <label>Student ID *</label>
                    <input type="text" name="student_id" class="form-control" value="<?= htmlspecialchars($d['student_id']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($d['full_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($d['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($d['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select name="department" class="form-control">
                        <option value="">Select Department</option>
                        <?php foreach(['Software Engineering','Computer Science','Information Technology'] as $dept): ?>
                        <option value="<?=$dept?>" <?= $d['department']===$dept?'selected':'' ?>><?=$dept?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Current Semester</label>
                    <select name="semester" class="form-control">
                        <?php for($i=1;$i<=8;$i++): ?>
                        <option value="<?=$i?>" <?= $d['semester']==$i?'selected':'' ?>>Semester <?=$i?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <?php foreach(['Active','Inactive','Graduated'] as $s): ?>
                        <option value="<?=$s?>" <?= $d['status']===$s?'selected':'' ?>><?=$s?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Enrollment Date</label>
                    <input type="date" name="enrolled_at" class="form-control" value="<?= $d['enrolled_at'] ?>">
                </div>
            </div>
            <div style="margin-top:24px; display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Student</button>
                <a href="index.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
