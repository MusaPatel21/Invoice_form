<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce System</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        form {
            text-align: center;
        }

        label {
            margin-bottom: 10px;
        }

        #productForm {
            display: none;
            width: 80%;
            /* Set the width of the product form */
        }

        /* Style for default text in dropdown */
        .default-option {
            color: #999;
        }

        /* Style for the table in the product form */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        #grandTotal {
            margin-top: 10px;
        }

        #vendorDetails {
            margin-top: 20px;
        }

        #bankDetails {
            margin-top: 20px;
        }

        #addProductButton {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Generate Invoice</h2>

    <form method="post" action="generate_pdf.php">
        <label for="dropdown1">Select Firm</label>
        <select name="dropdown1" id="dropdown1" onchange="showProductForm('dropdown1')">
            <option value="" class="default-option">Type here to search</option>
            <option value="omunim">Omunim</option>
        </select>

        <label for="dropdown2">Select Vendor</label>
        <select name="dropdown2" id="dropdown2" onchange="showProductForm('dropdown2'); updateVendorDetails()">
            <option value="" class="default-option">Type here to search</option>
            <option value="vinay_computers" data-name="Vinay Computers" data-mobile="1234567890"
                data-address="hadapsar, pune">Vinay Computers</option>
            <!-- Add more vendors with data as needed -->
        </select>

        <br>

        <div id="productForm">
            <h3>Product Details</h3>

            <!-- Add the products as options in the dropdown list -->
            
                <!-- Add more products as needed -->
            </select>

            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id='product_tbody'>
                    <tr>
                        <!-- Modify the first cell in the table to use the product dropdown -->
                        <td><select required name='pname[]' class='form-control product-dropdown'>
                                <option value="" class="default-option">Select Product</option>
                                <option value="laptop">Laptop</option>
                                <option value="phone">Phone</option>
                                <option value="tablet">Tablet</option>
                                <!-- Add more products as needed -->
                            </select></td>
                        <td><input type='text' required name='price[]' class='form-control price'
                                oninput="calculateTotal(this)"></td>
                        <td><input type='text' required name='qty[]' class='form-control qty'
                                oninput="calculateTotal(this)"></td>
                        <td><input type='text' required name='total[]' class='form-control total' readonly></td>
                        <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'
                                onclick="removeRow(this)"> </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'
                                onclick="addRowWithProduct()"></td>
                        <td colspan='2' class='text-right'>Total</td>
                        <td><input type='text' name='grand_total' id='grand_total' class='form-control' readonly
                                required></td>
                    </tr>
                </tfoot>
            </table>

            <div id="vendorDetails">
                <h3>Vendor Details</h3>
                <label for="vendorName">Vendor Name:</label>
                <input type="text" name="vendorName" id="vendorName">
                &nbsp;&nbsp;&nbsp;
                <label for="vendorMobile">Vendor Mobile:</label>
                <input type="text" name="vendorMobile" id="vendorMobile">
                <br>
                <br>
                <label for="vendorAddress">Vendor Address:</label>
                <input type="text" name="vendorAddress" id="vendorAddress">
            </div>

            <div id="bankDetails">
                <h3>Comments & Special Instructions</h3>
                <label for="bankName">Bank Name:</label>
                <input type="text" name="bankName" id="bankName">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label for="branch">Branch:</label>
                <input type="text" name="branch" id="branch">

                <br>
                <br>
                <br>

                <label for="accountNo">Account No:</label>
                <input type="text" name="accountNo" id="accountNo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label for="ifscCode">IFSC Code:</label>
                <input type="text" name="ifscCode" id="ifscCode">

                <br>
                <br>
                <br>
                <br>

                <label for="additionalInstructions">Additional Instructions:</label>
                <textarea name="additionalInstructions" id="additionalInstructions"></textarea>
            </div>
        </div>

        <br>

        <input type="submit" value="Submit">
    </form>

    <script>
        function showProductForm(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            var productForm = document.getElementById("productForm");

            // Show product form if a valid option is selected, otherwise hide it
            productForm.style.display = (dropdown.value !== "") ? "block" : "none";
        }

        function updateVendorDetails() {
            var dropdown = document.getElementById("dropdown2");
            var vendorNameField = document.getElementById("vendorName");
            var vendorMobileField = document.getElementById("vendorMobile");
            var vendorAddressField = document.getElementById("vendorAddress");

            // Get selected vendor details from data attributes
            var selectedOption = dropdown.options[dropdown.selectedIndex];
            var vendorName = selectedOption.getAttribute("data-name") || "";
            var vendorMobile = selectedOption.getAttribute("data-mobile") || "";
            var vendorAddress = selectedOption.getAttribute("data-address") || "";

            // Update vendor details fields
            vendorNameField.value = vendorName;
            vendorMobileField.value = vendorMobile;
            vendorAddressField.value = vendorAddress;
        }

        function addRowWithProduct() {
        var table = document.getElementById("product_tbody");
        var newRow = table.insertRow(table.rows.length);
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);

        // Create a new product dropdown for the row
        var productDropdown = document.createElement('select');
        productDropdown.setAttribute('required', 'true');
        productDropdown.setAttribute('name', 'pname[]');
        productDropdown.setAttribute('class', 'form-control product-dropdown');

        // Add options to the product dropdown (modify as needed)
        var products = ['Select Product', 'Laptop', 'Phone', 'Tablet'];
        for (var i = 0; i < products.length; i++) {
            var option = document.createElement('option');
            option.value = products[i];
            option.textContent = products[i];
            productDropdown.appendChild(option);
        }

        // Add the product dropdown to the first cell in the table
        cell1.appendChild(productDropdown);

        // Add other cells and elements to the row
        cell2.innerHTML = '<input type="text" required name="price[]" class="form-control price" oninput="calculateTotal(this)">';
        cell3.innerHTML = '<input type="text" required name="qty[]" class="form-control qty" oninput="calculateTotal(this)">';
        cell4.innerHTML = '<input type="text" required name="total[]" class="form-control total" readonly>';
        cell5.innerHTML = '<input type="button" value="x" class="btn btn-danger btn-sm btn-row-remove" onclick="removeRow(this)">';

        updateGrandTotal();
    }
        function removeRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);

            updateGrandTotal();
        }

        function calculateTotal(input) {
            var row = input.parentNode.parentNode;
            var priceInput = row.cells[1].querySelector('input');
            var quantityInput = row.cells[2].querySelector('input');
            var totalInput = row.cells[3].querySelector('input');

            // Calculate total
            var price = parseFloat(priceInput.value) || 0;
            var quantity = parseFloat(quantityInput.value) || 0;
            var total = (price * quantity).toFixed(2);
            totalInput.value = total;

            updateGrandTotal();
        }

        function updateGrandTotal() {
            var table = document.getElementById("product_tbody");
            var grandTotalField = document.getElementById("grand_total");

            var grandTotal = 0;
            for (var i = 0; i < table.rows.length; i++) {
                var totalCell = table.rows[i].cells[3].querySelector('input');
                if (totalCell) {
                    grandTotal += parseFloat(totalCell.value) || 0;
                }
            }

            grandTotalField.value = grandTotal.toFixed(2);
        }
    </script>

</body>

</html>
