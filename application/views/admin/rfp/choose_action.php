<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/selects/select2.min.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Request action</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/rfp'); ?>">Request</a></li>
            <li><a href="<?php echo site_url('admin/rfp/view/'.encode($rfp_id)); ?>">View Request Page</a></li>
            <li class="active">Request action</li>
        </ul>
    </div>
</div>

<div class="content">
    <?php
        $message = $this->session->flashdata('message');
        echo my_flash($message);
    ?>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" id="frm_rfp_action" method="POST" >
                <div class="panel panel-flat">
                    <div class="panel-body">                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Action :</label>
                            <div class="col-lg-3">
                                <select name="action" class="form-control select" id="action">
                                    <option value="no">Dis-Approve</option>
                                    <option value="yes">Approve</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">
                                    Your message:<br/>
                                    <small style="color:red">( This message will sent it to patient in mail.)</small>
                             </label>
                            <div class="col-lg-3">
                                <textarea rows="4" name="message" class="form-control" placeholder="Message...."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">
                                    Admin Remarks:<br/>                                    
                             </label>
                            <div class="col-lg-3">
                                <textarea rows="4" name="remarks" class="form-control" placeholder="Remarks...."></textarea>
                            </div>
                        </div>
                        <div class="text-right">                            
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(function() {        
        // Fixed width. Single select
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            width: 250            
        });
    });
 

    // fname ,lname
    // city country_id zipcode gender
    //---------------------- Validation -------------------
    $("#frm_rfp_action").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);            
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);            
        },
        validClass: "validation-valid-label",
        ignore:[],
        rules: {
            remarks:{required: true },
            message:{required: true }
        },        
        messages: {
            remarks:{required: 'Please provide a Remarks..' },
            message:{required: 'Please provide a Message..'}
        }
    });
</script>