<html>
<body>
  <?php
    $q = intval($_GET['q']);

    $conn = mysqli_connect('localhost', 'johny', 'abcde12345', 'db');
    if (!$conn) {
      die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($conn, "ajax_");
    $sql = "SELECT * FROM users WHERE id = '".$q."'";
    $result = mysqli_query($conn,$sql);

    echo "<table>
      <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Age</th>
        <th>Birthplace</th>
        <th>Occupation</th>
      </tr>";
    while($row = mysqli_fetch_array($result)) {
      echo "<tr>";
      echo "<td>" . $row['FirstName'] . "</td>";
      echo "<td>" . $row['LastName'] . "</td>";
      echo "<td>" . $row['Age'] . "</td>";
      echo "<td>" . $row['Birthplace'] . "</td>";
      echo "<td>" . $row['Occupation'] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    mysqli_close($conn);
  ?>
</body>
</html>
