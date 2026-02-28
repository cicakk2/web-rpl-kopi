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
