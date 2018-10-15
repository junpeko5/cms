<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>LastName</th>
        <th>Email</th>
        <th>Role</th>
<!--        <th>Date</th>-->
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_first_name = $row['user_firstname'];
            $user_last_name = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $user_role = $row['user_role'];
            echo '<tr>';
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_first_name</td>";
            echo "<td>$user_last_name</td>";
            echo "<td>$user_email</td>";
            echo "<td>$user_role</td>";
            echo "<td><a</td>";
            echo '</tr>';
        }
        ?>
    </tr>
    </tbody>
</table>