<?php
// submit.php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kichaga = isset($_POST['kichaga']) ? strtolower(trim($_POST['kichaga'])) : '';
    $kiswahili = isset($_POST['kiswahili']) ? trim($_POST['kiswahili']) : '';
    $english = isset($_POST['english']) ? trim($_POST['english']) : '';

    $check_stmt = $conn->prepare("SELECT * FROM translations WHERE kichaga = ?");
    if ($check_stmt) {
        $check_stmt->bind_param("s", $kichaga);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $conn->close();
            echo "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Neno Lipo Tayari</title>
                <style>
                    body { background-color: #fff6f6; font-family: Arial, sans-serif; padding: 40px; }
                    .box {
                        background-color: #ffe6e6;
                        max-width: 500px;
                        margin: auto;
                        padding: 30px;
                        border-radius: 10px;
                        text-align: center;
                        box-shadow: 0 2px 8px rgba(255, 0, 0, 0.2);
                    }
                    h2 { color: #e74c3c; }
                    a { text-decoration: none; color: #3498db; }
                </style>
            </head>
            <body>
                <div class='box'>
                    <h2>⚠️ Neno '$kichaga' limeshawekwa tayari!</h2>
                    <p>Jaribu kuingiza neno jipya.</p>
                    <a href='form.html'>🔙 Rudi kwenye fomu</a>
                </div>
            </body>
            </html>";
            exit;
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO translations (kichaga, kiswahili, english) VALUES (?, ?, ?)");
            if ($insert_stmt) {
                $insert_stmt->bind_param("sss", $kichaga, $kiswahili, $english);

                if ($insert_stmt->execute()) {
                    $insert_stmt->close();
                    $conn->close();
                    // ✔️ Show success message
                    echo "
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Asante kwa Tafsiri</title>
                        <style>
                            body {
                                background-color: #f4f6f8;
                                font-family: Arial, sans-serif;
                                padding: 40px;
                            }
                            .box {
                                background-color: white;
                                max-width: 500px;
                                margin: auto;
                                padding: 30px;
                                border-radius: 10px;
                                text-align: center;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            }
                            h2 {
                                color: #2ecc71;
                            }
                            a {
                                text-decoration: none;
                                color: #3498db;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='box'>
                            <h2>✅ Asante kwa kuchangia tafsiri!</h2>
                            <p>Tafadhali endelea kuchangia zaidi.</p>
                            <a href='form.html'>➕ Tuma tafsiri nyingine</a>
                        </div>
                    </body>
                    </html>";
                    exit;
                } else {
                    echo "❌ Imeshindwa kuhifadhi data: " . $insert_stmt->error;
                }
            }
        }
    }
}
?>
