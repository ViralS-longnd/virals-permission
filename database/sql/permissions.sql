INSERT INTO `permissions` (`id`, `name`, `uri`, `method`, `created_at`, `updated_at`) VALUES
(1, 'Permission Manage', 'admin/permission', 'GET', '2020-02-04 22:29:07', '2020-02-04 22:29:07'),
(2, 'Role Manage', 'admin/roles', 'GET', '2020-02-04 22:29:18', '2020-02-04 22:29:18'),
(3, 'Role Create', 'admin/roles/create', 'GET', '2020-02-04 22:29:35', '2020-02-04 22:29:35'),
(4, 'Role Show', 'admin/roles/{role}', 'GET', '2020-02-04 22:29:52', '2020-02-04 22:29:52'),
(5, 'Role Edit', 'admin/roles/{role}/edit', 'GET', '2020-02-04 22:30:00', '2020-02-04 22:30:00'),
(6, 'Show Permission', 'admin/users/roles/show', 'GET', '2020-02-04 22:30:09', '2020-02-04 22:31:00'),
(7, 'User Manage', 'admin/users', 'GET', '2020-02-04 22:30:15', '2020-02-04 22:30:15'),
(8, 'User Create', 'admin/users/create', 'GET', '2020-02-04 22:30:25', '2020-02-04 22:30:25'),
(9, 'User Show', 'admin/users/{user}', 'GET', '2020-02-04 22:30:32', '2020-02-04 22:30:32'),
(10, 'User Edit', 'admin/users/{user}/edit', 'GET', '2020-02-04 22:31:08', '2020-02-04 22:31:08'),
(11, 'Permission Store', 'admin/permission', 'POST', '2020-02-04 22:31:34', '2020-02-04 22:31:34'),
(12, 'Role Store', 'admin/roles', 'POST', '2020-02-04 22:31:40', '2020-02-04 22:31:40'),
(13, 'User Store', 'admin/users', 'POST', '2020-02-04 22:31:47', '2020-02-04 22:31:47'),
(14, 'Delete Permission', 'admin/permission/{permissionId}', 'DELETE', '2020-02-04 22:31:59', '2020-02-04 22:31:59'),
(15, 'Delete Role', 'admin/roles/{role}', 'DELETE', '2020-02-04 22:32:08', '2020-02-04 22:32:08'),
(16, 'Delete User', 'admin/users/{user}', 'DELETE', '2020-02-04 22:32:19', '2020-02-04 22:32:19'),
(17, 'Update Role', 'admin/roles/{role}', 'PUT', '2020-02-04 22:32:28', '2020-02-04 22:32:28'),
(18, 'Update User', 'admin/users/{user}', 'PUT', '2020-02-04 22:32:36', '2020-02-04 22:32:36'),
(19, 'Update Role P', 'admin/roles/{role}', 'PATCH', '2020-02-04 22:33:19', '2020-02-04 22:33:19'),
(20, 'Update User P', 'admin/users/{user}', 'PATCH', '2020-02-04 22:33:29', '2020-02-04 22:33:29');