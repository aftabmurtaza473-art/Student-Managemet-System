<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db = getDB();
$id = (int)($_GET['id']??0);
$course = $db->query("SELECT * FROM courses WHERE id=$id")->fetch_assoc();
if (!$course) { header("Location: index.php"); exit(); }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['course_code']);
    $name = trim($_POST['course_name']);
    $ch   = (int)$_POST['credit_hours'];
    $dept = trim($_POST['department']);
    $inst = trim($_POST['instructor']);
    $sem  = (int)$_POST['semester'];

    $stmt = $db->prepare("UPDATE courses SET course_code=?,course_name=?,credit_hours=?,department=?,instructor=?,semester=? WHERE id=?");
    $stmt->bind_param("ssissii", $code, $name, $ch, $dept, $inst, $sem, $id);
    if ($stmt->execute()) { header("Location: index.php?success=updated"); exit(); }
    else { $error = "Could not update course."; }
}
$db->close();

$d = $_POST ?: $course;
$pageTitle='Edit Course'; $activePage='courses';
include '../includes/header.php';
?>
<div class="page-header">
    <div><h1><i class="fas fa-edit" style="color:var(--warning);margin-right:8px;"></i>Edit Course</h1></div>
    <a href="index.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<?php if($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-header"><h2>Course Information</h2></div><div class="card-body">
<form method="POST">
    <div class="form-grid">
        <div class="form-group">
            <label>Course Code *</label>
            <input type="text" name="course_code" class="form-control" value="<?= htmlspecialchars($d['course_code']) ?>" required>
        </div>
        <div class="form-group">
            <label>Course Name *</label>
            <input type="text" name="course_name" class="form-control" value="<?= htmlspecialchars($d['course_name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Credit Hours</label>
            <select name="credit_hours" class="form-control">
                <?php for($i=1;$i<=4;$i++): ?><option value="<?=$i?>" <?= $d['credit_hours']==$i?'selected':'' ?>><?=$i?> Credit Hours</option><?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Department</label>
            <select name="department" class="form-control">
                <?php foreach(['Software Engineering','Computer Science','Information Technology'] as $dept): ?>
                <option value="<?=$dept?>" <?= $d['department']===$dept?'selected':'' ?>><?=$dept?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Instructor</label>
            <input type="text" name="instructor" class="form-control" value="<?= htmlspecialchars($d['instructor']??'') ?>">
        </div>
        <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control">
                <?php for($i=1;$i<=8;$i++): ?><option value="<?=$i?>" <?= $d['semester']==$i?'selected':'' ?>>Semester <?=$i?></option><?php endfor; ?>
            </select>
        </div>
    </div>
    <div style="margin-top:24px;display:flex;gap:12px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Course</button>
        <a href="index.php" class="btn btn-outline">Cancel</a>
    </div>
</form>
</div></div>
<?php include '../includes/footer.php'; ?>
