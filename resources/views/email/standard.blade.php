<html>
<body>
    <p>Hallo,</p>
    <p>Sie haben eine neue Kontaktanfrage von Ihrer Hausverwaltungs-Website erhalten. Hier sind die Details:</p>

    <p>Name: {{ $form['name'] }}</p>
    <p>E-Mail: {{ $form['email'] }}</p>
    <p>Adresse: {{ $form['address'] }}</p>
    <p>Telefonnummer: {{ $form['phone'] }}</p>
    <p>Nachricht: </p>
    <p>{{ $form['message'] }}</p>

    <p>Von Ihrer Webseite</p>
</body>
</html>
