     <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <!--main-container-part-->

       <script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
          <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
			<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script>
         



<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Projects</a> </div>
    <h1>Projects</h1>
    <?php echo $this->session->userdata('name');?>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
            <h5>Recent Projects</h5>
            <a href="#"  class='open-AddBookDialog'   data-table='project'                                                    
                                                      data-id='<?php echo  $data->id; ?>'
                                                      data-toggle="modal" data-target="#myModal-add"><image src="<?php echo base_url(); ?>assets/img/edit.png" title="Edit" /><input type="button" id="addproject" name="addproject" value="Add New Project"></a>
                                                      </div>
            <form name="project" id="project">
             <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Account Manager</th>
                    <th>Project Manager</th>
                    <th>Developer</th>
                    <th>Details</th>
                    <th>No of Task</th>
                    <th>Edit</th>                                           
                    <th>Delete</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php if (empty($results)) { ?>
                                        <tr><td colspan="3" style="text-align: center"> No Records Found</td></tr>
                                         <?php } else { 
                                    $i = $this->uri->segment(3);
                             foreach($results as $data) {
                                        $i++; ?><tr>  
                                               <td><?php echo $data->id;?></td> 
                                               <td><?php echo $data->name;?></td> 
                                               <td><?php echo $data->status;?></td>
                                               <td><?php echo $data->created;?></td>
                                               <td><?php echo $data->accountmanager;?></td>
                                               <td><?php echo $data->projectmanager;?></td>
                                               <td><?php echo $data->developer;?></td>
                                               <td><?php echo $data->details;?></td>
                                               <td><?php echo $data->no_of_task;?></td>

                                                  <td  style="text-align: center"><a href="#"  class='open-AddBookDialog' data-table='project'
                                                     data-name='<?php echo $data->name; ?>' 
                                                     data-status= '<?php echo $data->status; ?>'
                                                     data-created= '<?php echo $data->created; ?>'
                                                     data-accountmanager= '<?php echo $data->accountmanager; ?>'
                                                     data-projectmanager= '<?php echo $data->projectmanager; ?>'
                                                     data-developer= '<?php echo $data->developer; ?>'
                                                     data-details= '<?php echo $data->details; ?>'
                                                     data-no_of_task= '<?php echo $data->no_of_task; ?>'

                                                     data-id='<?php echo  $data->id; ?>'



                                                      data-toggle="modal" data-target="#myModal-edit"><image src="<?php echo base_url(); ?>assets/img/edit.png" title="Edit" /></a></td>
                                                  <td  style="text-align: center"><a href="#"  class='open-deleteBookDialog' data-table='project'
                                                     data-name='<?php echo $data->name; ?>' data-id='<?php echo  $data->id; ?>' data-toggle="modal" data-target="#myModal-delete"><image src="<?php echo base_url(); ?>assets/img/delete.png" title="Delete" /></a></td>
                                           
                                           </tr>  
                                        <?php } 
                                         }
                                        ?>     
            </tbody>
 
        </table>
      
         
        </div>
 
      </div>
 
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-repeat"></i></span>
            <h5>Recent Activity</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="activity-list">
              <li><a href="#"> <i class="icon-user"></i> <strong>Themeforest</strong>Approved My college theme <strong>1 user</strong> <span>2 hours ago</span> </a></li>
              <li><a href="#"> <i class="icon-file"></i> <strong>My College is PSD Template </strong> Theme <strong>Psd Theme</strong> <span>2months ago</span> </a></li>
              <li><a href="#"> <i class="icon-envelope"></i> <strong>Lorem ipsum doler set</strong> adag<strong>agg</strong> <span>2 days ago</span> </a></li>
              <li><a href="#"> <i class="icon-picture"></i> <strong>ITs my First Admin</strong> so very<strong>exited</strong> <span>2 days ago</span> </a></li>
              <li><a href="#"> <i class="icon-user"></i> <strong>Admin</strong> bans <strong>3 users</strong> <span>week ago</span> </a></li>
            </ul>
          </div>
        </div>

