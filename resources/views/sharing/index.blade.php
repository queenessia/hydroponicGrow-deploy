<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydroponic Grow</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon dan Icons -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sharing.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amita:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        /* Adjustment untuk navbar di halaman sharing */
        body {
            padding-top: 70px; /* Space untuk navbar yang fixed */
        }
        
        .container {
            margin-top: 20px; /* Extra space dari navbar */
        }
        
        /* Mobile Navbar Styles - Pastikan ini sesuai dengan navbar.css */
        .mobile-overlay {
           display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
        }
        
        .mobile-overlay.active {
            display: block;
        }
        
        /* Navbar styles for mobile */
        .transparent-nav {
            position: fixed;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 70px;
    top: 0;
    left: 0;
    padding: 10px 5%;
    font-weight: bold;
    z-index: 1000;
    border-bottom: none;
    background-color: #f3efea;
        }
        
        .logo-container {
            display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
        }
        
        .logo {
           height: 40px;
    width: auto;
        }
        
        .brand-name {
     font-family: "Amita", serif;
    font-weight: 700;
    font-size: clamp(16px, 4vw, 24px);
    color: black;
    white-space: nowrap;
        }
        
        .nav-links {
            display: flex;
    align-items: center;
    gap: clamp(20px, 5vw, 50px);
    list-style: none;
    margin: 0;
    padding: 0;
    transition: all 0.3s ease;
        }
        
        .nav-links a {
            text-decoration: none;
    color: black;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 8px 16px;
    position: relative;
    font-size: clamp(14px, 2.5vw, 16px);
    white-space: nowrap;
    cursor: pointer;
        }
        
        .nav-links a:hover {
    color: #006400 !important;
    font-weight: 700 !important;
}

.nav-links a.active {
    color: #006400 !important;
    font-weight: 700 !important;
}
        
        .mobile-menu {
    display: none;
    flex-direction: column;
    cursor: pointer;
    padding: 5px;
    z-index: 1001;
}

