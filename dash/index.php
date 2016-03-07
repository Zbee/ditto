<?php
require("../assets/php/header.php");

$user = ditto::requireLogin();
$user = ditto::getUser($user);

$dataPoints = ditto::getDataPoints($user["id"], null, time()-3600*6);

$moodPoints  = [];
$sleepPoints = [];
$foodPoints  = [];

if (is_array($dataPoints)) {
  foreach ($dataPoints as $dataPoint) {
    if ($dataPoint["type"] == 0) {
      array_push($moodPoints, $dataPoint);
    } elseif ($dataPoint["type"] == 1) {
      array_push($sleepPoints, $dataPoint);
    } elseif ($dataPoint["type"] == 2) {
      array_push($foodPoints, $dataPoint);
    }
  }
}

$dataPointsPerm = [
  "mood"  => $moodPoints,
  "sleep" => $sleepPoints,
  "food"  => $foodPoints
];
?>

<div class="ribbon" id="welcome">
  <div class="container">
    <h1 class="bigbold">Welcome</h1>
    <h1>To Your Dashboard</h1>
    From here you can monitor your progress and log mood, sleep, and food.
    <br><br>
    <?php if (count($moodPoints) == 0): ?>
      <a class="button" href="/enter/mood/">Log Mood</a>
    <?php endif; ?>
    <?php if (count($sleepPoints) == 0): ?>
    <a class="button" href="/enter/sleep/">Log Sleep</a>
    <?php endif; ?>
    <?php if (count($foodPoints) == 0): ?>
    <a class="button" href="/enter/food/">Log Food</a>
    <?php endif; ?>
  </div>
</div>

<div class="ribbon" id="mood">
  <div class="container">
    <h1 class="bigbold">Mood</h1>
    <?php
    $moodPoints = ditto::getDataPoints($user["id"], 0, time()-3600*24*30);
    if (count($moodPoints) > 3):
    ?>
    <div id="moodChart"></div>
    <script>
    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Day');
      data.addColumn('number', 'Mood');

      data.addRows([
        <?php
        foreach ($moodPoints as $moodPoint) {
          $date = date("Y-m-d", $moodPoint["date"]);
          $index = json_decode($moodPoint["data"]);
          $index = $index[0];
          echo "[new Date('$date'), $index],\n";
        }
        ?>
      ]);

      var options = {
        backgroundColor: "#00b8f1",
        chart: {
          title: '',
          subtitle: ''
        },
        hAxis: {
          title: 'Time',
          minorGridlines: {color: "white"},
          titleTextStyle: {color: "white"},
          textStyle: {color: "white"},
          baselineColor: "white"
        },
        vAxis: {
          title: 'Index',
          titleTextStyle: {color: "white"},
          textStyle: {color: "white"},
          baselineColor: "white"
        },
        colors: ['white', 'white', 'white'],
        pointSize: 7,
        pointShape: "circle",
        legend: {textStyle: {color: "white"}},
        height: 500
      };

      var chart = new google.visualization.LineChart(document.getElementById('moodChart'));

      chart.draw(data, options);
    }
    </script>
    <?php else: ?>
    <h1>You Don't Yet Have Enough Data To Visualize</h1>
    <?php endif; ?>
    <?php if (count($dataPointsPerm["mood"]) !== 0): ?>
      Great job on remembering to log your mood today!
    <?php else: ?>
      <a class="button" href="/enter/mood/">Log Mood</a>
    <?php endif; ?>
  </div>
</div>

<?php
require("../assets/php/footer.php");
?>