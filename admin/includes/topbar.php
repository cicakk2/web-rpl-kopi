<header class="admin-topbar">
    <div class="topbar-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div class="breadcrumb">
            <span>Admin</span>
            <span class="separator">/</span>
            <span class="current"><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></span>
        </div>
    </div>
    
    <div class="topbar-right">
        <div class="topbar-item">
            <button class="notification-btn">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span class="notification-badge">3</span>
            </button>
        </div>
        
        <div class="topbar-divider"></div>
        
        <div class="topbar-item">
            <div class="user-menu">
                <div class="user-avatar">
                    <span><?php echo strtoupper(substr($_SESSION['admin_name'], 0, 1)); ?></span>
                </div>
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
        </div>
    </div>
</header>
