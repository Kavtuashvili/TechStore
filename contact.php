<?php
session_start();
include("includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>

<div class="contact-page">

    <h1 class="contact-title">📞 Contact & Help Center</h1>

    <div class="contact-card">

        <!-- SUPPORT INFO -->
        <h2>Customer Support</h2>

        <p>📧 Email: support@techstore.com</p>
        <p>📱 Phone: +995 555 123 456</p>
        <p>📍 Address: Tbilisi, Georgia</p>
        <p>🕒 Working Hours: Mon - Fri (10:00 - 18:00)</p>

        <hr>

        <!-- FAQ -->
        <h3>❓ Frequently Asked Questions</h3>

        <div class="faq-item">
            <b>How long does delivery take?</b>
            <p>Usually 2–5 business days depending on your location.</p>
        </div>

        <div class="faq-item">
            <b>Can I cancel my order?</b>
            <p>Yes, as long as the order is not shipped yet.</p>
        </div>

        <div class="faq-item">
            <b>How can I track my order?</b>
            <p>Go to “My Orders” page and open order details.</p>
        </div>

        <hr>

        <!-- NOTE -->
        <p class="note">
            If you have any issues with your order, payment or delivery,
            please contact our support team. We usually respond within 24 hours.
        </p>

    </div>

</div>
<?php include("includes/footer.php"); ?>

</body>
</html>