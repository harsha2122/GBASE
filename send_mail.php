<?php
/**
 * GBASE Contact Form Mail Handler
 * Receives POST data from all .gbase-contact-form forms and sends an email
 * to gbasetechnologies.info@gmail.com
 *
 * Works with Hostinger shared hosting (php mail() is supported out of the box).
 * The From address uses the site domain so Hostinger's MTA accepts it.
 * The Reply-To is set to the visitor's email so you can reply directly.
 */

header('Content-Type: application/json; charset=UTF-8');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// -----------------------------------------------------------------------
// Helper: sanitise a plain text value
// -----------------------------------------------------------------------
function clean(string $value): string {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

// -----------------------------------------------------------------------
// Collect & sanitise all possible fields
// -----------------------------------------------------------------------
$company            = clean($_POST['company']            ?? '');
$name               = clean($_POST['name']               ?? '');
$city               = clean($_POST['city']               ?? '');
$country            = clean($_POST['country']            ?? '');
$country_other      = clean($_POST['country_other']      ?? '');
$email              = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
$phone              = clean($_POST['phone']              ?? '');
$website            = clean($_POST['website']            ?? '');
$message            = clean($_POST['message']            ?? '');
$product_type       = clean($_POST['product_type']       ?? '');   // single select (contact.html)
$equipment_interest = clean($_POST['equipment_interest'] ?? '');
$business_type      = clean($_POST['business_type']      ?? '');
$production         = clean($_POST['production']         ?? '');
$referral           = clean($_POST['referral']           ?? '');
$page_source        = clean($_POST['page_source']        ?? 'Unknown page');

// Multi-checkbox arrays (process / freezing / heating pages)
$product_types       = isset($_POST['product_types'])       ? array_map('clean', (array) $_POST['product_types'])       : [];
$pre_process         = isset($_POST['pre_process'])         ? array_map('clean', (array) $_POST['pre_process'])         : [];
$freezing_equipment  = isset($_POST['freezing_equipment'])  ? array_map('clean', (array) $_POST['freezing_equipment'])  : [];
$heating_equipment   = isset($_POST['heating_equipment'])   ? array_map('clean', (array) $_POST['heating_equipment'])   : [];
$products            = clean($_POST['products']            ?? '');
$cut_sizes           = clean($_POST['cut_sizes']           ?? '');
$capacities          = clean($_POST['capacities']          ?? '');
$others_specify      = clean($_POST['others_specify']      ?? '');

// -----------------------------------------------------------------------
// Validate required fields
// -----------------------------------------------------------------------
if (empty($company) || empty($name) || empty($email) || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Company, Name, Email, Phone).']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// -----------------------------------------------------------------------
// Build email body
// -----------------------------------------------------------------------
$final_country = ($country === 'Others' && !empty($country_other)) ? $country_other : $country;

$lines = [];
$lines[] = "New enquiry from the GBASE website";
$lines[] = "Page: {$page_source}";
$lines[] = str_repeat('-', 50);
$lines[] = "Company:              {$company}";
$lines[] = "Contact Name:         {$name}";
$lines[] = "Email:                {$email}";
$lines[] = "Phone:                {$phone}";
$lines[] = "City:                 {$city}";
$lines[] = "Country:              {$final_country}";

if (!empty($website))   $lines[] = "Website:              {$website}";
if (!empty($message))   $lines[] = "\nMessage / Needs:\n{$message}";

$lines[] = str_repeat('-', 50);

// Product / process fields (present on contact/consulting/equipment pages)
if (!empty($product_type))        $lines[] = "Product Type:         {$product_type}";
if (!empty($equipment_interest))  $lines[] = "Equipment Interest:   {$equipment_interest}";
if (!empty($business_type))       $lines[] = "Type of Business:     {$business_type}";
if (!empty($production))          $lines[] = "Production (tons/hr): {$production}";
if (!empty($referral))            $lines[] = "How they found us:    {$referral}";

// Process-page specific fields
if (!empty($products))            $lines[] = "Products:             {$products}";
if (!empty($cut_sizes))           $lines[] = "Cut Sizes:            {$cut_sizes}";
if (!empty($capacities))          $lines[] = "Capacities:           {$capacities}";
if (!empty($others_specify))      $lines[] = "Others (Specify):     {$others_specify}";

// Multi-checkbox groups
if (!empty($product_types))       $lines[] = "Product Types:        " . implode(', ', $product_types);
if (!empty($pre_process))         $lines[] = "Pre-Process Steps:    " . implode(', ', $pre_process);
if (!empty($freezing_equipment))  $lines[] = "Freezing Equipment:   " . implode(', ', $freezing_equipment);
if (!empty($heating_equipment))   $lines[] = "Heating Equipment:    " . implode(', ', $heating_equipment);

$body = implode("\n", $lines);

// -----------------------------------------------------------------------
// Send email via PHP mail()
// -----------------------------------------------------------------------
$to      = 'gbasetechnologies.info@gmail.com';
$subject = "GBASE Enquiry from {$company} ({$final_country})";

// Use a domain address in From so Hostinger's MTA accepts it.
// Change the domain below to match your actual domain on Hostinger.
$from_name    = 'GBASE Website';
$from_address = 'noreply@gbasetechnologies.com'; // update if your domain differs

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "From: {$from_name} <{$from_address}>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "X-Mailer: PHP/" . PHP_VERSION;

if (mail($to, $subject, $body, $headers)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent. We will get back to you shortly.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, there was a problem sending your message. Please try again or contact us directly at gbasetechnologies.info@gmail.com'
    ]);
}
