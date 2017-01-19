<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Survey List</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li class="active">Survey</li>
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
            <a href="<?php echo site_url('admin/survey/add'); ?>" class="btn btn-success btn-labeled">
                <b><i class="icon-plus-circle2"></i></b>
                Add New Survey
            </a>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>User ID.</th>
                    <th>Survey Name</th>
                    <th width="500px">Survey Description</th>
                    <th>Status</th>                        
                    <th>Created Date</th>                        
                    <th width="100px">Action</th>
                </tr>
            </thead>
        </table>        
    </div>    
</div>

<form action="<?php echo base_url().'admin/survey/delete_survey'; ?>" method="POST" id="delete_form">
    <input type="hidden" name="survey_id" id="survey_id" value="">
</form>

<script type="text/javascript">
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
            ajax: '<?php echo base_url()."admin/survey/list_survey"; ?>',
            columns: [
                {
                    orderable : false, 
                    aTargets : [0],
                    data: "test_id",
                    visible: true
                },
                {
                    sortable: false,
                    data: "name",
                    visible: true
                },
                {
                    sortable: false,
                    data: "survey_desc",
                    visible: true
                },
                {
                    sortable: false,
                    data: "status",
                    visible: true
                },
                {
                    sortable: false,
                    data: "created_at",
                    visible: true
                },
                {
                    visible: true,
                    searchable: false,
                    sortable: false,
                    render: function (data, type, full, meta) {
                        var new_str = '';
                        new_str += '<div class="btn-group"><button type="button" class="btn btn-primary btn-icon dropdown-toggle" data-toggle="dropdown">';
                        new_str += '<i class="icon-menu7"></i> &nbsp;<span class="caret"></span></button>';
                        new_str += '<ul class="dropdown-menu dropdown-menu-right"><li><a href="<?php echo base_url();?>admin/survey/questions/'+full['id']+'"><i class="icon-question4"></i> View Questions </a></li>';
                        new_str += '<li><a href="<?php echo base_url();?>admin/survey/edit/'+full['id']+'"><i class="icon-pencil7"></i>Edit</a></li>';
                        new_str += '<li><a class="for_pointer" onclick="delete_confirm('+full['id']+')" ><i class="icon-trash"></i> Delete</a></li>';
                        new_str += '</ul></div>';
                        return new_str;
                    }
                }
            ]
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });

    function delete_confirm(del_id){
        $('#survey_id').val(del_id);
        bootbox.confirm('Are you sure ?',function(res){
            if(res){
                $('#delete_form').submit();
            }else{
                $('#survey_id').val(''); 
            }
        });
    }

    // Auto hide Flash messages
    $('div.alert').delay(4000).slideUp(350);

</script>