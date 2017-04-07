<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>

<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Refund List</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li>Refund List</li>
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
       <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>ID.</th>
                    <th>Refund Token #</th> 
                    <th>Refund Status</th>
                    <th>Role</th> 
                    <th>Payee Name</th>
                    <th>Request Title</th> 
                    <th>Amount ($)</th>                  
                    <th>Created Date</th> 
                    <th width="100px">Action</th>                       
                </tr>
            </thead>
        </table>
    </div>
    
</div>
<!-- Primary modal -->
<div id="modal_theme_primary" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Refund Detail</h6>
            </div>
            <form action="<?=base_url('admin/refund/change_status')?>" method="POST" id="frmrefund">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="name" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Request Title</label>
                                <input type="text" name="rfp_title" id="rfp_title" class="form-control" readonly>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Refund Amount ($)</label>
                                <input type="text" name="refund_amt" id="refund_amt" class="form-control" readonly>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description (Refund Reason)</label>
                                <textarea name="refund_reason" id="refund_reason" class="form-control" readonly></textarea>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Refund Status</label>
                                <select class="form-control" name="refund_status">
                                    <option value="">Select Refund Status</option>
                                    <option value="1">Approve</option>
                                    <option value="2">Reject</option>
                                </select>    
                            </div>        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->

<script>
$(function () {
    var table = $('.datatable-basic').dataTable({
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
        ajax: 'refund/list_refund',
        columns: [
        {
            data: "refund_id",
            visible: true
        },
        {
            sortable: false,
            data: "refund_token",
            visible: true
        },
        {
            data: "refund_status",
            visible: true,
            searchable: false,
            sortable: false,
            width: 200,
            render: function (data, type, full, meta) {
                var action = '';
                if (full.refund_status == '0') {
                    action += '<span class="label label-info">In-Progress</span>';
                }else if(full.refund_status == '1'){
                    action += '<span class="label label-success">Approved</span>';
                }else if(full.refund_status == '2'){
                    action += '<span class="label label-danger">Rejected</span>';
                }  
                return action;
            }
        },
        {
            sortable: false,
            data: "role_name",
            visible: true
        },
        {
            sortable: false,
            data: "user_name",
            visible: true
        },
        {
            sortable: false,
            data: "rfp_title",
            visible: true,
            render: function (data, type, full, meta) {
                var action = '';
                var rfp_id= encodeURIComponent(btoa(full.rfp_id));
                action += '<a href="<?php echo base_url(); ?>admin/rfp/view/' + rfp_id+'" target="_blank">'+full.rfp_title+'</a>';
                return action;
            }

        },
        {
            sortable: false,
            data: "payable_price",
            visible: true
        },
        {
            sortable: false,
            data: "created_date",
            visible: true
        },
        {
            data: "refund_status",
            visible: true,
            searchable: false,
            sortable: false,
            width: 200,
            render: function (data, type, full, meta) {
                var action = '';
                if (full.refund_status == '0') {
                    action += '<a href="#" data-id="'+full.refund_id+'" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm refund_status" title="View"><i class="icon-eye"></i></a>';
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

$(document).on('click','.refund_status',function(){
    var refund_id=$(this).data('id');
    $.post('<?=base_url("admin/refund/fetch_refund_data")?>',{'id' : refund_id},function(data){
        console.log(data);
       if(data){
            console.log(data);
            $('#id').val(data['refund_id']);
            $('#name').val(data['user_name']);
            $('#rfp_title').val(data['rfp_title']);
            $('#refund_amt').val(data['payable_price']);
            $('#refund_reason').val(data['refund_reason']);
            $('#modal_theme_primary').modal('show');
       } 
    },'json');
        
});


//---------------------- Validation -------------------
$("#frmrefund").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    validClass: "validation-valid-label",
    success: function(label) {
        label.addClass("validation-valid-label").text("Success.")
    },
    rules: {
        refund_status: {
            required: true
        }

    },
    messages: {
        refund_status: {
            required: "Please select a Refund Status"
        }

    }
});

// Auto hide Flash messages
$('div.alert').delay(4000).slideUp(350);
</script>