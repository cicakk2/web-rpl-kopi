<?php
require_once 'auth_check.php';

$success_message = '';

// Handle status update
if (isset($_GET['mark_read'])) {
    $id = intval($_GET['mark_read']);
    $update_sql = "UPDATE contacts SET status = 'read' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $success_message = "Message marked as read";
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $success_message = "Message deleted successfully";
}

// Get all contacts
$contacts_query = "SELECT * FROM contacts ORDER BY created_at DESC";
$contacts_result = mysqli_query($conn, $contacts_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Robusta Dampit</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <?php include 'includes/topbar.php'; ?>
        
        <div class="admin-main">
            <div class="page-header">
                <div>
                    <h1>Contact Messages</h1>
                    <p>View and manage customer inquiries</p>
                </div>
            </div>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="dashboard-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($contacts_result) > 0): ?>
                                <?php while ($contact = mysqli_fetch_assoc($contacts_result)): ?>
                                    <tr style="<?php echo $contact['status'] === 'new' ? 'background: rgba(107, 68, 35, 0.03);' : ''; ?>">
                                        <td>
                                            <?php if ($contact['status'] === 'new'): ?>
                                                <span class="badge badge-success">New</span>
                                            <?php else: ?>
                                                <span class="badge badge-gray"><?php echo ucfirst($contact['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?php echo htmlspecialchars($contact['name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($contact['message'], 0, 50)) . '...'; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($contact['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <?php if ($contact['status'] === 'new'): ?>
                                                    <a href="?mark_read=<?php echo $contact['id']; ?>" class="btn-icon btn-edit" title="Mark as Read">
                                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                                <button onclick='viewMessage(<?php echo json_encode($contact); ?>)' class="btn-icon btn-edit" title="View Message">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                                <a href="?delete=<?php echo $contact['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?')" class="btn-icon btn-delete" title="Delete">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No messages found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- View Message Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Message Details</h2>
                <button class="modal-close" onclick="closeMessageModal()">&times;</button>
            </div>
            <div style="padding: 1.5rem;">
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; color: var(--coffee-dark); display: block; margin-bottom: 0.5rem;">From:</label>
                    <p id="messageName" style="color: var(--text-dark);"></p>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; color: var(--coffee-dark); display: block; margin-bottom: 0.5rem;">Email:</label>
                    <p id="messageEmail" style="color: var(--text-dark);"></p>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; color: var(--coffee-dark); display: block; margin-bottom: 0.5rem;">Subject:</label>
                    <p id="messageSubject" style="color: var(--text-dark);"></p>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-weight: 600; color: var(--coffee-dark); display: block; margin-bottom: 0.5rem;">Message:</label>
                    <p id="messageText" style="color: var(--text-dark); line-height: 1.6; white-space: pre-wrap;"></p>
                </div>
                <div>
                    <label style="font-weight: 600; color: var(--coffee-dark); display: block; margin-bottom: 0.5rem;">Date:</label>
                    <p id="messageDate" style="color: var(--text-light);"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeMessageModal()">Close</button>
                <a id="replyEmail" href="" class="btn btn-primary">Reply via Email</a>
            </div>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
    <script src="js/admin.js"></script>
    <script>
        function viewMessage(message) {
            document.getElementById('messageModal').style.display = 'flex';
            document.getElementById('messageName').textContent = message.name;
            document.getElementById('messageEmail').textContent = message.email;
            document.getElementById('messageSubject').textContent = message.subject;
            document.getElementById('messageText').textContent = message.message;
            document.getElementById('messageDate').textContent = new Date(message.created_at).toLocaleString();
            document.getElementById('replyEmail').href = 'mailto:' + message.email + '?subject=Re: ' + encodeURIComponent(message.subject);
        }
        
        function closeMessageModal() {
            document.getElementById('messageModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('messageModal');
            if (event.target == modal) {
                closeMessageModal();
            }
        }
    </script>
</body>
</html>
