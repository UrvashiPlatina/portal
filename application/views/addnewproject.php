<script type="text/javascript">
 $( document ).ready(function() {
$('#addnewproject').click(function() {
    //alert("hi");
    var form_data = $("#frmaddnewproject").serialize();    
    $.ajax({
        url: "<?php echo site_url('portal/addprojectdata'); ?>",
        type: 'POST',
        data: form_data,
        success: function(msg) {
          //window.location.reload();   
            if (msg == 'sucess')
                $('#alert-msg').html('<div class="alert alert-success text-center">Deleted Successfully!</div>');
            else 
                $('#alert-msg').html('<div class="alert alert-danger text-center">Failed to Delete</div>');
           
        }
    });
   
    return false;
});
});
</script>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Form elements</a> <a href="#" class="current">Validation</a> </div>
    <h1>Add New Project</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add New Project</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="#" name="frmaddnewproject" id="frmaddnewproject" novalidate="novalidate">
              <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="name" required="required">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                  <input type="text" name="status" id="status">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Created Date</label>
                <div class="controls">
                  <input type="text" name="created" id="created">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Account Manager</label>
                <div class="controls">
                  <input type="text" name="accountmanager" id="accountmanager">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Project manager</label>
                <div class="controls">
                  <input type="text" name="projectmanager" id="projectmanager">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Developer</label>
                <div class="controls">
                  <input type="text" name="developer" id="developer">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Details</label>
                <div class="controls">
                  <input type="text" name="details" id="details">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">No of Task</label>
                <div class="controls">
                  <input type="text" name="no_of_task" id="no_of_task">
                </div>
              </div>
              <div class="form-actions">
                <input type="button" value="Add New" id="addnewproject" name="addnewproject" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
