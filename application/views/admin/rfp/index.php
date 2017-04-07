<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>

<style>
.label-dark-blue{
        background: #4765a0 !important;
    }
</style>

<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Request List</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li>Request</li>
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
       <!--  <div class="panel-heading text-right">
            <a href="<?php echo site_url('admin/rfp/add'); ?>" class="btn btn-success btn-labeled"><b><i class=" icon-plus-circle2"></i></b> Add New Blog</a>
        </div> -->
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>Request ID.</th>
                    <th>Request Title</th>
                    <th>Patient Name</th>
                    <!-- <th>Dentition Type</th> -->
                    <th>Status</th>                     
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
        ajax: 'rfp/list_rfp',
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
            data: "patient_name",
            visible: true
        },
        // {
        //     sortable: false,
        //     data: "dentition_type",
        //     visible: true
        // },
        {
            data: "is_blocked",
            visible: true,
            searchable: false,
            sortable: false,
            width: 200,
            render: function (data, type, full, meta) {
                var status = '';
                if (full.status == 0) {
                    status += '<span class="label label-default">Quote Request Draft</span>';
                   } else if (full.status == 1) {
                    status += '<span class="label label-primary">Quote Request Pending</span>';
                   } else if (full.status == 2) {
                    status += '<span class="label label-danger">Patient Review</span>';
                   } else if (full.status == 3) {
                    status += '<span class="label label-info">Quote Request Received</span>';
                   } else if (full.status == 4) {
                    status += '<span class="label label-warning">Doctor Confirmation Pending</span>';
                   } else if (full.status == 5) {
                    status += '<span class="label label-primary">Appointment Pending</span>';
                   }else if (full.status == 6) {
                    status += '<span class="label label-dark-blue">Service in Progress</span>';
                   }else if (full.status == 7) {
                    status += '<span class="label label-success">Closed</span>';
                   }
                return status;
            }
        },
        {
            sortable: false,
            data: "created_date",
            visible: true
        },
        {
            data: "is_blocked",
            visible: true,
            searchable: false,
            sortable: false,
            width: 200,
            render: function (data, type, full, meta) {
                var action = '';
                var id= encodeURIComponent(btoa(full.id));
                if (full.is_blocked == '0') {
                    action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/rfp/view/' + id + '" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded"  title="View"><i class="icon-eye"></i></a>'
                    action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/rfp/action/block/' + id + '" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded"  title="Block"><i class="icon-blocked"></i></a>'
                    action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/rfp/action/delete/' + id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded btn_delete" title="Delete"><i class="icon-cross2"></i></a>'
                } else if (full.is_blocked == 1) {
                    action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/rfp/action/activate/' + id + '" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded"  title="Unblock"><i class="icon-checkmark-circle"></i></a>'
                    action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/rfp/action/delete/' + id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded btn_delete" title="Delete"><i class="icon-cross2"></i></a>'
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