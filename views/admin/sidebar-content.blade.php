<li class="{{ Request::is('admin/permission*') ? 'active' : '' }}">
    <a href="{!! route('admin.permission.index') !!}">
        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
        Permissions
    </a>
</li>
<li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
    <a href="{!! route('admin.roles.index') !!}">
        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
        Roles
    </a>
</li>
<li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
    <a href="{!! route('admin.users.index') !!}">
        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
        Users
    </a>
</li>