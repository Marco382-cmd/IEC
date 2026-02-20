<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iBaan Electric Corporation - Customer Service Portal</title>
     @vite('resources/css/style.css')


</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="/images/rb.png" alt="Logo" class="logo-img">
                <div class="company-info">
                    <h1>iBaan Electric Corporation</h1>
                    <p>Serving the Community Since 1947</p>
                </div>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#services">Services</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Welcome to Our Customer Service Portal</h2>
            <p>Submit your service requests online quickly and easily. Choose from our available services below.</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="container" id="services">
        <div class="services-grid">
            <!-- New Connection -->
           <div class="service-card" onclick="location.href='{{ route('services.new-connection') }}'">   
                <div class="service-icon">⚡</div>
                <h3>New Connection</h3>
                <p>Apply for a new electrical connection to your property. Complete all requirements and attend our seminar.</p>
            </div>

            <!-- Reconnection/Disconnection -->
            <div class="service-card" onclick="location.href='{{ route('services.reconnection') }}'"> 
                <div class="service-icon">🔌</div>
                <h3>Reconnection / Disconnection</h3>
                <p>Request reconnection of your meter or temporary disconnection service.</p>
            </div>

            <!-- Senior Citizen Discount -->
             <div class="service-card" onclick="location.href='{{ route('services.senior-citizen') }}'">
                <div class="service-icon">👴</div>
                <h3>Senior Citizen Discount</h3>
                <p>Apply for senior citizen electricity discount. Submit your requirements and get approved.</p>
            </div>

            <!-- Change Information -->
            <div class="service-card" onclick="location.href='{{ route('services.change-info') }}'">
                <div class="service-icon">📝</div>
                <h3>Change Information</h3>
                <p>Update your account information, name, address, or contact details.</p>
            </div>

            <!-- Change Meter -->
           <div class="service-card" onclick="location.href='{{ route('services.change-meter') }}'">
                <div class="service-icon">📊</div>
                <h3>Change Meter</h3>
                <p>Request meter replacement for defective, burned, or overload meters.</p>
            </div>

            <!-- Net Metering -->
             <div class="service-card" onclick="location.href='{{ route('services.net-metering') }}'">
                <div class="service-icon">☀️</div>
                <h3>Net Metering</h3>
                <p>Apply for net metering if you have solar panels or renewable energy systems.</p>
            </div>

            <!-- No Power Complaint -->
            <div class="service-card" onclick="location.href='{{ route('services.no-power') }}'">
                <div class="service-icon">⚠️</div>
                <h3>No Power / Outage</h3>
                <p>Report power outages or electrical issues in your area.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> iBaan Electric Corporation. All rights reserved.</p>
            <p>Serving the community since 1947</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>