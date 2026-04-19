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
function clean(string $value): string
{
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

function field_in_list(string $name, array $field_list): bool
{
    return empty($field_list) || in_array($name, $field_list, true);
}

function field_prefix_in_list(string $prefix, array $field_list): bool
{
    if (empty($field_list)) return true;
    foreach ($field_list as $name) {
        if (strpos($name, $prefix) === 0) return true;
    }
    return false;
}

// -----------------------------------------------------------------------
// Collect & sanitise all possible fields
// -----------------------------------------------------------------------
$company = clean($_POST['company'] ?? '');
$name = clean($_POST['name'] ?? '');
$city = clean($_POST['city'] ?? '');
$country = clean($_POST['country'] ?? '');
$country_other = clean($_POST['country_other'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = clean($_POST['phone'] ?? '');
$website = clean($_POST['website'] ?? '');
$machine_serial_no = clean($_POST['machine_serial_no'] ?? '');
$message = clean($_POST['message'] ?? '');
$product_type = clean($_POST['product_type'] ?? '');   // single select (contact.html)
$equipment_interest = clean($_POST['equipment_interest'] ?? '');
$business_type = clean($_POST['business_type'] ?? '');
$production = clean($_POST['production'] ?? '');
$referral = clean($_POST['referral'] ?? '');
$page_source = clean($_POST['page_source'] ?? 'Unknown page');
$field_list_raw = $_POST['_field_list'] ?? '';
$field_list = [];
if (!empty($field_list_raw)) {
    $decoded = json_decode($field_list_raw, true);
    if (is_array($decoded)) {
        foreach ($decoded as $item) {
            if (is_string($item) && $item !== '') {
                $field_list[] = clean($item);
            }
        }
    }
}

// Multi-checkbox arrays (process / freezing / heating pages)
$product_types = isset($_POST['product_types']) ? array_map('clean', (array) $_POST['product_types']) : [];
$pre_process = isset($_POST['pre_process']) ? array_map('clean', (array) $_POST['pre_process']) : [];
$freezing_equipment = isset($_POST['freezing_equipment']) ? array_map('clean', (array) $_POST['freezing_equipment']) : [];
$heating_equipment = isset($_POST['heating_equipment']) ? array_map('clean', (array) $_POST['heating_equipment']) : [];
$equipment_options = isset($_POST['equipment_options']) ? array_map('clean', (array) $_POST['equipment_options']) : [];
$products = clean($_POST['products'] ?? '');
$cut_sizes = clean($_POST['cut_sizes'] ?? '');
$capacities = clean($_POST['capacities'] ?? '');
$others_specify = clean($_POST['others_specify'] ?? '');
$fruit_others_specify = clean($_POST['fruit_others_specify'] ?? '');
$sorting_criteria_other = clean($_POST['sorting_criteria_other'] ?? '');
$part_serial_no = isset($_POST['part_serial_no']) ? array_map('clean', (array) $_POST['part_serial_no']) : [];
$quantity_required = isset($_POST['quantity_required']) ? array_map('clean', (array) $_POST['quantity_required']) : [];
$sorting_criteria = isset($_POST['sorting_criteria']) ? array_map('clean', (array) $_POST['sorting_criteria']) : [];

// -----------------------------------------------------------------------
// Validate required fields
// -----------------------------------------------------------------------
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
if (field_in_list('company', $field_list)) $lines[] = "Company:              {$company}";
if (field_in_list('name', $field_list)) $lines[] = "Contact Name:         {$name}";
if (field_in_list('email', $field_list)) $lines[] = "Email:                {$email}";
if (field_in_list('phone', $field_list)) $lines[] = "Phone:                {$phone}";
if (field_in_list('city', $field_list)) $lines[] = "City:                 {$city}";
if (field_in_list('country', $field_list)) $lines[] = "Country:              {$final_country}";

if (field_in_list('website', $field_list)) $lines[] = "Website:              {$website}";
if (field_in_list('machine_serial_no', $field_list)) $lines[] = "Machine Serial No.:   {$machine_serial_no}";
if (field_in_list('message', $field_list)) $lines[] = "\nMessage / Needs:\n{$message}";

$lines[] = str_repeat('-', 50);

// Product / process fields (present on contact/consulting/equipment pages)
if (field_in_list('product_type', $field_list)) $lines[] = "Product Type:         {$product_type}";
if (field_in_list('equipment_interest', $field_list)) $lines[] = "Equipment Interest:   {$equipment_interest}";
if (field_in_list('business_type', $field_list)) $lines[] = "Type of Business:     {$business_type}";
if (field_in_list('production', $field_list)) $lines[] = "Production (tons/hr): {$production}";
if (field_in_list('referral', $field_list)) $lines[] = "How they found us:    {$referral}";

// Process-page specific fields
if (field_in_list('products', $field_list)) $lines[] = "Products:             {$products}";
if (field_in_list('cut_sizes', $field_list)) $lines[] = "Cut Sizes:            {$cut_sizes}";
if (field_in_list('capacities', $field_list)) $lines[] = "Capacities:           {$capacities}";
if (field_in_list('others_specify', $field_list)) $lines[] = "Others (Specify):     {$others_specify}";
if (field_in_list('fruit_others_specify', $field_list)) $lines[] = "Fruit Others:         {$fruit_others_specify}";
if (field_in_list('sorting_criteria_other', $field_list)) $lines[] = "Sorting Criteria Other: {$sorting_criteria_other}";

// Multi-checkbox groups
if (field_in_list('product_types[]', $field_list)) $lines[] = "Product Types:        " . implode(', ', $product_types);
if (field_in_list('pre_process[]', $field_list)) $lines[] = "Pre-Process Steps:    " . implode(', ', $pre_process);
if (field_in_list('freezing_equipment[]', $field_list)) $lines[] = "Freezing Equipment:   " . implode(', ', $freezing_equipment);
if (field_in_list('heating_equipment[]', $field_list)) $lines[] = "Heating Equipment:    " . implode(', ', $heating_equipment);
if (field_in_list('equipment_options[]', $field_list)) $lines[] = "Sorting Options:      " . implode(', ', $equipment_options);
if (field_in_list('sorting_criteria[]', $field_list)) $lines[] = "Sorting Criteria:     " . implode(', ', $sorting_criteria);

// Spare parts details
if (
    field_in_list('part_serial_no[]', $field_list) ||
    field_in_list('quantity_required[]', $field_list) ||
    field_prefix_in_list('part_picture_', $field_list)
) {
    $lines[] = str_repeat('-', 50);
    $lines[] = "Part Details:";
    $max_rows = max(count($part_serial_no), count($quantity_required));
    if ($max_rows === 0) {
        $lines[] = "(none)";
    } else {
        // Collect pictures by row index based on input name like part_picture_1[]
        $pictures_by_row = [];
        foreach ($_FILES as $input_name => $file_set) {
            if (!preg_match('/^part_picture_(\d+)$/', $input_name, $m)) {
                continue;
            }
            $row_index = (int) $m[1]; // 1-based
            $pictures_by_row[$row_index] = $pictures_by_row[$row_index] ?? [];
            if (!isset($file_set['name']) || !is_array($file_set['name'])) {
                continue;
            }
            foreach ($file_set['name'] as $i => $name) {
                if (empty($name)) {
                    continue;
                }
                $pictures_by_row[$row_index][] = $name;
            }
        }

        for ($i = 0; $i < $max_rows; $i++) {
            $row_no = $i + 1;
            $serial = $part_serial_no[$i] ?? '';
            $qty = $quantity_required[$i] ?? '';
            $pics = $pictures_by_row[$row_no] ?? [];
            $lines[] = "Row {$row_no} - Serial No: {$serial} | Qty: {$qty} | Pictures: " . implode(', ', $pics);
        }
    }
}

$body = implode("\n", $lines);

// -----------------------------------------------------------------------
// Send email via PHP mail()
// -----------------------------------------------------------------------
$to = trim('gbasetechnologies.info@gmail.com');
$subject = "GBASE Enquiry from {$company} ({$final_country})";

// Use a domain address in From so Hostinger's MTA accepts it.
// Change the domain below to match your actual domain on Hostinger.
$from_name = 'GBASE Website';
$from_address = 'noreply@gbasetechnologies.com'; // update if your domain differs

$headers = "MIME-Version: 1.0\r\n";
$headers .= "From: {$from_name} <{$from_address}>\r\n";
if (!empty($email)) {
    $headers .= "Reply-To: {$name} <{$email}>\r\n";
}
$headers .= "X-Mailer: PHP/" . PHP_VERSION;

// -----------------------------------------------------------------------
// Attach images if provided (multipart/mixed)
// -----------------------------------------------------------------------
$attachments = [];
$upload_errors = [];
$max_attachment_bytes = 4 * 1024 * 1024; // 4 MB per file
$max_total_bytes = 10 * 1024 * 1024; // 10 MB total
$total_bytes = 0;

function upload_error_message(int $code): string
{
    switch ($code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'File exceeds server upload limit.';
        case UPLOAD_ERR_FORM_SIZE:
            return 'File exceeds form upload limit.';
        case UPLOAD_ERR_PARTIAL:
            return 'File was only partially uploaded.';
        case UPLOAD_ERR_NO_FILE:
            return 'No file uploaded.';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder on server.';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk.';
        case UPLOAD_ERR_EXTENSION:
            return 'A PHP extension stopped the file upload.';
        default:
            return 'Unknown upload error.';
    }
}

foreach ($_FILES as $input_name => $file_set) {
    if (!isset($file_set['tmp_name'])) {
        continue;
    }
    $names = $file_set['name'];
    $tmp_names = $file_set['tmp_name'];
    $types = $file_set['type'];
    $errors = $file_set['error'];

    if (is_array($tmp_names)) {
        foreach ($tmp_names as $i => $tmp) {
            if (!isset($errors[$i])) {
                continue;
            }
            if ($errors[$i] !== UPLOAD_ERR_OK) {
                if ($errors[$i] !== UPLOAD_ERR_NO_FILE) {
                    $upload_errors[] = ($names[$i] ?? 'attachment') . ': ' . upload_error_message((int) $errors[$i]);
                }
                continue;
            }
            if (empty($tmp)) {
                continue;
            }
            $size = isset($file_set['size'][$i]) ? (int) $file_set['size'][$i] : 0;
            if ($size > $max_attachment_bytes) {
                $upload_errors[] = ($names[$i] ?? 'attachment') . ': File too large for email attachment.';
                continue;
            }
            if ($total_bytes + $size > $max_total_bytes) {
                $upload_errors[] = ($names[$i] ?? 'attachment') . ': Total attachment size exceeded.';
                continue;
            }
            $total_bytes += $size;
            $attachments[] = [
                'name' => $names[$i] ?? ('attachment_' . $i),
                'tmp' => $tmp,
                'type' => $types[$i] ?? 'application/octet-stream'
            ];
        }
    } else {
        if ($errors !== UPLOAD_ERR_OK) {
            if ($errors !== UPLOAD_ERR_NO_FILE) {
                $upload_errors[] = ($names ?: 'attachment') . ': ' . upload_error_message((int) $errors);
            }
            continue;
        }
        if (!empty($tmp_names)) {
            $size = isset($file_set['size']) ? (int) $file_set['size'] : 0;
            if ($size > $max_attachment_bytes) {
                $upload_errors[] = ($names ?: 'attachment') . ': File too large for email attachment.';
                continue;
            }
            if ($total_bytes + $size > $max_total_bytes) {
                $upload_errors[] = ($names ?: 'attachment') . ': Total attachment size exceeded.';
                continue;
            }
            $total_bytes += $size;
            $attachments[] = [
                'name' => $names ?: 'attachment',
                'tmp' => $tmp_names,
                'type' => $types ?: 'application/octet-stream'
            ];
        }
    }
}

if (!empty($upload_errors)) {
    $lines[] = str_repeat('-', 50);
    $lines[] = "Upload Notes:";
    foreach ($upload_errors as $err) {
        $lines[] = "- {$err}";
    }
    $body = implode("\n", $lines);
}

if (!empty($attachments)) {
    $boundary = "gbase_boundary_" . md5(uniqid((string) microtime(true), true));
    $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"{$boundary}\"";

    $multipart = "--{$boundary}\r\n";
    $multipart .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $multipart .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $multipart .= $body . "\r\n";

    foreach ($attachments as $att) {
        $file_data = file_get_contents($att['tmp']);
        if ($file_data === false) {
            continue;
        }
        $file_data = chunk_split(base64_encode($file_data));
        $safe_name = preg_replace('/[^A-Za-z0-9._-]/', '_', $att['name']);

        $multipart .= "--{$boundary}\r\n";
        $multipart .= "Content-Type: {$att['type']}; name=\"{$safe_name}\"\r\n";
        $multipart .= "Content-Transfer-Encoding: base64\r\n";
        $multipart .= "Content-Disposition: attachment; filename=\"{$safe_name}\"\r\n\r\n";
        $multipart .= $file_data . "\r\n";
    }

    $multipart .= "--{$boundary}--";
    $mail_body = $multipart;
} else {
    $headers .= "\r\nContent-Type: text/plain; charset=UTF-8";
    $mail_body = $body;
}

if (mail($to, $subject, $mail_body, $headers)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent. We will get back to you shortly.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, there was a problem sending your message. Please try again or contact us directly.'
    ]);
}
