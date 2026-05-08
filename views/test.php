<?php
echo "Current Path: " . __DIR__ . "<br>";
if (file_exists(__DIR__ . '/../models/RoomModel.php')) {
    echo "✅ الملف موجود في مكانه الصح!";
} else {
    echo "❌ الملف مش موجود في المسار ده، راجعي اسم الفولدر.";
}
?>