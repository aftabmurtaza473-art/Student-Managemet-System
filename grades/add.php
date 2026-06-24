<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db       = getDB();
$students = $db->query("SELECT id, student_id, full_name FROM students WHERE status='Active' ORDER BY full_name");
$courses  = $db->query("SELECT id, course_code, course_name FROM courses ORDER BY course_name");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid   = (int)$_POST['student_id'];
    $cid   = (int)$_POST['course_id'];
    $marks = (float)$_POST['marks'];
    $grade = trim($_POST['grade']);
    $sem   = (int)$_POST['semester'];
    $year  = trim($_POST['academic_year']);

    if (!$sid || !$cid) {
        $error = "Please select a student and a course.";
    } else {
        $stmt = $db->prepare("INSERT INTO grades (student_id,course_id,marks,grade,semester,academic_year) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("iidssi", $sid, $cid, $marks, $grade, $sem, $year);
        if ($stmt->execute()) { header("Location: index.php?success=added"); exit(); }
        else { $error = "Could not save grade. This student may already have a grade for this course in this semester."; }
    }
}
$db->close();

$pageTitle='Add Grade'; $activePage='grades';
include '../includes/header.php';
?>
<div class="page-header">
    <div><h1><i class="fas fa-plus" style="color:var(--accent);margin-right:8px;"></i>Add Grade Record</h1></div>
    <a href="index.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<?php if($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card"><div class="card-header"><h2>Grade Information</h2></div><div class="card-body">
<form method="POST">
    <div class="form-grid">
        <div class="form-group">
            <label>Student *</label>
            <select name="student_id" class="form-control" required>
                <option value="">Select Student</option>
                <?php while($s=$students->fetch_assoc()): ?>
                <option value="<?=$s['id']?>" <?= ($_POST['student_id']??'')==$s['id']?'selected':'' ?>><?= htmlspecialchars($s['student_id'].' — '.$s['full_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Course *</label>
            <select name="course_id" class="form-control" required>
                <option value="">Select Course</option>
                <?php while($c=$courses->fetch_assoc()): ?>
                <option value="<?=$c['id']?>" <?= ($_POST['course_id']??'')==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['course_code'].' — '.$c['course_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Marks Obtained (out of 100)</label>
            <input type="number" id="marks" name="marks" class="form-control" min="0" max="100" step="0.01"
                   placeholder="e.g. 85.50" value="<?= htmlspecialchars($_POST['marks']??'') ?>">
            <small style="color:var(--text-muted);font-size:12px;">Grade will auto-fill as you type</small>
        </div>
        <div class="form-group">
            <label>Grade</label>
            <input type="text" id="grade" name="grade" class="form-control" placeholder="Auto-calculated"
                   value="<?= htmlspecialchars($_POST['grade']??'') ?>">
        </div>
        <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control">
                <?php for($i=1;$i<=8;$i++): ?><option value="<?=$i?>" <?= (($_POST['semester']??1)==$i)?'selected':'' ?>>Semester <?=$i?></option><?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Academic Year</label>
            <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024"
                   value="<?= htmlspecialchars($_POST['academic_year']??date('Y')) ?>">
        </div>
    </div>
    <div style="margin-top:24px;display:flex;gap:12px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Grade</button>
        <a href="index.php" class="btn btn-outline">Cancel</a>
    </div>
</form>
</div></div>
<?php include '../includes/footer.php'; ?>
