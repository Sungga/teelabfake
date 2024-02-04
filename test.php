<?php
$data = array(
    array('Id' => 3, 'Name' => 'hehe'),
    array('Id' => 4, 'Name' => 'haha')
);

// Chuyển đổi mảng thành chuỗi JSON
$jsonData = json_encode($data);

// In ra chuỗi JSON
echo $jsonData;
echo "----------------------------";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP to JavaScript</title>
</head>
<body>

<!-- Nơi để hiển thị dữ liệu từ PHP -->
<div id="displayData"></div>

<script>
// Nhận dữ liệu từ PHP thông qua biến PHP (hoặc Ajax nếu bạn muốn)
var phpData = <?php echo $jsonData; ?>;

// Hiển thị dữ liệu trong console để kiểm tra
console.log(phpData);

// Hiển thị dữ liệu trên trang HTML
var displayDiv = document.getElementById('displayData');
displayDiv.innerHTML = "<h3>Data from PHP:</h3>";
phpData.forEach(function(item) {
    displayDiv.innerHTML += "<p>ID: " + item.Id + ", Name: " + item.Name + "</p>";
});
</script>

</body>
</html>
