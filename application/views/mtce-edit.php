<h2>Menu Maintenance - {action}</h2>
{error_messages}
<form action="/crud/save" method="post" enctype="multipart/form-data">
{fpicture}
<div class="form-group">
        <label for="replacement">Replacement picture</label>
        <input type="file" id="replacement" name="replacement"/>
</div>
{fcategory}
{fid}
{fname}
{fdescription}
{fprice}
{fpicture}
{fcategory}
{zsubmit} <a class="btn btn-default" role="button" href="/crud/cancel">Cancel</a>
 <a class="btn btn-default" role="button" href="/crud/delete">Delete</a>
 <a class="btn btn-default" role="button" href="/crud/add">Add a new menu item</a>
</form>