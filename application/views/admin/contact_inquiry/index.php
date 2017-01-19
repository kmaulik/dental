<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Contact Inquiry List</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li> Contact Inquiry</li>
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
                    <th>Inquiry ID.</th>
                    <th>Name</th> 
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>                    
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
                <h6 class="modal-title">Contact Inquiry</h6>
            </div>
            <form action="<?=base_url('admin/contact_inquiry/reply')?>" method="POST" id="frmcontact">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Name</label>
                                <input type="text" name="name" id="name" class="form-control" readonly>
                            </div>

                            <div class="col-sm-6">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Message</label>
                                <textarea name="description" id="description" class="form-control" readonly></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Your Message</label>
                                <textarea name="message" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Reply</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->

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
        ajax: 'contact_inquiry/list_inquiry',
        columns: [
        {
            data: "id",
            visible: true
        },
        {
            sortable: false,
            data: "name",
            visible: true
        },
        {
            sortable: false,
            data: "email",
            visible: true
        },
        {
            sortable: false,
            data: "subject",
            visible: true
        },
        {
            data: "status",
            visible: true,
            searchable: false,
            sortable: false,
            width: 200,
            render: function (data, type, full, meta) {
                var action = '';
                if(full.status == 0){
                    action += '<span class="label label-danger">UnRead</span>';
                }else{
                    action += '<span class="label label-success">Read</span>';
                }
                return action;
            }
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
                action += '<a href="#" data-id="'+full.id+'" class="btn border-primary text-primary-600 btn-flat btn-icon btn-rounded btn-sm contact-reply" title="Reply"><i class="icon-reply"></i></a>';
                action += '&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/contact_inquiry/action/delete/' + id + '" class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded btn_delete" title="Delete"><i class="icon-cross2"></i></a>'
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


$(document).on('click','.contact-reply',function(){
    var contact_id=$(this).data('id');
    $.post('<?=base_url("admin/contact_inquiry/fetch_inquiry_data")?>',{'id' : contact_id},function(data){
       if(data){
            $('#id').val(data['id']);
            $('#name').val(data['name']);
            $('#email').val(data['email']);
            $('#subject').val(data['subject']);
            $('#description').val(data['description']);
            $('#modal_theme_primary').modal('show');
       } 
    },'json');
        
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
//---------------------- Validation -------------------
$("#frmcontact").validate({
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
        message: {
            required: true
        }

    },
    messages: {
        message: {
            required: "Please provide a Message"
        }

    }
});

// Auto hide Flash messages
    $('div.alert').delay(4000).slideUp(350);
</script>