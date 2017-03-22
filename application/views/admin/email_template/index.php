<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Email Template List</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li> Email Templates</li>
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
     <!--    <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/email_template/add'); ?>" class="btn btn-success btn-labeled"><b><i class=" icon-plus-circle2"></i></b> Add New Email Template</a>
        </div> -->
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Email ID.</th>
                    <th>Email Template Title</th>                     
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
        ajax: 'email_template/list_email',
        columns: [
        {
            data: "id",
            visible: true
        },
        {
            sortable: false,
            data: "title",
            visible: true
        },
        {
            sortable: false,
            data: "created_date",
            visible: true
        },
        {
            data: "",
            visible: true,
            searchable: false,
            sortable: false,
            width: 200,
            render: function (data, type, full, meta) {
                var action = '';
                var id= encodeURIComponent(btoa(full.id));
                action += '<a href="<?php echo base_url(); ?>admin/email_template/edit/' + id + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm" title="Edit"><i class="icon-pencil3"></i></a>'; 
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

$(document).on( "click",".btn_delete", function(e) {    
        e.preventDefault();
        var lHref = $(this).attr('href');
        bootbox.confirm('Are you sure ?',function(res){
            if (res) {
                window.location.href = lHref; 
            }     
        });
    });

// Auto hide Flash messages
    $('div.alert').delay(4000).slideUp(350);
</script>