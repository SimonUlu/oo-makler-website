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
            <p><strong>Vorname:</strong> {{ $formData['vorname'] ?? 'nicht angegeben' }}</p>
            <p><strong>Name:</strong> {{ $formData['name'] ?? 'nicht angegeben' }}</p>
            <p><strong>Strasse:</strong> {{ $formData['strasse'] ?? 'nicht angegeben' }}</p>
            <p><strong>Plz:</strong> {{ $formData['address_plz'] ?? 'nicht angegeben' }}</p>
            <p><strong>Ort:</strong> {{ $formData['address_ort'] ?? 'nicht angegeben' }}</p>
            <p><strong>Email:</strong> {{ $formData['email'] ?? 'nicht angegeben' }}</p>
            <p><strong>Telefon:</strong> {{ $formData['phone'] ?? 'nicht angegeben' }}</p>
            <p><strong>Nachricht:</strong> {{ $formData['message'] ?? 'nicht angegeben' }}</p>
            </br>
            </br>
            <p><strong>Verknüpfung zu Nutzer mit Datensatznummer:</strong>
                {{ $formData['addressId'] ?? 'nicht angegeben' }}</p>

            <h3>Suchkriterien</h3>
            {{-- make them as foreach --}}
            @foreach ($searchCriteria as $key => $value)
                <p><strong>{{ $key }}</strong> {{ $value }}</p>
            @endforeach

        </div>
        <div class="footer">
            <p>This is a system-generated message, please do not reply to it.</p>
        </div>
    </div>
</body>

</html>
