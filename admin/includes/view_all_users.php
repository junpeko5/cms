<?php
$rows = findAll('users');

if (isAdminUser()) {
    if (isset ($_GET['delete'])) {
        $user_id = forceString('delete');
        deleteById('users', 'user_id', $user_id);
        redirect("/cms/admin/users.php");
    }

    if (isset($_GET['change_to_admin'])) {
        $args = [
            'user_role' => 'admin',
            'user_id' => forceString('change_to_admin'),
        ];

        $user_id = updateUser($args);
        redirect("/cms/admin/users.php");
    }

    if (isset($_GET['change_to_sub'])) {
        $args = [
            'user_role' => 'subscriber',
            'user_id' => forceString('change_to_sub'),
        ];
        $user_id = updateUser($args);
        redirect("/cms/admin/users.php");
    }
}
?>
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
    </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?php echo h($row['user_id']); ?></td>
                <td><?php echo h($row['username']); ?></td>
                <td><?php echo h($row['user_firstname']); ?></td>
                <td><?php echo h($row['user_lastname']); ?></td>
                <td><?php echo h($row['user_email']); ?></td>
                <td><?php echo h($row['user_role']); ?></td>
                <td><a href='/cms/admin/users.php?change_to_admin=<?php echo h($row['user_id']); ?>'>Admin</a></td>
                <td><a href='/cms/admin/users.php?change_to_sub=<?php echo h($row['user_id']); ?>'>Subscriber</a></td>
                <td><a href='/cms/admin/users.php?source=edit_user&u_id=<?php echo h($row['user_id']); ?>'>Edit</a></td>
                <td><a href='/cms/admin/users.php?delete=<?php echo h($row['user_id']); ?>'>Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>