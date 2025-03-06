<?php
// edit_chart.php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$chart_id = $_GET['id'] ?? '';
if (!$chart_id) {
    header("Location: dashboard.php");
    exit;
}

// Fetch chart data
$stmt = $db->prepare("SELECT * FROM charts WHERE id = :id AND user_id = :user_id");
$stmt->execute([
    ':id' => $chart_id,
    ':user_id' => $_SESSION['user_id']
]);
$chart = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$chart) {
    echo "Chart not found.";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chart_name = trim($_POST['chart_name'] ?? '');
    $chart_type = trim($_POST['chart_type'] ?? '');
    $data_url = trim($_POST['data_url'] ?? '');

    if ($chart_name && $chart_type && $data_url) {
        $stmt = $db->prepare("UPDATE charts SET chart_name = :chart_name, chart_type = :chart_type, data_url = :data_url WHERE id = :id AND user_id = :user_id");
        $stmt->execute([
            ':chart_name' => $chart_name,
            ':chart_type' => $chart_type,
            ':data_url' => $data_url,
            ':id' => $chart_id,
            ':user_id' => $_SESSION['user_id']
        ]);
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Chart</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <h1>Edit Chart</h1>
  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>
  <form method="post" action="edit_chart.php?id=<?php echo $chart_id; ?>">
    <label>Chart Name: <input type="text" name="chart_name" value="<?php echo htmlspecialchars($chart['chart_name']); ?>" required></label><br>
    <label>Chart Type:
      <select name="chart_type" required>
        <option value="bar" <?php if ($chart['chart_type'] === 'bar') echo 'selected'; ?>>Bar Chart</option>
        <option value="line" <?php if ($chart['chart_type'] === 'line') echo 'selected'; ?>>Line Chart</option>
        <option value="pie" <?php if ($chart['chart_type'] === 'pie') echo 'selected'; ?>>Pie Chart</option>
        <option value="ring" <?php if ($chart['chart_type'] === 'ring') echo 'selected'; ?>>Ring Chart</option>
        <option value="stacked" <?php if ($chart['chart_type'] === 'stacked') echo 'selected'; ?>>Stacked Bar Chart</option>
        <option value="gauge" <?php if ($chart['chart_type'] === 'gauge') echo 'selected'; ?>>Radial Gauge Chart</option>
      </select>
    </label><br>
    <label>Data URL: <input type="text" name="data_url" value="<?php echo htmlspecialchars($chart['data_url']); ?>" required></label><br>
    <input type="submit" value="Update Chart">
  </form>
  <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>

