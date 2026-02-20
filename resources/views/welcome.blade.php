<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>iBaan Electric Corporation - Customer Service Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-content">
             <div class="logo-section">
                <img src="/images/rb.png" alt="Logo" class="logo-img">
                <div class="company-info">
                    <h1>iBaan Electric Corporation</h1>
                    <p>Serving the Community Since 1947</p>
                </div>
            </div>
            
        </div>
    </header>

    <!-- MAIN -->
    <main class="container">

        <!-- HERO -->
        <section class="hero">
            <h2>Welcome to Our Customer Service Portal</h2>
            <p>Submit your service requests online quickly and easily. Choose from our available services below.</p>
        </section>

        <!-- INFO PILLS -->
        <div class="info-bar">
            <div class="info-pill">
                <span class="dot"></span>
                Online Services Available 24/7
            </div>
            <div class="info-pill">
                📞 Hotline: (043) 000-0000
            </div>
            <div class="info-pill">
                🕐 Office Hours: Mon–Fri, 8AM–5PM
            </div>
        </div>

        <!-- SERVICES -->
        <div class="section-title">
            <h3>Our Services</h3>
            <p>Select the service you need and we'll guide you through the process.</p>
        </div>

        <div class="services-grid">

            <div class="service-card">
                <div class="service-icon">⚡</div>
                <h3>New Connection</h3>
                <p>Apply for a new electrical connection to your property. Complete all requirements and attend our seminar.</p>
                <a href="{{ route('services.new-connection') }}" class="card-btn">Apply Now</a>
            </div>

            <div class="service-card">
                <div class="service-icon">🔌</div>
                <h3>Reconnection / Disconnection</h3>
                <p>Request reconnection of your meter or temporary disconnection service.</p>
                <a href="{{ route('services.reconnection') }}" class="card-btn">Request</a>
            </div>

            <div class="service-card">
                <div class="service-icon">👴</div>
                <h3>Senior Citizen Discount</h3>
                <p>Apply for senior citizen electricity discount. Submit your requirements and get approved.</p>
                <a href="{{ route('services.senior-citizen') }}" class="card-btn">Apply Now</a>
            </div>

            <div class="service-card">
                <div class="service-icon">📝</div>
                <h3>Change Information</h3>
                <p>Update your account information, name, address, or contact details.</p>
                <a href="{{ route('services.change-info') }}" class="card-btn">Update Info</a>
            </div>

            <div class="service-card">
                <div class="service-icon">📊</div>
                <h3>Change Meter</h3>
                <p>Request meter replacement for defective, burned, or overload meters.</p>
                <a href="{{ route('services.change-meter') }}" class="card-btn">Request</a>
            </div>

            <div class="service-card">
                <div class="service-icon">☀️</div>
                <h3>Net Metering</h3>
                <p>Apply for net metering if you have solar panels or renewable energy systems.</p>
                <a href="{{ route('services.net-metering') }}" class="card-btn">Apply Now</a>
            </div>

            <div class="service-card">
                <div class="service-icon">⚠️</div>
                <h3>No Power / Outage</h3>
                <p>Report power outages or electrical issues in your area.</p>
                <a href="{{ route('services.no-power') }}" class="card-btn">Report Now</a>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© iBaan Electric Corporation. All rights reserved.</p>
        <p>Serving the community since 1947</p>
    </footer>

</body>
</html>