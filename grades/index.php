<?php
session_start();
define('BASE_URL', '../');
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

$db = getDB();
$grades = $db->query(
    "SELECT g.*, s.full_name AS student_name, s.student_id AS sid, c.course_name, c.course_code
     FROM grades g
     JOIN students s ON g.student_id = s.id
     JOIN courses  c ON g.course_id  = c.id
     ORDER BY g.created_at DESC"
);
$total = $db->query("SELECT COUNT(*) AS c FROM grades")->fetch_assoc()['c'];
$db->close();

$pageTitle='Grades'; $activePage='grades';
include '../includes/header.php';
?>
<div class="page-header">
    <div>
        <h1><i class="fas fa-star" style="color:var(--accent);margin-right:8px;"></i>Grades</h1>
        <p>Manage student grade records</p>
    </div>
    <a href="add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Grade</a>
</div>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i>
    <?= $_GET['success']==='added'?'Grade added!':($_GET['success']==='updated'?'Grade updated!':'Grade deleted.') ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>All Grades (<span id="rowCount"><?= $total ?></span>)</h2>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="tableSearch" placeholder="Search by name, course...">
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Marks</th>
                    <th>Grade</th>
                    <th>Semester</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($row = $grades->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <strong><?= htmlspecialchars($row['student_name']) ?></strong><br>
                        <small style="color:var(--text-muted);"><?= htmlspecialchars($row['sid']) ?></small>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($row['course_code']) ?></strong><br>
                        <small style="color:var(--text-muted);"><?= htmlspecialchars($row['course_name']) ?></small>
                    </td>
                    <td><strong><?= $row['marks'] ?></strong></td>
                    <td>
                        <?php
                        $g = $row['grade'];
                        $c = in_array($g,['A+','A','A-'])?'success':(in_array($g,['B+','B','B-'])?'info':(in_array($g,['C+','C'])?'warning':'danger'));
                        ?>
                        <span class="badge badge-<?=$c?>"><?=$g?></span>
                    </td>
                    <td style="text-align:center;"><?= $row['semester'] ?></td>
                    <td><?= htmlspecialchars($row['academic_year']??'—') ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="edit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm btn-icon" title="Edit"><i class="fas fa-edit"></i></a>
                            <button onclick="confirmDelete('delete.php?id=<?=$row['id']?>', 'this grade record')" class="btn btn-danger btn-sm btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if($total===0): ?>
                <tr><td colspan="8"><div class="empty-state"><i class="fas fa-star"></i><h3>No grade records yet</h3><p><a href="add.php" class="btn btn-primary" style="margin-top:12px;"><i class="fas fa-plus"></i> Add First Grade</a></p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
