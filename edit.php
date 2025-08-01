<?php
// edit.php
include('db.php');

// Angalia kama data ya POST imetumwa ili kuhifadhi mabadiliko
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pokea data kutoka kwenye fomu
    $id = $_POST['id'];
    $kichaga = strtolower(trim($_POST['kichaga']));
    $kiswahili = trim($_POST['kiswahili']);
    $english = trim($_POST['english']);

    // Andaa swala la SQL la kusasisha (UPDATE) data
    $stmt = $conn->prepare("UPDATE translations SET kichaga = ?, kiswahili = ?, english = ? WHERE id = ?");
    $stmt->bind_param("sssi", $kichaga, $kiswahili, $english, $id);

    if ($stmt->execute()) {
        // Mabadiliko yamewahi, tuma mtumiaji kwenye ukurasa wa orodha tena
        header("Location: view.php");
        exit();
    } else {
        echo "Kuna kosa wakati wa kuhifadhi mabadiliko: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Andaa swala la kuchukua data
// Angalia kama 'id' imetumwa kwenye URL
if (!isset($_GET['id'])) {
    echo "Hakuna kitambulisho (ID) cha tafsiri kilichotolewa.";
    exit();
}

$id = $_GET['id'];

// Chukua data ya tafsiri husika kutoka database kwa kutumia ID
$stmt = $conn->prepare("SELECT id, kichaga, kiswahili, english FROM translations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Tafsiri yenye kitambulisho (ID) " . htmlspecialchars($id) . " haikupatikana.";
    exit();
}

$translation = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hariri Tafsiri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            resize: vertical;
            min-height: 80px;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #28a745; /* Rangi ya kijani */
            color: white;
            border: none;
            padding: 12px;
            width: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #777;
            text-decoration: none;
        }

        .cancel-link:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hariri Tafsiri</h2>
        <form action="edit.php" method="POST">
            <!-- Hifadhi ID ya tafsiri kwenye fomu kwa kutumia input isiyoonekana -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($translation['id']); ?>">

            <label for="kichaga">Kichaga:</label>
            <textarea name="kichaga" id="kichaga" required><?php echo htmlspecialchars($translation['kichaga']); ?></textarea>

            <label for="kiswahili">Kiswahili:</label>
            <textarea name="kiswahili" id="kiswahili" required><?php echo htmlspecialchars($translation['kiswahili']); ?></textarea>

            <label for="english">English:</label>
            <textarea name="english" id="english" required><?php echo htmlspecialchars($translation['english']); ?></textarea>

            <input type="submit" value="Hifadhi Mabadiliko">
        </form>
        <a href="view.php" class="cancel-link">Ghairi Mabadiliko</a>
    </div>
</body>
</html>
