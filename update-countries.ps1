# PowerShell script to update all country dropdowns in GBASE website forms

# Define the old country dropdown pattern (with variations)
$oldPattern1 = @"
                <select style="border: 2px solid;" class="gbase-form-control" required>
                  <option selected value="India">India</option>
                  <option value="USA">Australia</option>
                  <option value="UK">Bangladesh</option>
                  <option value="UAE">Indonesia</option>
                  <option value="Australia">New Zealand</option>
                  <option value="Australia">Sri Lanka</option>
                </select>
"@

$oldPattern2 = @"
                <select class="gbase-form-control" required>
                  <option value="" disabled selected>Country *</option>
                  <option value="India">India</option>
                  <option value="USA">USA</option>
                  <option value="UK">UK</option>
                  <option value="UAE">UAE</option>
                  <option value="Australia">Australia</option>
                </select>
"@

# Define the new country dropdown with Others field
$newDropdown = @"
                <select style="border: 2px solid;" class="gbase-form-control country-select" required>
                  <option value="" disabled selected>Country *</option>
                  <option value="Australia">Australia</option>
                  <option value="Bangladesh">Bangladesh</option>
                  <option value="India">India</option>
                  <option value="Indonesia">Indonesia</option>
                  <option value="New Zealand">New Zealand</option>
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="Others">Others</option>
                </select>
"@

# Files to update
$filesToUpdate = @(
    "f:\Web\GBASE\contact.html",
    "f:\Web\GBASE\consulting.html",
    "f:\Web\GBASE\freezing.html",
    "f:\Web\GBASE\freezing\freezing.html",
    "f:\Web\GBASE\heating.html",
    "f:\Web\GBASE\heating\oven.html",
    "f:\Web\GBASE\pre-process.html",
    "f:\Web\GBASE\product.html",
    "f:\Web\GBASE\product\spiral-freezer.html",
    "f:\Web\GBASE\service.html",
    "f:\Web\GBASE\sorting.html",
    "f:\Web\GBASE\sorting\sorting.html"
)

Write-Host "Starting country dropdown updates..." -ForegroundColor Cyan

foreach ($file in $filesToUpdate) {
    if (Test-Path $file) {
        Write-Host "Processing: $file" -ForegroundColor Yellow
        
        $content = Get-Content $file -Raw
        
        # Replace old pattern 1
        $content = $content -replace [regex]::Escape($oldPattern1), $newDropdown
        
        # Replace old pattern 2
        $content = $content -replace [regex]::Escape($oldPattern2), $newDropdown
        
        # Save the updated content
        Set-Content -Path $file -Value $content -NoNewline
        
        Write-Host "  ✓ Updated successfully" -ForegroundColor Green
    } else {
        Write-Host "  ✗ File not found: $file" -ForegroundColor Red
    }
}

Write-Host "`nAll files processed!" -ForegroundColor Cyan
Write-Host "Note: You still need to add the 'Others' text field and JavaScript manually." -ForegroundColor Yellow
