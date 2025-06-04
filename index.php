<?php
// Einfaches Angebotstool Formular
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Angebot erstellen</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { max-width: 600px; margin: 0 auto; }
        label { display: block; margin-top: 10px; }
    </style>
</head>
<body>
<h1>Angebot erstellen</h1>
<form action="generate_pdf.php" method="post">
    <label>Kundenname
        <input type="text" name="customer" required>
    </label>
    <?php for ($i = 1; $i <= 3; $i++): ?>
    <fieldset>
        <legend>Leistung <?php echo $i; ?></legend>
        <label>Bezeichnung
            <input type="text" name="service[<?php echo $i; ?>][desc]">
        </label>
        <label>Preis (EUR)
            <input type="number" step="0.01" name="service[<?php echo $i; ?>][price]">
        </label>
    </fieldset>
    <?php endfor; ?>
    <button type="submit">PDF erzeugen</button>
</form>
</body>
</html>
