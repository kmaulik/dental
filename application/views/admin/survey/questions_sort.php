<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH; ?>core/libraries/jquery_ui/interactions.min.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold">Website Survey Questions Sort</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/survey'); ?>"> Survey</a></li>
            <li class="active">Questions Sort</li>
        </ul>
    </div>
</div>
<div class="content">

    <?php
        $message = $this->session->flashdata('message');
        echo my_flash($message);
    ?>

    <div class="row">
        <div class="panel panel-flat">
            <div class="panel-heading text-right">
                <a href="<?php echo site_url('admin/survey/add_question/'.$survey_id); ?>" class="btn btn-success btn-labeled">
                    <b><i class="icon-question4"></i></b>
                    Add New Question
                </a>
            </div>
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Question ID.</th>
                        <th>Question</th>
                        <th >Answer Type</th>
                        <th>Answer Options</th>
                        <th>Is Requried ?</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
            </table>        
        </div>
    </div>

    <div class="row">                    
        <!-- Drop placeholder -->
        <div class="panel panel-flat col-sm-6">
            <div class="panel-heading">
                <h6 class="panel-title text-semibold">Drop placeholder</h6>                
            </div>

            <div class="panel-body">
                <p class="content-group">You can sort questions order.Drag and drop as you like to set to order.</p>
                <div class="text-center">
                    <ul class="selectable-demo-list" id="sortable-list-placeholder">
                        <?php 
                            if(!empty($all_survey_ques)){
                                foreach($all_survey_ques as $ques){
                        ?>
                            <li id="<?php echo $ques['id']; ?>"><?php echo $ques['ques']; ?></li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /drop placeholder -->
    </div>    
</div>

<!-- Delete Question Form  Start-->
<form action="<?php echo base_url().'admin/survey/delete_question'; ?>" method="POST" id="delete_form">
    <input type="hidden" name="question_id" id="question_id" value="">
    <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
</form>
<!-- END Here -->

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
            ajax: '<?php echo base_url()."admin/survey/list_questions/".$survey_id; ?>',
            columns: [
                {
                    orderable : false, 
                    aTargets : [0],
                    data: "test_id",
                    visible: true
                },
                {
                    sortable: false,
                    data: "ques",
                    visible: true
                },
                {
                    sortable: false,
                    data: "opt_type",
                    visible: true
                },
                {
                    sortable: false,                    
                    visible: true,
                    render:function(data, type, full, meta){
                        if(full['opt_choice'] == null || full['opt_choice'] == ''){
                            return 'No Options';
                        }else{                            
                            return full['opt_choice'];
                        }
                    }
                },
                {
                    sortable: false,                    
                    visible: true,
                    render:function(data, type, full, meta){                        
                        if(full['is_required'] == '0'){
                            return 'No';
                        }else{
                            return 'Yes';
                        }
                    }
                },
                {                    
                    visible: true,
                    searchable: false,
                    sortable: false,
                    render: function (data, type, full, meta) {
                        var new_str = '';
                        new_str += '<a class="btn border-danger text-danger-600 btn-flat btn-icon btn-rounded btn_delete" onclick="delete_confirm('+full['id']+')">';
                        new_str += '<i class="icon-cross2"></i></a>';
                        return new_str;
                    }
                }
            ]
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        // Sortable || Placeholder
        $( "#sortable-list-placeholder" ).sortable({
            placeholder: "sortable-placeholder",
            start: function(e, ui){
                ui.placeholder.height(ui.item.outerHeight());
            },
            stop:function(e,ui){
                // console.log(JSON.stringify($( "#sortable-list-placeholder").sortable("toArray")));
                
                $.ajax({
                    url:'<?php echo base_url()."admin/survey/save_order"; ?>',
                    method:'POST',
                    dataType:'JSON',
                    data:{'survey_order':$( "#sortable-list-placeholder").sortable("toArray"),'survey_id':'<?php echo $survey_id; ?>'},
                    success:function(){
                                               
                    }
                });
            }
        });

        $( "#sortable-list-placeholder" ).disableSelection();

        
    });

    function delete_confirm(del_id){
        $('#question_id').val(del_id);
        bootbox.confirm('Are you sure ?',function(res){
            if(res){
                $('#delete_form').submit();
            }else{
                $('#question_id').val(''); 
            }
        });
    }

    $('div.alert').delay(4000).slideUp(700);
</script>

