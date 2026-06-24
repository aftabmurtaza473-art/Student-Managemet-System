<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db = getDB();
$id = (int)($_GET['id']??0);
$grade = $db->query("SELECT * FROM grades WHERE id=$id")->fetch_assoc();
if (!$grade) { header("Location: index.php"); exit(); }

$students = $db->query("SELECT id, student_id, full_name FROM students ORDER BY full_name");
$courses  = $db->query("SELECT id, course_code, course_name FROM courses ORDER BY course_name");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid   = (int)$_POST['student_id'];
    $cid   = (int)$_POST['course_id'];
    $marks = (float)$_POST['marks'];
    $g     = trim($_POST['grade']);
    $sem   = (int)$_POST['semester'];
    $year  = trim($_POST['academic_year']);

    $stmt = $db->prepare("UPDATE grades SET student_id=?,course_id=?,marks=?,grade=?,semester=?,academic_year=? WHERE id=?");
    $stmt->bind_param("iidssii", $sid, $cid, $marks, $g, $sem, $year, $id);
    if ($stmt->execute()) { header("Location: index.php?success=updated"); exit(); }
    else { $error = "Could not update grade."; }
}
$db->close();
$d = $_POST ?: $grade;
$pageTitle='Edit Grade'; $activePage='grades';
include '../includes/header.php';
?>
<div class="page-header">
    <div><h1><i class="fas fa-edit" style="color:var(--warning);margin-right:8px;"></i>Edit Grade</h1></div>
    <a href="index.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<?php if($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-header"><h2>Grade Information</h2></div><div class="card-body">
<form method="POST">
    <div class="form-grid">
        <div class="form-group">
            <label>Student *</label>
            <select name="student_id" class="form-control" required>
                <?php while($s=$students->fetch_assoc()): ?>
                <option value="<?=$s['id']?>" <?= $d['student_id']==$s['id']?'selected':'' ?>><?= htmlspecialchars($s['student_id'].' — '.$s['full_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Course *</label>
            <select name="course_id" class="form-control" required>
                <?php while($c=$courses->fetch_assoc()): ?>
                <option value="<?=$c['id']?>" <?= $d['course_id']==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['course_code'].' — '.$c['course_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Marks</label>
            <input type="number" id="marks" name="marks" class="form-control" min="0" max="100" step="0.01" value="<?= $d['marks'] ?>">
        </div>
        <div class="form-group">
            <label>Grade</label>
            <input type="text" id="grade" name="grade" class="form-control" value="<?= htmlspecialchars($d['grade']) ?>">
        </div>
        <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control">
                <?php for($i=1;$i<=8;$i++): ?><option value="<?=$i?>" <?= $d['semester']==$i?'selected':'' ?>>Semester <?=$i?></option><?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Academic Year</label>
            <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($d['academic_year']??'') ?>">
        </div>
    </div>
    <div style="margin-top:24px;display:flex;gap:12px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Grade</button>
        <a href="index.php" class="btn btn-outline">Cancel</a>
    </div>
</form>
</div></div>
<?php include '../includes/footer.php'; ?>
