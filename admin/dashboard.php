<?php include_once 'includes/header.php'; ?>

<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>Welcome, Admin</h1>
    <p style="color: var(--text-muted);"><?php echo date('F j, Y'); ?></p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
    <div style="background: var(--surface); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border); text-align: center;">
        <h3 style="color: var(--primary); font-size: 2rem; margin-bottom: 0.5rem;">12</h3>
        <p style="color: var(--text-muted);">Total Pages</p>
    </div>
    <div style="background: var(--surface); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border); text-align: center;">
        <h3 style="color: var(--secondary); font-size: 2rem; margin-bottom: 0.5rem;">850</h3>
        <p style="color: var(--text-muted);">Site Visits</p>
    </div>
    <div style="background: var(--surface); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--border); text-align: center;">
        <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 0.5rem;">5</h3>
        <p style="color: var(--text-muted);">New Inquiries</p>
    </div>
</div>

<div style="margin-top: 3rem; background: var(--surface); border-radius: 1rem; border: 1px solid var(--border); padding: 2rem;">
    <h2 style="margin-bottom: 1.5rem;">Recent Activity</h2>
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border);">
                <th style="padding: 1rem; color: var(--text-muted);">Action</th>
                <th style="padding: 1rem; color: var(--text-muted);">Date</th>
                <th style="padding: 1rem; color: var(--text-muted);">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid var(--border);">
                <td style="padding: 1rem;">Homepage Content Updated</td>
                <td style="padding: 1rem;">2026-04-26</td>
                <td style="padding: 1rem;"><span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.2rem 0.6rem; border-radius: 1rem; font-size: 0.8rem;">Success</span></td>
            </tr>
            <tr>
                <td style="padding: 1rem;">New User Registered</td>
                <td style="padding: 1rem;">2026-04-25</td>
                <td style="padding: 1rem;"><span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.2rem 0.6rem; border-radius: 1rem; font-size: 0.8rem;">Success</span></td>
            </tr>
        </tbody>
    </table>
</div>

<?php include_once 'includes/footer.php'; ?>