.mobile-menu span {
    width: 25px;
    height: 3px;
    background: black;
    margin: 3px 0;
    transition: 0.3s;
    border-radius: 2px;
}
        
        .mobile-menu.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .mobile-menu.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        /* Auth button styling */
        .auth-button {
            background: #A8E6A1;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .auth-button:hover {
            background: #95D88D;
            transform: translateY(-2px);
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }
            
            .mobile-menu {
                display: flex;
            }
            
            .nav-links {
                position: fixed;
                top: 60px;
                right: -100%;
                width: 250px;
                height: calc(100vh - 60px);
                background: white;
                flex-direction: column;
                justify-content: flex-start;
                align-items: flex-start;
                padding: 20px;
                gap: 15px;
                transition: right 0.3s ease;
                box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .nav-links li {
                width: 100%;
            }
            
            .nav-links a {
                display: block;
                width: 100%;
                padding: 12px 0;
                border-bottom: 1px solid #eee;
            }
            .nav-links a:hover {
    color: #006400 !important;
    font-weight: 700 !important;
}

.nav-links a.active {
    color: #006400 !important;
    font-weight: 700 !important;
}
            
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <!-- Navbar -->
    <nav class="transparent-nav">
        <div class="logo-container">
            <img src="/image/logo.png" alt="Logo" class="logo" onerror="this.style.display='none'">
            <div class="brand-name">Hydroponic Grow</div>
        </div>
        
        <ul class="nav-links" id="navLinks">
            <li><a href="#" id="homeLink">Home</a></li>
            <li><a href="#" id="articleLink">Article</a></li>
            <li><a href="#" id="videoLink">Video</a></li>
            <li><a href="#" id="sharingLink" class="active">Sharing</a></li>
            <li>
                <!-- Dynamic dashboard/signin link -->
                @auth('web')
                    <!-- Admin logged in -->
                    <div class="auth-status">
                        <a href="{{ route('admin.dashboard') }}" id="dashboardLink">Dashboard</a>
                    </div>
                @elseauth('member')
                    <!-- Member logged in -->
                    <div class="auth-status">
                        <a href="{{ route('user.dashboard') }}" id="dashboardLink">Dashboard</a>
                    </div>
                @else
                    <!-- Not logged in -->
                    <a href="{{ route('sign_in') }}" id="signinLink" class="auth-button">Sign In</a>
                @endauth
            </li>
        </ul>
        
        <div class="mobile-menu" id="mobileMenu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Left Sidebar -->
        <div class="left-side">
            <!-- User Profile -->
            <div class="profile-section">
                @auth('member')
                    <img src="{{ auth('member')->user()->profile_image ? asset('storage/profile_images/' . auth('member')->user()->profile_image) : asset('image/user.png') }}" 
                         alt="Foto Profil" class="profile-pic">
                    <span class="username">{{ auth('member')->user()->username }}</span>
                @else
                    <img src="/image/user.png" alt="Foto Profil" class="profile-pic">
                    <span class="username">Guest</span>
                @endauth
            </div>

            @auth('member')
                <!-- Navigation Items -->
                <div class="left-side-item" id="manage-posts-btn" onclick="window.location.href='{{ url('/dashboard') }}'">
                    <i class="fas fa-cogs"></i>
                    <span>Manage Post</span>
                </div>

                <!-- Create Post Button -->
                <div class="post-button" id="create-post-btn">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Create Post</span>
                </div>
            @else
                <div class="left-side-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Login as User to Posting</span>
                </div>
            @endauth
        </div>

        <!-- Main Content -->
        <div class="right-side">
            <!-- Header -->
            <div class="share-experience">
                <span id="page-title">Share Your Experience</span>
            </div>

            <!-- Posts Container -->
            <div id="posts-container">
                <div class="posts-loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <br>Loading posts...
                </div>
            </div>

            <!-- Load More Button -->
            <div id="load-more-container" style="text-align: center; margin-top: 20px; display: none;">
                <button id="load-more-btn" class="btn" style="background: #667eea; color: white;">
                    Load More Posts
                </button>
            </div>
        </div>
    </div>

    <!-- Post Creation Modal -->
    <div id="post-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Post</h3>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <form id="post-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Share your experience</label>
                    <textarea name="content" id="post-content" class="form-textarea" 
                              placeholder="What's on your mind about hydroponics?" 
                              maxlength="1000" required></textarea>
                    <small style="color: #666; font-size: 12px;">
                        <span id="char-count">0</span>/1000 characters
                    </small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Add Images (Optional)</label>
                    <div class="file-input-container">
                        <input type="file" name="images[]" id="post-images" class="file-input" 
                               multiple accept="image/*">
                        <label for="post-images" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div>Click to upload images</div>
                            <small>PNG, JPG, GIF up to 2MB each</small>
                        </label>
                    </div>
                    <div id="image-preview" class="image-preview"></div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" id="cancel-post">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-submit" id="submit-post">
                        <i class="fas fa-paper-plane"></i>
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reply Modal -->
    <div id="reply-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Reply to Post</h3>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <div id="original-post-preview"></div>
            <form id="reply-form" enctype="multipart/form-data">
                <input type="hidden" name="parent_id" id="reply-parent-id">
                <div class="form-group">
                    <label class="form-label">Your reply</label>
                    <textarea name="content" id="reply-content" class="form-textarea" 
                              placeholder="Write your reply..." 
                              maxlength="1000" required></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Add Images (Optional)</label>
                    <div class="file-input-container">
                        <input type="file" name="images[]" id="reply-images" class="file-input" 
                               multiple accept="image/*">
                        <label for="reply-images" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div>Click to upload images</div>
                            <small>PNG, JPG, GIF up to 2MB each</small>
                        </label>
                    </div>
                    <div id="reply-image-preview" class="image-preview"></div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-reply"></i>
                        Reply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden data for JavaScript -->
    <script>
        window.APP_CONFIG = {
            isAuthenticated: {{ auth('member')->check() ? 'true' : 'false' }},
            userType: '{{ auth('member')->check() ? 'member' : (auth('web')->check() ? 'admin' : 'guest') }}',
            @auth('member')
            currentUser: {
                id: {{ auth('member')->id() }},
                username: '{{ auth('member')->user()->username }}',
                profileImage: '{{ auth('member')->user()->profile_image ? asset('storage/profile_images/' . auth('member')->user()->profile_image) : asset('image/user.png') }}'
            },
            @else
            currentUser: null,
            @endauth
            csrfToken: '{{ csrf_token() }}'
        };
        
        // Debug log
        console.log('APP_CONFIG loaded:', window.APP_CONFIG);
    </script>

    <!-- JavaScript -->
    <script>
        // Mobile menu functionality AND Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            const navLinks = document.getElementById('navLinks');
            const mobileOverlay = document.getElementById('mobileOverlay');
            
            // Navigation elements
            const homeLink = document.getElementById('homeLink');
            const articleLink = document.getElementById('articleLink');
            const videoLink = document.getElementById('videoLink');
            const sharingLink = document.getElementById('sharingLink');
            const dashboardLink = document.getElementById('dashboardLink');
            const signinLink = document.getElementById('signinLink');
            
            // Check if user is logged in (for JavaScript functionality)
            const isLoggedIn = {{ Auth::guard('web')->check() || Auth::guard('member')->check() ? 'true' : 'false' }};
            const userType = '{{ Auth::guard('web')->check() ? "admin" : (Auth::guard('member')->check() ? "member" : "guest") }}';
            
            // Setup navigation functionality
            setupNavigation();
            
            // Check if elements exist
            if (mobileMenu && navLinks) {
                console.log('Mobile menu elements found');
                
                // Toggle mobile menu when hamburger is clicked
                mobileMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                    console.log('Mobile menu clicked');
                    
                    mobileMenu.classList.toggle('active');
                    navLinks.classList.toggle('active');
                    mobileOverlay.classList.toggle('active');
                    
                    // Prevent body scroll when menu is open
                    if (navLinks.classList.contains('active')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                });
                
                // Close menu when clicking on a navigation link
                const navLinksItems = navLinks.querySelectorAll('a');
                navLinksItems.forEach(link => {
                    link.addEventListener('click', function() {
                        console.log('Nav link clicked');
                        closeMenu();
                    });
                });
                
                // Close menu when clicking on overlay
                mobileOverlay.addEventListener('click', function() {
                    console.log('Overlay clicked');
                    closeMenu();
                });
                
                // Close menu when clicking outside (fallback)
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && 
                        !navLinks.contains(event.target) && 
                        navLinks.classList.contains('active')) {
                        closeMenu();
                    }
                });
                
                // Close menu when window is resized to desktop size
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        closeMenu();
                    }
                });
                
                // Function to close menu
                function closeMenu() {
                    mobileMenu.classList.remove('active');
                    navLinks.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
                
                // Handle escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && navLinks.classList.contains('active')) {
                        closeMenu();
                    }
                });
                
            } else {
                console.log('Mobile menu elements not found');
            }
            
            // Navigation functionality
            function setupNavigation() {
                // Home navigation
                if (homeLink) {
                    homeLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Navigate to home page
                        window.location.href = '/'; // or your home route
                    });
                }
                
                // Article navigation
                if (articleLink) {
                    articleLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Navigate to home page with article section
                        window.location.href = '/#articles'; // or your home route with article anchor
                    });
                }
                
                // Video navigation
                if (videoLink) {
                    videoLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Navigate to home page with video section
                        window.location.href = '/#videos'; // or your home route with video anchor
                    });
                }
                
                // Sharing navigation (current page)
                if (sharingLink) {
                    sharingLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Already on sharing page, just refresh or scroll to top
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }
                
                // Dashboard navigation (if logged in)
                if (dashboardLink) {
                    dashboardLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Navigate based on user type
                        if (userType === 'admin') {
                            window.location.href = '/admin/dashboard';
                        } else if (userType === 'member') {
                            window.location.href = '/user/dashboard';
                        } else {
                            window.location.href = '/dashboard';
                        }
                    });
                }
                
                // Sign In navigation (if not logged in)
                if (signinLink) {
                    signinLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.location.href = '/sign-in';
                    });
                }
            }
        });
    </script>
    <script src="{{ asset('js/sharing.js') }}"></script>
</body>
</html>