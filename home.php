<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Parking Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* Navbar */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Carousel Hero */
        .carousel-item {
            height: 90vh;
            position: relative;
        }

        .carousel-item img {
            height: 100%;
            object-fit: cover;
            filter: brightness(50%);
        }

        .carousel-caption {
            bottom: 30%;
        }

        .carousel-caption h1 {
            font-size: 3rem;
            font-weight: bold;
            animation: fadeIn 2s ease-in;
        }

        .carousel-caption p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Features */
        .feature-card {
            padding: 20px;
            border-radius: 10px;
            transition: 0.3s;
            background: #f8f9fa;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Parking System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Login</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="users/login.php">User Login</a></li>
                            <li><a class="dropdown-item" href="admin/index.php">Admin Login</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel Hero Section -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1506521781263-d8422e82f27a" class="d-block w-100">
                <div class="carousel-caption">
                    <h1>Vehicle Parking Management System</h1>
                    <p>Smart & Easy Way to Manage Your Parking Efficiently</p>
                    <a href="users/login.php" class="btn btn-light btn-lg me-2">
                      Book Parking
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg">
                      Learn More
                    </a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://5.imimg.com/data5/SELLER/Default/2022/5/MM/OI/CJ/49056417/parking-management-system.jpg"
                    class="d-block w-100">
                <div class="carousel-caption">
                    <h1>Easy Slot Booking</h1>
                    <p>Reserve your parking space in seconds</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70" class="d-block w-100">
                <div class="carousel-caption">
                    <h1>Secure & Reliable</h1>
                    <p>Safe parking management system</p>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Features -->
    <section id="features" class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Our Features</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="feature-card">
                        <h4>Easy Booking</h4>
                        <p>Book parking slots quickly and easily.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <h4>Secure</h4>
                        <p>Safe and secure login system.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <h4>Dashboard</h4>
                        <p>Admin dashboard for full control.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <h4>Real-Time Availability</h4>
                        <p>Check available parking slots instantly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="bg-light py-5">
        <div class="container text-center">
            <h2>Contact Us</h2>
            <p>Email: support@parking.com | Phone: +91 9876543210</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2026 Vehicle Parking Management System</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
