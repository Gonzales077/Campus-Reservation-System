<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holy Cross College - Facilities Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar-custom">
        <div class="container-fluid nav-container">
            <a href="#home" class="navbar-brand-text">
                <img src="https://amyfoundationph.com/home/wp-content/uploads/2022/07/hcc.gif" alt="Holy Cross College Logo" class="navbar-logo">
                <span>Holy Cross College</span>
            </a>
            
           
            <div class="nav-center">
                <ul class="nav-links">
                    <li>
                        <a href="#home">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="#about">
                            <i class="fas fa-info-circle"></i> About
                        </a>
                    </li>
                    <li>
                        <a href="#contact">
                            <i class="fas fa-envelope"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-right">
                <ul class="nav-links">
                    @auth
                    <li>
                        <a href="@if(auth()->user()->isAdmin()) {{ route('admin.dashboard') }} @else {{ route('user.dashboard') }} @endif">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to logout?')">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="home" class="hero-section">
        <h1>Holy Cross College</h1>
        <p class="subtitle">Facilities Reservation System</p>
        <p class="description">Book campus facilities with ease. Browse available spaces, check availability, and make your reservations online.</p>

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @guest
        <button class="cta-button" data-bs-toggle="modal" data-bs-target="#registerModal">
            <i class="fas fa-user-plus"></i> Get Started
        </button>
        @endguest

        <!-- Features Section -->
        <div class="features-section">
            <div class="container">
              
                <p class="subtitle-text">Holy Cross College Facilities Reservation Platform</p>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="icon-box">
                                <i class="fas fa-book"></i>
                            </div>
                            <h4>Easy Reservations</h4>
                            <p>Browse and reserve campus facilities with just a few clicks. Our intuitive interface makes scheduling simple and efficient.</p>
                            <ul>
                                <li><i class="fas fa-check"></i> Real-time availability</li>
                                <li><i class="fas fa-check"></i> Instant confirmations</li>
                                <li><i class="fas fa-check"></i> 24/7 access</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="icon-box">
                                <i class="fas fa-building"></i>
                            </div>
                            <h4>Wide Range of Spaces</h4>
                            <p>From conference rooms and lecture halls to recreational facilities. Holy Cross College offers diverse venues.</p>
                            <ul>
                                <li><i class="fas fa-check"></i> Multiple locations</li>
                                <li><i class="fas fa-check"></i> Various capacities</li>
                                <li><i class="fas fa-check"></i> Modern amenities</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="icon-box">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>Secure & Reliable</h4>
                            <p>Your reservations are protected with secure authentication. Get instant notifications for all your bookings.</p>
                            <ul>
                                <li><i class="fas fa-check"></i> Secure login</li>
                                <li><i class="fas fa-check"></i> Email notifications</li>
                                <li><i class="fas fa-check"></i> Admin support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="about-section">
        <div class="container">
            <h2><i class="fas fa-university"></i> About Holy Cross College</h2>
            <p class="subtitle-text">Excellence in Education Since 1965</p>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="about-card">
                        <h4><i class="fas fa-flag"></i> Our Mission</h4>
                        <p>HCC provides holistic character formation and strong faith in God, high sense of civic-mindedness, nationalism, and eco-stewardship through transformative instruction, research, production and extension services.</p>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Academic Excellence</li>
                            <li><i class="fas fa-check-circle"></i> Character Formation</li>
                            <li><i class="fas fa-check-circle"></i> Community Service</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="about-card">
                        <h4><i class="fas fa-eye"></i> Our Vision</h4>
                        <p>HCC envisions itself as a leading formator of God-centered, service-responsive, ecologically engaged, and innovative citizens in the region through accessible quality education.</p>
                        <h5 style="color: var(--hcc-blue); margin-top: 25px; margin-bottom: 15px; font-weight: 700;">Core Values:</h5>
                        <div class="row">
                            <div class="col-6">
                                <ul>
                                    <li><i class="fas fa-star"></i> Fides (Faith)</li>
                                    <li><i class="fas fa-star"></i> Caritas (Charity)</li>
                                    <li><i class="fas fa-star"></i> Libertas (Liberty)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- MORE ABOUT HCC BUTTON -->
            <div class="about-footer">
                <button class="btn-more-about" data-bs-toggle="modal" data-bs-target="#moreAboutModal">
                    <i class="fas fa-info-circle"></i> More About HCC
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="contact-section">
        <div class="container">
            <h2><i class="fas fa-headset"></i> Contact Us</h2>
            <p class="subtitle-text">We're here to help with your facility reservation needs</p>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="contact-info-card">
                        <h4>Get in Touch</h4>
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h5>Address</h5>
                                <p>Sta. Lucia, Santa Ana, Pampanga, Philippines</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <h5>Phone</h5>
                                <p>+63 (2) 8123-4567<br>+63 (2) 8765-4321</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h5>Email</h5>
                                <p>facilities@hcc.edu.ph<br>support@hcc.edu.ph</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h5>Office Hours</h5>
                                <p>Monday - Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM - 12:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-4">
                    <div class="contact-form-card">
                        <h4><i class="fas fa-paper-plane"></i> Send Us a Message</h4>
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="contact-input" placeholder="Your Full Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="contact-input" placeholder="Your Email Address" required>
                                </div>
                            </div>
                            <input type="text" class="contact-input" placeholder="Subject" required>
                            <textarea class="contact-textarea" placeholder="Your Message" required></textarea>
                            <button type="submit" class="btn-contact">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <img src="https://amyfoundationph.com/home/wp-content/uploads/2022/07/hcc.gif" alt="Holy Cross College Logo">
                                <span>Holy Cross College</span>
                            </div>
                            <p>Empowering minds, transforming lives. Holy Cross College is dedicated to providing excellence in education and fostering a community of lifelong learners and leaders.</p>
                            <div class="social-links">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <h5>Quick Links</h5>
                            <ul class="footer-links">
                                <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                                <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                                <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-chevron-right"></i> Login</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="fas fa-chevron-right"></i> Register</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h5>Facilities</h5>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fas fa-chevron-right"></i> Conference Rooms</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i> Lecture Halls</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i> Sports Complex</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i> Auditorium</a></li>
                                <li><a href="#"><i class="fas fa-chevron-right"></i> Study Rooms</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h5>Contact Info</h5>
                            <ul class="footer-contact-info">
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Sta. Lucia, Santa Ana, Pampanga, Philippines</span>
                                </li>
                                <li>
                                    <i class="fas fa-phone"></i>
                                    <span>+63 (2) 8123-4567</span>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i>
                                    <span>info@hcc.edu.ph</span>
                                </li>
                                <li>
                                    <i class="fas fa-globe"></i>
                                    <span>www.hcc.edu.ph</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy; {{ date('Y') }} Holy Cross College. All Rights Reserved.</p>
                        <div class="footer-bottom-links">
                            <a href="#">Privacy Policy</a>
                            <a href="#">Terms of Service</a>
                            <a href="#">Cookie Policy</a>
                            <a href="#">Accessibility</a>
                        </div>
                        <p style="margin-top: 20px; font-size: 0.9rem;">
                            <i class="fas fa-code"></i> Developed with <i class="fas fa-heart" style="color: var(--hcc-gold);"></i> by Holy Cross College IT Department
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- MORE ABOUT HCC MODAL  -->
    <div class="modal fade" id="moreAboutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-university"></i> More About Holy Cross College
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- FOUNDER SECTION -->
                    <div class="founder-card">
                        <img src="https://holycrosscollegepampanga.edu.ph/wp-content/uploads/2026/01/316291177_5666782673435816_4213214202426841078_n-819x1024.jpg" alt="Very Rev. Msgr. Fernando C. Lansangan" class="founder-image">
                        <div class="founder-info">
                            <h3>Very Rev. Msgr. Fernando C. Lansangan</h3>
                            <h5>Founder, Holy Cross College</h5>
                            <p style="color: #555; margin-bottom: 5px;"><strong>Founded:</strong> November 29, 1945</p>
                            <p style="color: #555;">"The School With A Heart" - Established Holy Cross Academy as the first private Catholic school in Sta. Ana, Pampanga. His vision continues to inspire generations of students to pursue excellence with faith and service.</p>
                        </div>
                    </div>
                    
                    <!-- EVENT GALLERY SECTION -->
                    <div class="event-gallery">
                        <h4><i class="fas fa-images"></i> College Events & Memories</h4>
                        <div class="gallery-grid">
                            <div class="gallery-item">
                                <img src="{{ asset('images/1.jpg') }}" alt="Logo">" alt="Foundation Day Celebration">
                                <div class="gallery-caption">Foundation Day</div>
                            </div>
                            <div class="gallery-item">
                               <img src="{{ asset('images/2.jpg') }}" alt="Logo"> alt="Intramurals">
                                <div class="gallery-caption">Intramurals</div>
                            </div>
                            <div class="gallery-item">
                                <img src="{{ asset('images/3.png') }}" alt="Logo"> alt="BOTB">
                                <div class="gallery-caption">Battle of the Bands</div>
                            </div>
                            <div class="gallery-item">
                                <img src="{{ asset('images/4.jpg') }}" alt="Logo"> alt="Concert">
                                <div class="gallery-caption">Concert Night</div>
                            </div>
                            <div class="gallery-item">
                                <img src="{{ asset('images/5.png') }}" alt="Logo"> alt="Film Festival">
                                <div class="gallery-caption">Film Festival</div>
                            </div>
                            <div class="gallery-item">
                                <img src="{{ asset('images/6.jpg') }}" alt="Logo"> alt="Color Run">
                                <div class="gallery-caption">Color Run</div>
                            </div>
                            <div class="gallery-item">
                                <img src="{{ asset('images/7.png') }}" alt="Logo"> alt="Krus Festival">
                                <div class="gallery-caption">Krus Festival</div>
                            </div>
                            <div class="gallery-item">
                                <img src="{{ asset('images/8.jpg') }}" alt="Logo"> alt="Speech Choir">
                                <div class="gallery-caption">Speech Choir Contest</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FACTS SECTION -->
                    <div class="facts-list">
                        <h4><i class="fas fa-lightbulb"></i> HCC Facts & Milestones</h4>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="fact-text">
                                <strong>Established</strong>
                                <p>Founded on November 29, 1945 - The first private Catholic school in Sta. Ana, Pampanga</p>
                            </div>
                        </div>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-user-tie"></i></div>
                            <div class="fact-text">
                                <strong>Founder's Vision</strong>
                                <p>Very Rev. Msgr. Fernando C. Lansangan established Holy Cross Academy with the generous support of civic-minded citizens of the town</p>
                            </div>
                        </div>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="fact-text">
                                <strong>First Graduates</strong>
                                <p>The first batch of graduates received their diplomas in 1946, paving the way for future generations</p>
                            </div>
                        </div>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-building"></i></div>
                            <div class="fact-text">
                                <strong>Campus Expansion</strong>
                                <p>From a single building in 1945 to a full-scale college campus with modern facilities serving thousands of students</p>
                            </div>
                        </div>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-heart"></i></div>
                            <div class="fact-text">
                                <strong>The School With A Heart</strong>
                                <p>HCC is known for its commitment to community service and holistic education, earning the beloved nickname "The School With A Heart"</p>
                            </div>
                        </div>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-globe"></i></div>
                            <div class="fact-text">
                                <strong>Global Alumni</strong>
                                <p>HCC alumni can be found across the globe, serving as leaders in education, business, government, and various professions</p>
                            </div>
                        </div>
                        
                        <div class="fact-item">
                            <div class="fact-icon"><i class="fas fa-star"></i></div>
                            <div class="fact-text">
                                <strong>Core Values</strong>
                                <p>Fides (Faith), Caritas (Charity), Libertas (Liberty) - The guiding principles that shape every HCC student</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <a href="#contact" class="btn" style="background: var(--hcc-gold); color: var(--hcc-blue); font-weight: 700;" data-bs-dismiss="modal">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        <div class="modal-error">
                            <i class="fas fa-exclamation-circle"></i> Login failed. Please check your credentials.
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group-modal">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="your.email@user" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group-modal">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>

                    <div class="modal-footer-text">
                        Don't have an account? 
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                            Sign Up
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-graduate"></i> Create Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        <div class="modal-error">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group-modal">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                        </div>
                        <div class="form-group-modal">
                            <label for="register-email">Email Address</label>
                            <input type="email" id="register-email" name="email" placeholder="example@user" required value="{{ old('email') }}">
                            <span class="info-badge">Must end with <strong>@user</strong></span>
                        </div>
                        <div class="form-group-modal">
                            <label for="register-password">Password</label>
                            <input type="password" id="register-password" name="password" placeholder="Create a secure password" required>
                        </div>
                        <div class="form-group-modal">
                            <label for="register-password-confirm">Confirm Password</label>
                            <input type="password" id="register-password-confirm" name="password_confirmation" placeholder="Confirm your password" required>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check-circle"></i> Create Account
                        </button>
                    </form>

                    <div class="modal-footer-text">
                        Already have an account? 
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-show login modal if there are login errors
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->any())
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe feature cards
            document.querySelectorAll('.feature-card, .about-card, .contact-info-card, .contact-form-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>