<div id="myModal-add" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="project_form">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Project</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div class="form-group">

                <input  readonly="readonly" style="width:40%" class="form-control" id="edittable" name="edittable"  type="hidden" value="<?php echo set_value('edittable'); ?>" />
                        <input  readonly="readonly" style="width:40%" class="form-control" id="editid" name="editid"  type="hidden" value="<?php echo set_value('editid'); ?>" />


                      <label for="name">Name</label>
                      <input  id="name" name="name"  type="" value="<?php echo set_value('name'); ?>" />
                      
                      <label for="status">Status</label>                     
                      <input  id="status" name="status"  type="" value="<?php echo set_value('status'); ?>" />

                      <label for="created">Created</label>
                      <input  id="created" name="created"  type="" value="<?php echo set_value('created'); ?>" />
                       
                      <label for="accountmanager">Account Manager</label>
                      <input  id="accountmanager" name="accountmanager"  type="" value="<?php echo set_value('accountmanager'); ?>" />

                      <label for="projectmanager">Project Manager</label>
                      <input  id="projectmanager" name="projectmanager"  type="" value="<?php echo set_value('projectmanager'); ?>" />
                     
                      <label for="developer">Developer</label>
                      <input  id="developer" name="developer"  type="" value="<?php echo set_value('developer'); ?>" />

                      <label for="details">Details</label>
                      <input  id="details" name="details"  type="" value="<?php echo set_value('details'); ?>" />
                     
                      <label for="name">No. Of Task</label>
                      <input  id="no_of_task" name="no_of_task"  type="" value="<?php echo set_value('no_of_task'); ?>" />
                  </div>
              
                
                
            </div>
             </form>
            <div class="modal-footer">
                <input class="btn btn-default" id="add" name="add" type="button" value="Add" />
                <input class="btn btn-default" type="button" data-dismiss="modal" value="Close" />
            </div>
            <?php echo form_close(); ?>            
        </div>
    </div>
</div>



        <div id="myModal-edit" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="project_form">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Project Name</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div class="form-group">

                 <input  readonly="readonly" style="width:40%" class="form-control" id="edittable" name="edittable"  type="hidden" value="<?php echo set_value('edittable'); ?>" />
                        <input  readonly="readonly" style="width:40%" class="form-control" id="editid" name="editid"  type="hidden" value="<?php echo set_value('editid'); ?>" />


                      <label for="name">Name</label>
                      <input  id="name" name="name"  type="" value="<?php echo set_value('name'); ?>" />
                      
                      <label for="status">Status</label>                     
                      <input  id="status" name="status"  type="" value="<?php echo set_value('status'); ?>" />

                      <label for="created">Created</label>
                      <input  id="created" name="created"  type="" value="<?php echo set_value('created'); ?>" />
                       
                      <label for="accountmanager">Account Manager</label>
                      <input  id="accountmanager" name="accountmanager"  type="" value="<?php echo set_value('accountmanager'); ?>" />

                      <label for="projectmanager">Project Manager</label>
                      <input  id="projectmanager" name="projectmanager"  type="" value="<?php echo set_value('projectmanager'); ?>" />
                     
                      <label for="developer">Developer</label>
                      <input  id="developer" name="developer"  type="" value="<?php echo set_value('developer'); ?>" />

                      <label for="details">Details</label>
                      <input  id="details" name="details"  type="" value="<?php echo set_value('details'); ?>" />
                     
                      <label for="name">No. Of Task</label>
                      <input  id="no_of_task" name="no_of_task"  type="" value="<?php echo set_value('no_of_task'); ?>" />
                  
                </div>
              
                
                <div id="alert-msg"></div>
            </div>
             </form>
            <div class="modal-footer">
                <input class="btn btn-default" id="edit" name="edit" type="button" value="Edit" />
                <input class="btn btn-default" type="button" data-dismiss="modal" value="Close" />
            </div>
            <?php echo form_close(); ?>            
        </div>
    </div>
</div>



