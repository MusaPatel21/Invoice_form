<?php
require('fpdf186/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firm = $_POST['dropdown1'];
    $vendorName = $_POST['vendorName'];
    $vendorMobile = $_POST['vendorMobile'];
    $vendorAddress = $_POST['vendorAddress'];
    $bankName = $_POST['bankName'];
    $branch = $_POST['branch'];
    $accountNo = $_POST['accountNo'];
    $ifscCode = $_POST['ifscCode'];
    $additionalInstructions = $_POST['additionalInstructions'];
    $grandTotal = $_POST['grand_total'];

    // Get product data
    $productNames = $_POST['pname'];
    $prices = $_POST['price'];
    $quantities = $_POST['qty'];
    $totals = $_POST['total'];

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(0);

    $pdf->MultiCell(100, 10, 'Firm: ' . $firm, 0, 'L');
    $pdf->SetY(10); // Reset Y position for the next column
    $pdf->SetX(150); // Move to the right for the second column
    $pdf->MultiCell(0, 10, 'Purchase Order', 0, 'L');

    $pdf->SetX(150); // Move to the right for the second column
    $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1);
    // Vendor Information
    $pdf->Ln(10);

    // Highlighted Vendor Information
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Vendor Information', '0', 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Vendor Name: ' . $vendorName, 0, 1);
    $pdf->Cell(0, 10, 'Vendor Mobile: ' . $vendorMobile, 0, 1);

    // Ship To Information
    
    $pdf->SetY(40);
    $pdf->SetX(120);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Ship To', '0', 1);
    $pdf->SetX($pdf->GetX() - $pdf->GetStringWidth('Ship To'));
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetX(120); 
    $pdf->Cell(120, 10, '' . $vendorAddress, 0, 1);
    $pdf->Ln(10);
    // Date on top right
    // Table with 4 columns
    $pdf->SetFont('Arial', 'B', 12);

    // Column names
    $pdf->Cell(40, 10, 'Requisitioner', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Ship Via', 1, 0, 'C');
    $pdf->Cell(40, 10, 'F.O.B', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Shipping Terms', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 12);

    // Add values for each column (replace with actual data)
    $pdf->Cell(40, 10, '', 1);
    $pdf->Cell(40, 10, '', 1);
    $pdf->Cell(40, 10, '', 1);
    $pdf->Cell(40, 10, '', 1, 1);

    // Product Details
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->SetFont('Arial', '', 12);

    // Display Table headings
    $pdf->Cell(80, 9, "Product", 1, 0);
    $pdf->Cell(40, 9, "PRICE", 1, 0, "C");
    $pdf->Cell(30, 9, "QTY", 1, 0, "C");
    $pdf->Cell(40, 9, "TOTAL", 1, 1, "C");
    $pdf->SetFont('Arial', '', 12);

    // Display table product rows
    for ($i = 0; $i < count($productNames); $i++) {
        $pdf->Cell(80, 9, $productNames[$i], 1);
        $pdf->Cell(40, 9, $prices[$i], 1, 0, "R");
        $pdf->Cell(30, 9, $quantities[$i], 1, 0, "C");
        $pdf->Cell(40, 9, $totals[$i], 1, 1, "R");
    }

    // Display table empty rows
    for ($i = count($productNames); $i < 12; $i++) {
        $pdf->Cell(80, 9, "", 1);
        $pdf->Cell(40, 9, "", 1, 0, "R");
        $pdf->Cell(30, 9, "", 1, 0, "C");
        $pdf->Cell(40, 9, "", 1, 1, "R");
    }

    // Bank Details and Additional Instructions within a box
    $pdf->Ln(10);
    $pdf->Rect(10, $pdf->GetY(), 120, 40); // Draw a rectangle

    $pdf->Cell(0, 10, 'Bank Details', '0', 1);
    $pdf->Cell(0, 5, 'Bank Name: ' . $bankName, 0, 1);
    $pdf->Cell(0, 5, 'Branch: ' . $branch, 0, 1);
    $pdf->Cell(0, 5, 'Account No: ' . $accountNo, 0, 1);
    $pdf->Cell(0, 5, 'IFSC Code: ' . $ifscCode, 0, 1);

    // Grand Total
    $pdf->Ln(-30);
    
    $pdf->Cell(0, 10, 'Grand Total: ' . $grandTotal, 0, 1, 'R'); // Align to the right

    // Save or output the PDF
    $pdf->Output('invoice.pdf', 'D');
}
?>
