<!DOCTYPE html>
<html>
<head>
    <title>Carte QR Code</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .card { border: 1px solid #ccc; padding: 20px; text-align: center; width: 300px; margin: auto; }
        img { width: 200px; height: 200px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>MoneyX card</h2>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qrCodePath)) }}" />
        <p>Scan this QR code to pay with your MoneyX card.</p>
    </div>
</body>
</html>