<div id="myModal-delete" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
           <form name="project_form">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div class="form-group">
                    <h4 class="modal-title">Are You Sure You Want To Delete Project - <span id="submittername"></span></h4>
                     <input  readonly="readonly" style="width:40%" class="form-control" id="deltable" name="deltable"  type="hidden" value="<?php echo set_value('name'); ?>" />
                   <input  readonly="readonly" style="width:40%" class="form-control" id="delid" name="delid"  type="hidden" value="<?php echo set_value('delid'); ?>" />
                    <input  readonly="readonly" style="width:40%" class="form-control" id="name" name="name" placeholder="Your Full Name" type="hidden" value="<?php echo set_value('name'); ?>" />
                </div>
              
                
                <div id="alert-msg"></div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-default" id="delete" name="delete" type="button" value="Yes" />
                <input class="btn btn-default" type="button" data-dismiss="modal" value="No" />
            </div>
            </form>           
        </div>
    </div>
</div>
 <script type="text/javascript">
    $(document).on("click", ".open-AddBookDialog", function () {
      var name = $(this).data('name');
      var table = $(this).data('table');
      var editid = $(this).data('id');
      var status = $(this).data('status');
      var created = $(this).data('created');
      var accountmanager = $(this).data('accountmanager');
      var projectmanager = $(this).data('projectmanager');
      var developer = $(this).data('developer');
      var details = $(this).data('details');
      var no_of_task = $(this).data('no_of_task');
    //   $(".modal-body #bookId").val( myBookId );  
     $(".form-group #name").val( name );
     $(".form-group #status").val( status );
     $(".form-group #created").val( created );
     $(".form-group #accountmanager").val( accountmanager );
     $(".form-group #projectmanager").val( projectmanager );
     $(".form-group #developer").val( developer );
     $(".form-group #details").val( details );
     $(".form-group #no_of_task").val( no_of_task );
       


    $(".form-group #edittable").val( table );
    $(".form-group #editid").val( editid );

});
 $(document).on("click", ".open-deleteBookDialog", function () {
        var name = $(this).data('name');
        var table = $(this).data('table');
        var delid = $(this).data('id');

        //alert(name);
        //alert(table);
       // alert(delid);
        $(".form-group #name").val( name );
        $(".form-group #deltable").val( table );
        $(".form-group #delid").val( delid );
        $("#submittername").text(name);
});
$('#delete').click(function() {
 
    var form_data = {
            name: $('#name').val(),
            delid: $('#delid').val(),
            deltable: $('#deltable').val(),
          };  
    $.ajax({
        url: "<?php echo site_url('portal/delete'); ?>",
        type: 'POST',
        data: form_data,
        success: function(msg) {
           window.location.reload();   
            if (msg == 'sucess')
                $('#alert-msg').html('<div class="alert alert-success text-center">Deleted Successfully!</div>');
            else 
                $('#alert-msg').html('<div class="alert alert-danger text-center">Failed to Delete</div>');
           
        }
    });
   
    return false;
});

$('#add').click(function() {
   var form_data = {
            name: $('#details').val(),
            status: $('#details').val()
          }; 
         $.ajax({
        url: "<?php echo site_url('portal/add'); ?>",
        type: 'POST',
        data: form_data,
        success: function(msg) {
               //window.location.reload();     
             if (msg == 'sucess')
                $('#alert-msg').html('<div class="alert alert-success text-center">Edited Successfully</div>');
            
           else
                $('#alert-msg').html('<div class="alert alert-danger">Failed to edit, Please try again.</div>');
        }

    });
});   

$('#edit').click(function() {
  //alert("hi");
    var form_data = {
        name: $('#name').val(),
        id: $('#editid').val(),
        table: $('#edittable').val(),
        status: $('#status').val(),
        created: $('#created').val(),
        accountmanager: $('#accountmanager').val(),
        projectmanager: $('#projectmanager').val(),
        developer: $('#developer').val(),
        details: $('#details').val(),
        no_of_task: $('#no_of_task').val()
      };
        $.ajax({
        url: "<?php echo site_url('portal/edit'); ?>",
        type: 'POST',
        data: form_data,
        success: function(msg) {
               window.location.reload();     
             if (msg == 'sucess')
                $('#alert-msg').html('<div class="alert alert-success text-center">Edited Successfully</div>');
            
           else
                $('#alert-msg').html('<div class="alert alert-danger">Failed to edit, Please try again.</div>');
        }

    });
   
   

    return false;
});
</script>

