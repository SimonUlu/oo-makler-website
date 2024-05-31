<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h2>Eine neue Anfrage von Ihrer Website ist eingetroffen!</h2>
            <p>Die folgenden Daten wurden im Kontaktformular übergeben:</p>

            <h3>Adresse</h3>
            <p><strong>Vorname:</strong> {{ $formData['address_vorname'] ?? 'nicht angegeben' }}</p>
            <p><strong>Name:</strong> {{ $formData['address_name'] ?? 'nicht angegeben' }}</p>
            <p><strong>Strasse:</strong> {{ $formData['address_strasse'] ?? 'nicht angegeben' }}</p>
            <p><strong>Plz:</strong> {{ $formData['address_plz'] ?? 'nicht angegeben' }}</p>
            <p><strong>Ort:</strong> {{ $formData['address_ort'] ?? 'nicht angegeben' }}</p>
            <p><strong>Email:</strong> {{ $formData['address_email'] ?? 'nicht angegeben' }}</p>
            <p><strong>Telefon:</strong> {{ $formData['address_phone'] ?? ($formData['phone'] ?? 'nicht angegeben') }}</p>
            <p><strong>Nachricht:</strong> {{ $formData['address_message'] ?? 'nicht angegeben' }}</p>

            <h3>Immobilie</h3>
            <p><strong>Objekt:</strong> {{ $formData['estate_oobj_id'] ?? 'nicht angegeben' }}</p>
            <p><strong>Objekttitel:</strong> {{ $formData['estate_objekttitel'] ?? 'nicht angegeben' }}</p>
            <p><strong>Plz:</strong> {{ $formData['estate_plz'] ?? 'nicht angegeben' }}</p>
            <p><strong>Ort:</strong> {{ $formData['estate_ort'] ?? 'nicht angegeben' }}</p>
        </div>
        <div class="footer">
            <p>This is a system-generated message, please do not reply to it.</p>
        </div>
    </div>
</body>

</html>
