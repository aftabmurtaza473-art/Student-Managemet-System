<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDB();
    $student_id  = trim($_POST['student_id']);
    $full_name   = trim($_POST['full_name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $department  = trim($_POST['department']);
    $semester    = (int)$_POST['semester'];
    $status      = $_POST['status'];
    $enrolled_at = $_POST['enrolled_at'];

    if (!$student_id || !$full_name || !$email) {
        $error = "Student ID, Full Name, and Email are required.";
    } else {
        $stmt = $db->prepare(
            "INSERT INTO students (student_id, full_name, email, phone, department, semester, status, enrolled_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssssiis", $student_id, $full_name, $email, $phone, $department, $semester, $status, $enrolled_at);
        if ($stmt->execute()) {
            header("Location: index.php?success=added");
            exit();
        } else {
            $error = "Error: Could not add student. Student ID or Email may already exist.";
        }
    }
    $db->close();
}

$pageTitle  = 'Add Student';
$activePage = 'students';
include '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1><i class="fas fa-plus" style="color:var(--accent);margin-right:8px;"></i>Add New Student</h1>
        <p>Fill in the form below to register a new student</p>
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
                    <input type="text" name="student_id" class="form-control" placeholder="e.g. BSSE-2024-003"
                           value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter full name"
                           value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="form-control" placeholder="student@email.com"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="03XX-XXXXXXX"
                           value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select name="department" class="form-control">
                        <option value="">Select Department</option>
                        <option value="Software Engineering" <?= ($_POST['department']??'')==='Software Engineering'?'selected':'' ?>>Software Engineering</option>
                        <option value="Computer Science"     <?= ($_POST['department']??'')==='Computer Science'?'selected':'' ?>>Computer Science</option>
                        <option value="Information Technology" <?= ($_POST['department']??'')==='Information Technology'?'selected':'' ?>>Information Technology</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Current Semester</label>
                    <select name="semester" class="form-control">
                        <?php for($i=1;$i<=8;$i++): ?>
                        <option value="<?=$i?>" <?= (($_POST['semester']??1)==$i)?'selected':'' ?>>Semester <?=$i?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="Active"    <?= ($_POST['status']??'Active')==='Active'?'selected':'' ?>>Active</option>
                        <option value="Inactive"  <?= ($_POST['status']??'')==='Inactive'?'selected':'' ?>>Inactive</option>
                        <option value="Graduated" <?= ($_POST['status']??'')==='Graduated'?'selected':'' ?>>Graduated</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Enrollment Date</label>
                    <input type="date" name="enrolled_at" class="form-control"
                           value="<?= htmlspecialchars($_POST['enrolled_at'] ?? date('Y-m-d')) ?>">
                </div>
            </div>
            <div style="margin-top:24px; display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Student</button>
                <a href="index.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
