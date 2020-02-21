

<li class="treeview">
    <a href="#">
        <i class="fa fa-files-o"></i>
        <span>Role and Permission</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        @checkRoute('admin.roles.index')
        <li class="{{ Request::is('admin/permission*') ? 'active' : '' }}">
            <a href="{!! route('admin.permission.index') !!}">
                <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                Permissions
            </a>
        </li>
        @endcheckRoute
        @checkRoute('admin.roles.index')
        <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
            <a href="{!! route('admin.roles.index') !!}">
                <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                Roles
            </a>
        </li>
        @endcheckRoute
        @checkRoute('admin.users.index')
        <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
            <a href="{!! route('admin.users.index') !!}">
                <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                Users
            </a>
        </li>
        @endcheckRoute
    </ul>
</li>