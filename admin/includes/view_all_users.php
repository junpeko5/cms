<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>LastName</th>
        <th>Email</th>
        <th>Role</th>
        <th>Admin</th>
        <th>Subscriber</th>
        <th>Edit</th>
        <th>Delete</th>
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
            echo "<td><a href='/cms/admin/users.php?change_to_admin={$user_id}'>Admin</a></td>";
            echo "<td><a href='/cms/admin/users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
            echo "<td><a href='/cms/admin/users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='/cms/admin/users.php?delete={$user_id}'>Delete</a></td>";
            echo '</tr>';
        }

        if (isset ($_GET['delete'])) {
            $the_user_id = $_GET['delete'];
            $query = "
                DELETE FROM
                    users
                WHERE
                    user_id = $the_user_id
            ";
            confirmQuery($query);
            header("Location: /cms/admin/users.php");
            exit;
        }

        if (isset($_GET['change_to_admin'])) {
            $the_user_id = $_GET['change_to_admin'];
            $query = "
                UPDATE
                    users
                SET
                    user_role = 'admin'
                WHERE
                    user_id = $the_user_id
            ";
            confirmQuery($query);
            header("Location: /cms/admin/users.php");
            exit;
        }

        if (isset($_GET['change_to_sub'])) {
            $the_user_id = $_GET['change_to_sub'];
            $query = "
                UPDATE
                    users
                SET
                    user_role = 'subscriber'
                WHERE
                    user_id = $the_user_id
            ";
            confirmQuery($query);
            header("Location: /cms/admin/users.php");
            exit;
        }
        ?>
    </tr>
    </tbody>
</table>