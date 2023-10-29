<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <style>
        /* Center the content */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        /* Style the container */
        .container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f4f4f4;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin: 0;
            font-size: 28px;
        }
        .line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }
        .line label {
            font-size: 18px;
        }
        .line select, .line input {
            flex: 1;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            font-size: 16px;
            margin-right: 10px;
        }
        .line button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }
        .line button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Currency Converter</h1>
    <div class="line">
        <input type="number" id="amount" placeholder="Insert amount" />
        <select id="sourceCurrency"></select>
    </div>
    <div class="line">
        <input type="text" id="convertedAmount" readonly />
        <select id="targetCurrency"></select>
    </div>
    <div class="line">
        <button id="convertButton">Convert</button>
    </div>
</div>
<script>
    const sourceCurrencySelect = document.getElementById("sourceCurrency");
    const amountInput = document.getElementById("amount");
    const targetCurrencySelect = document.getElementById("targetCurrency");
    const convertedAmountInput = document.getElementById("convertedAmount");
    const convertButton = document.getElementById("convertButton");

    // Fetch currencies for the source currency dropdown
    fetch("http://127.0.0.1:8000/api/currencies")
        .then(response => response.json())
        .then(data => {
            data.forEach(currency => {
                const option = document.createElement("option");
                option.value = currency.code;
                option.textContent = `${currency.code} (${currency.name})`;
                sourceCurrencySelect.appendChild(option);
            });

            // Create a single option for "EUR" in the target currency dropdown
            const euroOption = document.createElement("option");
            euroOption.value = "EUR";
            euroOption.textContent = "EUR (Euro)";
            targetCurrencySelect.appendChild(euroOption);
        })
        .catch(error => {
            console.error("Error fetching source currencies:", error);
        });

    // Event listener for the "Convert" button
    convertButton.addEventListener("click", () => {
        const sourceCurrency = sourceCurrencySelect.value;
        const targetCurrency = targetCurrencySelect.value; // Always "EUR"
        const value = amountInput.value;

        // Ensure a source currency is selected
        if (sourceCurrency) {
            const conversionData = {
                source_currency: sourceCurrency,
                target_currency: targetCurrency,
                value: value
            };

            fetch("http://127.0.0.1:8000/api/convert", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(conversionData)
            })
                .then(response => response.json())
                .then(result => {
                    convertedAmountInput.value = result.converted_amount;
                })
                .catch(error => {
                    console.error("Error converting currency:", error);
                });
        } else {
            convertedAmountInput.value = ""; // Clear the converted amount
            console.error("Please select a source currency.");
        }
    });
</script>
</body>
</html>
