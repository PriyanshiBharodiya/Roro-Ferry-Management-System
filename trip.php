<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoRoferry - Schedule</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/trip.css" />

    <?php include('inc/links.php'); ?>
  
</head>

<body>
    <?php require('inc/header.php'); ?>

    <!-- Route Links (Only show available routes) -->
    <div class="route-links">
        <?php
        include "inc/connection.php";
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Define all routes
        $routes = [
            ['from' => 'Hajira', 'to' => 'Porbandar'],
            ['from' => 'Porbandar', 'to' => 'Hajira'],
            ['from' => 'Hajira', 'to' => 'Bhavnagar'],
            ['from' => 'Bhavnagar', 'to' => 'Hajira'],
            ['from' => 'Hajira', 'to' => 'Veraval'],
            ['from' => 'Veraval', 'to' => 'Hajira'],
        ];

        // Fetch available routes
        $available_routes = [];

        foreach ($routes as $route) {
            $query = "SELECT DISTINCT dep_place, arr_place FROM trip WHERE dep_place='{$route['from']}' AND arr_place='{$route['to']}' AND status=1";
            $result = mysqli_query($con, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $available_routes[] = $route;
            }
        }

        // Generate dynamic links based on available routes
        foreach ($available_routes as $route) {
            echo "<a href='#" . strtolower(str_replace(' ', '-', $route['from'] . '-' . $route['to'])) . "'>{$route['from']} - {$route['to']}</a>";
        }

        ?>

    </div>

    <!-- Display schedules for available routes -->
    <?php
    // Display schedules for available routes
    foreach ($available_routes as $route) {
        displayTrips($con, $route['from'], $route['to'], strtolower(str_replace(' ', '-', $route['from'] . '-' . $route['to'])));
    }

    mysqli_close($con);

    // Function to display trips
    function displayTrips($con, $from, $to, $id)
    {
        echo "<section id='{$id}' class='schedule-section'>";
        echo '<div class="container">';
        echo "<h2>{$from} to {$to}</h2>";
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead><tr>
                <th>Day</th>
                <th>Departure Date</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Action</th>
              </tr></thead>';
        echo '<tbody>';

        $query = "SELECT * FROM trip WHERE dep_place='$from' AND arr_place='$to' AND status=1 ORDER BY dep_date";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['trip_day']}</td>
                        <td>{$row['dep_date']}</td>
                        <td>{$row['dep_time']}</td>
                        <td>{$row['arr_time']}</td>
                     <td><a href='package.php?trip_id={$row['trip_id']}' class='btn-package'>Packages</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-muted'>No schedule available.</td></tr>";
        }

        echo '</tbody></table></div></div></section>';
    }
    ?>

    <?php require('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>