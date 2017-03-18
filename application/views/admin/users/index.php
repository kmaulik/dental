<!--<script type="text/javascript" src="<?php // echo DEFAULT_ADMIN_JS_PATH . "pages/datatables_data_sources.js";              ?>"></script>-->
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Sub User List</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li>Sub User</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">

     <?php
        $message = $this->session->flashdata('message');
        echo my_flash($message);
    ?>

    <!-- content area -->    
    <div class="panel panel-flat">
        <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/users/add'); ?>" class="btn btn-success btn-labeled"><b><i class="icon-checkmark-circle"></i></b> Add new user</a>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>User ID.</th>
                    <th>User Role</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th> 
                    <th>Last Login</th>                       
                    <th>Created Date</th>                        
                    <th width="100px">Action</th>
                </tr>
            </thead>
        </table>
    </div>    
</div>
<script>
    $(function () {
        $('.datatable-basic').dataTable({
            processing: true,
            serverSide: true,
            language: {
                search: '<span>Filter:</span> _INPUT_',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
            },
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            order: [[0, "asc"]],
            ordering: false,
            ajax: 'users/list_user',
            columns: [
                {
                    data: "test_id",
                    visible: true
                },
                 {
                    sortable: false,
                    data: "role_name",
                    visible: true
                },
                {
                    sortable: false,
                    data: "fname",
                    visible: true
                },
                {
                    sortable: false,
                    data: "lname",
                    visible: true
                },
                {
                    sortable: false,
                    data: "email_id",
                    visible: true
                },
                {
                    sortable: false,
                    data: "last_login",
                    visible: true,
                    render: function (data, type, full, meta) {
                        var login_date='';
                        if(data){
                            login_date = data;
                        }
                        else{
                            login_date = '-';
                        }
                        return login_date;
                    },    
                },
                {
                    sortable: false,
                    data: "created_at",
                    visible: true
                },
                {
                    data: "is_account_close",
                    visible: true,
                    searchable: false,
                    sortable: false,
                    width: 200,
                    render: function (data, type, full, meta) {
                        var action = '';
                        var id= encodeURIComponent(btoa(full.id));
                        if (full.is_blocked == '0') {
                            action += '<a href="<?php echo base_url(); ?>admin/users/edit/' + id + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm" title="Edit"><i class="icon-pencil3"></i></a>';
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/block/' + id + '" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded"  title="Block"><i class="icon-blocked"></i></a>'
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/delete/' + id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" title="Delete"><i class="icon-cross2"></i></a>'
                        } else if (full.is_blocked == 1) {
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/activate/' + id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"  title="Unblock"><i class="icon-checkmark-circle"></i></a>'
                            action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/action/delete/' + id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded" title="Delete"><i class="icon-cross2"></i></a>'
                        }
                        return action;
                    }
                }
            ]
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });
</script>