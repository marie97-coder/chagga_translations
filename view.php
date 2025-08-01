<?php
// view.php

// Hakikisha db.php ina muunganisho sahihi wa database
include('db.php');

// Angalia kama muunganisho umefanikiwa
if ($conn->connect_error) {
    die("Muunganisho na database umeshindwa: " . $conn->connect_error);
}

// Andaa na tekeleza swala la kuchukua data zote.
// Ni muhimu sana kuchukua 'id' pia kwa ajili ya kitufe cha kuedit.
$sql = "SELECT id, kichaga, kiswahili, english FROM translations ORDER BY kichaga ASC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orodha ya Tafsiri za Kichaga</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 20px;
            padding: 0;
            color: #333;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Ongeza upana kidogo ili kutoshea column mpya */
            margin: 20px auto;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #e0e0e0;
        }

        th:last-child, td:last-child {
            border-right: none;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f5ff;
        }

        .edit-button {
            background-color: #28a745; /* Rangi ya kijani kwa kitufe cha Hariri */
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none; /* Ondoa mstari chini ya link */
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover {
            background-color: #218838; /* Rangi nyeusi zaidi unapo-hover */
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
                margin-bottom: 15px;
                border-radius: 8px;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                text-align: right;
                border-right: none;
            }

            td:last-child {
                border-bottom: 0;
            }

            td:before {
                position: absolute;
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                color: #555;
            }

            /* Labels kwa columns kwenye simu ndogo */
            td:nth-of-type(1):before { content: "Kichaga:"; }
            td:nth-of-type(2):before { content: "Kiswahili:"; }
            td:nth-of-type(3):before { content: "English:"; }
            td:nth-of-type(4):before { content: "Vitendo:"; } /* Label mpya kwa safu ya vitendo */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Orodha ya Tafsiri</h2>

        <?php
        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>Kichaga</th><th>Kiswahili</th><th>English</th><th>Vitendo</th></tr></thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['kichaga']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kiswahili']) . "</td>";
                echo "<td>" . htmlspecialchars($row['english']) . "</td>";
                // Safu mpya kwa kitufe cha kuedit
                echo "<td><a href='edit.php?id=" . htmlspecialchars($row['id']) . "' class='edit-button'>Hariri</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p style='text-align: center; color: #777;'>Hakuna tafsiri zilizopatikana bado.</p>";
        }

        $conn->close(); // Funga muunganisho wa database baada ya kumaliza
        ?>
        <p style="text-align: center; margin-top: 30px;"><a href="form.html" style="text-decoration: none; color: #3498db;">➕ Ongeza Tafsiri Mpya</a></p>
    </div>
</body>
</html>
