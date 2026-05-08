<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/hotel-system/controllers/RoomController.php';
$controller = new RoomController();


if (isset($_GET['action']) && isset($_GET['room'])) {
    $roomNum = $_GET['room'];
    $action = $_GET['action'];
    
    
    if ($action == 'start') $status = 'cleaning';
    elseif ($action == 'needs_cleaning') $status = 'needs-cleaning';
    else $status = 'clean'; 
    
    
    $controller->changeStatus($roomNum, $status);
    
    header("Location: housekeeper.php");
    exit();
}


$rooms = $controller->getRooms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grand Luxe - Housekeeper</title>
   <link rel="stylesheet" href="../style.css">
  <style>
    .b-orange {
      background-color: rgba(251, 146, 60, 0.15);
      color: #fb923c;
      border: 1px solid rgba(251, 146, 60, 0.3);
    }
    .b-blue {
      background-color: rgba(96, 165, 250, 0.15);
      color: #60a5fa;
      border: 1px solid rgba(96, 165, 250, 0.3);
    }
    .b-purple {
      background-color: rgba(167, 139, 250, 0.15);
      color: #a78bfa;
      border: 1px solid rgba(167, 139, 250, 0.3);
    }
    .btn-repair {
      background: transparent;
      border: 1px solid rgba(251, 146, 60, 0.5);
      color: #fb923c;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: all 0.2s;
    }
    .btn-repair:hover { background: rgba(251, 146, 60, 0.1); }
    .btn-start-repair {
      background: transparent;
      border: 1px solid rgba(96, 165, 250, 0.5);
      color: #60a5fa;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: all 0.2s;
    }
    .btn-start-repair:hover { background: rgba(96, 165, 250, 0.1); }
    .btn-mark-repaired {
      background: transparent;
      border: 1px solid rgba(167, 139, 250, 0.5);
      color: #a78bfa;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.8rem;
      transition: all 0.2s;
    }
    .btn-mark-repaired:hover { background: rgba(167, 139, 250, 0.1); }
    .status-cell {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      align-items: center;
    }
    .action-cell {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      align-items: center;
    }
html, body {
    height: auto !important;
    overflow-y: auto !important;
}


.app-body {
    min-height: 100vh;
    overflow-y: visible;
}
  </style>

</head>
<body>

<div class="topbar">
  <div class="topbar-logo">⬡ Grand Luxe</div>
  <div class="topbar-user">Housekeeper</div>
</div>

<div class="app-body">
  <div class="section-header">
    <h1>Housekeeping</h1>
    <p>Manage room cleaning and readiness</p>
  </div>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th>Room</th>
          <th>Type</th>
          <th>Status</th>
          <th>Last Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($rooms && mysqli_num_rows($rooms) > 0): ?>
          <?php while($row = mysqli_fetch_assoc($rooms)): 
              $s = $row['cleaning_state']; 
              if ($s == 'cleaning') { $c = 'b-gold'; $t = 'Cleaning'; }
              elseif ($s == 'ready' || $s == 'clean') { $c = 'b-green'; $t = 'Ready'; }
              else { $c = 'b-red'; $t = 'Needs Cleaning'; }
          ?>
            <tr>
              <td><strong><?php echo $row['room_num']; ?></strong></td>
              <td>Standard</td>
              <td><span class="badge <?php echo $c; ?>"><?php echo $t; ?></span></td>
              <td><?php echo date('h:i A', strtotime($row['last_updated'])); ?></td>
              <td>
                <?php if ($s == 'cleaning'): ?>
                    <a href="housekeeper.php?action=ready&room=<?php echo $row['room_num']; ?>" class="btn btn-g">Finish & Ready</a>
                <?php elseif ($s == 'ready' || $s == 'clean'): ?>
                    <a href="housekeeper.php?action=needs_cleaning&room=<?php echo $row['room_num']; ?>" class="btn btn-dirty">Mark Dirty / Issue</a>
                <?php else: ?>
                    <a href="housekeeper.php?action=start&room=<?php echo $row['room_num']; ?>" class="btn btn-g">Start Cleaning</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" style="text-align:center;">No rooms found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>