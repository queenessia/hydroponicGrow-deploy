<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydroponic Grow</title>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon dan Icons -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    <style>
        
        /* Additional styles for login status */
        .auth-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
        }
        
        /* Auth button styling for Sign In */
        .auth-button {
            background: #A8E6A1;
            color: white;
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
        
        @media (max-width: 768px) {
            .auth-status {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .user-info {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <nav class="transparent-nav">
        <div class="logo-container">
            <img src="/image/logo.png" alt="Logo" class="logo" onerror="this.style.display='none'">
            <div class="brand-name">Hydroponic Grow</div>
        </div>
        
        <ul class="nav-links" id="navLinks">
            <li><a href="#" id="homeLink" class="active">Home</a></li>
            <li><a href="#" id="articleLink">Article</a></li>
            <li><a href="#" id="videoLink">Video</a></li>
            <li><a href="#" id="sharingLink">Sharing</a></li>
            <li>
                <!-- Dynamic dashboard/signin link -->
                @auth('web')
                    <!-- Admin logged in -->
                    <div class="auth-status">
                        <a href="{{ route('admin.dashboard') }}" id="dashboardLink">Dashboard</a>
                        
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

    <script>
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
            
            // Variable to track if user manually clicked a nav link
            let manualNavigation = false;
            
            // Check if user is logged in (for JavaScript functionality)
            const isLoggedIn = {{ Auth::guard('web')->check() || Auth::guard('member')->check() ? 'true' : 'false' }};
            const userType = '{{ Auth::guard('web')->check() ? "admin" : (Auth::guard('member')->check() ? "member" : "guest") }}';
            
            // Setup navigation functionality
            setupSmoothScrollNavigation();
            setupActiveStateManagement();
            
            // Mobile menu functionality
            if (mobileMenu && navLinks) {
                // Toggle mobile menu
                mobileMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleMobileMenu();
                });
                
                // Close menu when clicking on navigation links
                const navLinksItems = navLinks.querySelectorAll('a');
                navLinksItems.forEach(link => {
                    link.addEventListener('click', function() {
                        closeMobileMenu();
                    });
                });
                
                // Close menu when clicking on overlay
                mobileOverlay.addEventListener('click', closeMobileMenu);
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && 
                        !navLinks.contains(event.target) && 
                        navLinks.classList.contains('active')) {
                        closeMobileMenu();
                    }
                });
                
                // Close menu on window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        closeMobileMenu();
                    }
                });
                
                // Close menu on Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && navLinks.classList.contains('active')) {
                        closeMobileMenu();
                    }
                });
            }
            
            function toggleMobileMenu() {
                mobileMenu.classList.toggle('active');
                navLinks.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                
                // Prevent body scroll when menu is open
                if (navLinks.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
            
            function closeMobileMenu() {
                mobileMenu.classList.remove('active');
                navLinks.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            function setupSmoothScrollNavigation() {
                // Home navigation
                if (homeLink) {
                    homeLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        manualNavigation = true;
                        scrollToTop();
                        setActiveLink('home');
                        setTimeout(() => { manualNavigation = false; }, 1000);
                    });
                }
                
                // Article navigation
                if (articleLink) {
                    articleLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        manualNavigation = true;
                        scrollToArticleSection();
                        setActiveLink('article');
                        setTimeout(() => { manualNavigation = false; }, 1000);
                    });
                }
                
                // Video navigation
                if (videoLink) {
                    videoLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        manualNavigation = true;
                        scrollToVideoSection();
                        setActiveLink('video');
                        setTimeout(() => { manualNavigation = false; }, 1000);
                    });
                }
                
                // Sharing navigation
                if (sharingLink) {
                    sharingLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        setActiveLink('sharing');
                        window.location.href = '/sharing';
                    });
                }
                
                // Dashboard navigation (if logged in)
                if (dashboardLink) {
                    dashboardLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        setActiveLink('dashboard');
                        
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
                        setActiveLink('signin');
                        window.location.href = '/sign-in';
                    });
                }
            }
            
            function setupActiveStateManagement() {
                // Scroll-based active state management
                let ticking = false;
                
                window.addEventListener('scroll', function() {
                    if (!ticking && !manualNavigation) {
                        requestAnimationFrame(function() {
                            updateActiveStateOnScroll();
                            ticking = false;
                        });
                        ticking = true;
                    }
                });
            }
            
            function updateActiveStateOnScroll() {
                const scrollTop = window.scrollY;
                const windowHeight = window.innerHeight;
                
                // Get section positions
                const homeSection = document.getElementById('home');
                const articleSection = document.getElementById('articles');
                const videoSection = document.getElementById('videos');
                
                let activeSection = 'home'; // default
                
                if (articleSection) {
                    const articleTop = articleSection.offsetTop - 100;
                    const articleBottom = articleTop + articleSection.offsetHeight;
                    
                    if (scrollTop >= articleTop && scrollTop < articleBottom) {
                        activeSection = 'article';
                    }
                }
                
                if (videoSection) {
                    const videoTop = videoSection.offsetTop - 100;
                    
                    if (scrollTop >= videoTop) {
                        activeSection = 'video';
                    }
                }
                
                setActiveLink(activeSection);
            }
            
            function setActiveLink(section) {
                // Remove active class from all links
                const allLinks = document.querySelectorAll('.nav-links a');
                allLinks.forEach(link => link.classList.remove('active'));
                
                // Add active class to the appropriate link
                switch(section) {
                    case 'home':
                        homeLink?.classList.add('active');
                        break;
                    case 'article':
                        articleLink?.classList.add('active');
                        break;
                    case 'video':
                        videoLink?.classList.add('active');
                        break;
                    case 'sharing':
                        sharingLink?.classList.add('active');
                        break;
                    case 'dashboard':
                        dashboardLink?.classList.add('active');
                        break;
                    case 'signin':
                        signinLink?.classList.add('active');
                        break;
                }
            }
            
            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
            
            function scrollToArticleSection() {
                const articleElement = findArticleSection();
                
                if (articleElement) {
                    const navbarHeight = 70;
                    const elementPosition = articleElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navbarHeight - 20;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                } else {
                    window.scrollTo({
                        top: window.innerHeight,
                        behavior: 'smooth'
                    });
                }
            }
            
            function scrollToVideoSection() {
                const videoElement = findVideoSection();
                
                if (videoElement) {
                    const navbarHeight = 70;
                    const elementPosition = videoElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navbarHeight - 20;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                } else {
                    window.scrollTo({
                        top: document.body.scrollHeight - window.innerHeight,
                        behavior: 'smooth'
                    });
                }
            }
            
            function findArticleSection() {
                let element = document.getElementById('articles');
                if (element) return element;
                
                const headings = document.querySelectorAll('h1, h2, h3, h4');
                for (let heading of headings) {
                    if (heading.textContent.toLowerCase().includes('selected article')) {
                        return heading;
                    }
                }
                
                const selectors = [
                    '.selected-article',
                    '.articles-container', 
                    '.article-section'
                ];
                
                for (let selector of selectors) {
                    element = document.querySelector(selector);
                    if (element) return element;
                }
                
                return null;
            }
            
            function findVideoSection() {
                let element = document.getElementById('videos');
                if (element) return element;
                
                const headings = document.querySelectorAll('h1, h2, h3, h4');
                for (let heading of headings) {
                    const text = heading.textContent.toLowerCase();
                    if (text.includes('our recommendation videos') || text.includes('recommendation video')) {
                        return heading;
                    }
                }
                
                const selectors = [
                    '.videos-container',
                    '.video-section',
                    '.recommendation-videos'
                ];
                
                for (let selector of selectors) {
                    element = document.querySelector(selector);
                    if (element) return element;
                }
                
                return null;
            }
        });
    </script>
</body>
</html>