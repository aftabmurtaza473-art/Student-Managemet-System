// ============================================================
//  Student Management System — Main JavaScript
//  Author: Aftab Murtaza
// ============================================================

// ── Sidebar Toggle (mobile) ──────────────────────────────────
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

// Close sidebar on outside click (mobile)
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const toggle  = document.querySelector('.sidebar-toggle');
    if (sidebar && toggle) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    }
});

// ── Confirm Delete ───────────────────────────────────────────
function confirmDelete(url, name) {
    if (confirm('Are you sure you want to delete "' + name + '"?\nThis action cannot be undone.')) {
        window.location.href = url;
    }
}

// ── Live Table Search ────────────────────────────────────────
const searchInput = document.getElementById('tableSearch');
if (searchInput) {
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows  = document.querySelectorAll('tbody tr');
        let visible = 0;
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            const show = text.includes(query);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        const counter = document.getElementById('rowCount');
        if (counter) counter.textContent = visible;
    });
}

// ── Auto-dismiss Alerts ──────────────────────────────────────
setTimeout(function () {
    document.querySelectorAll('.alert').forEach(function(el) {
        el.style.transition = 'opacity .4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 3500);

// ── Grade Calculator ─────────────────────────────────────────
const marksInput = document.getElementById('marks');
const gradeInput = document.getElementById('grade');

if (marksInput && gradeInput) {
    marksInput.addEventListener('input', function() {
        const m = parseFloat(this.value);
        let g = '';
        if      (m >= 90) g = 'A+';
        else if (m >= 85) g = 'A';
        else if (m >= 80) g = 'A-';
        else if (m >= 75) g = 'B+';
        else if (m >= 70) g = 'B';
        else if (m >= 65) g = 'B-';
        else if (m >= 60) g = 'C+';
        else if (m >= 55) g = 'C';
        else if (m >= 50) g = 'D';
        else if (m >= 0)  g = 'F';
        gradeInput.value = g;
    });
}
