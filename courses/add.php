<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDB();
    $code  = trim($_POST['course_code']);
    $name  = trim($_POST['course_name']);
    $ch    = (int)$_POST['credit_hours'];
    $dept  = trim($_POST['department']);
    $inst  = trim($_POST['instructor']);
    $sem   = (int)$_POST['semester'];

    if (!$code || !$name) {
        $error = "Course Code and Course Name are required.";
    } else {
        $stmt = $db->prepare("INSERT INTO courses (course_code,course_name,credit_hours,department,instructor,semester) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssissi", $code, $name, $ch, $dept, $inst, $sem);
        if ($stmt->execute()) {
            header("Location: index.php?success=added"); exit();
        } else {
            $error = "Could not add course. Course code may already exist.";
        }
    }
    $db->close();
}

$pageTitle  = 'Add Course';
$activePage = 'courses';
include '../includes/header.php';
?>
<div class="page-header">
    <div><h1><i class="fas fa-plus" style="color:var(--accent);margin-right:8px;"></i>Add New Course</h1></div>
    <a href="index.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<?php if($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card"><div class="card-header"><h2>Course Information</h2></div><div class="card-body">
<form method="POST">
    <div class="form-grid">
        <div class="form-group">
            <label>Course Code *</label>
            <input type="text" name="course_code" class="form-control" placeholder="e.g. CS101" value="<?= htmlspecialchars($_POST['course_code']??'') ?>" required>
        </div>
        <div class="form-group">
            <label>Course Name *</label>
            <input type="text" name="course_name" class="form-control" placeholder="e.g. Programming Fundamentals" value="<?= htmlspecialchars($_POST['course_name']??'') ?>" required>
        </div>
        <div class="form-group">
            <label>Credit Hours</label>
            <select name="credit_hours" class="form-control">
                <?php for($i=1;$i<=4;$i++): ?>
                <option value="<?=$i?>" <?= (($_POST['credit_hours']??3)==$i)?'selected':'' ?>><?=$i?> Credit Hours</option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Department</label>
            <select name="department" class="form-control">
                <option value="">Select Department</option>
                <?php foreach(['Software Engineering','Computer Science','Information Technology'] as $d): ?>
                <option value="<?=$d?>" <?= ($_POST['department']??'')===$d?'selected':'' ?>><?=$d?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Instructor Name</label>
            <input type="text" name="instructor" class="form-control" placeholder="Dr. / Prof." value="<?= htmlspecialchars($_POST['instructor']??'') ?>">
        </div>
        <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control">
                <?php for($i=1;$i<=8;$i++): ?>
                <option value="<?=$i?>" <?= (($_POST['semester']??1)==$i)?'selected':'' ?>>Semester <?=$i?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    <div style="margin-top:24px;display:flex;gap:12px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Course</button>
        <a href="index.php" class="btn btn-outline">Cancel</a>
    </div>
</form>
</div></div>
<?php include '../includes/footer.php'; ?>
