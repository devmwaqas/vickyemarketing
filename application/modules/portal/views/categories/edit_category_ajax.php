<div>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h5 class="modal-title">Edit Category</h5>
	</div>
	<div class="modal-body">
		<form id="edit_form" enctype="multipart/form-data">
			<input type="hidden" name="category_id" class="form-control" value="<?php echo $category['id']; ?>">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Parent Category</label>
				<div class="col-sm-9">
					<select class="form-control input-sm" name="parent_id">
						<option value="0">Select Category</option>
						<?php foreach (get_categories() as $cat) { ?>
							<option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $category['parent_id']) { ?> selected <?php } ?>><?php echo $cat['cat_name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"> Title </label>
				<div class="col-sm-9">
					<input type="text" name="category_name" class="form-control input-sm" placeholder="Enter Title" value="<?php echo $category['cat_name']; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3"> Is Active </label>
				<div class="col-sm-9">
					<div class="i-checks">
						<label> <input type="checkbox" name="status" <?php if($category['status'] == 1) { ?> checked <?php } ?>> <i></i> Yes </label>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" id="update_button"> Save Changes </button>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	});
</script>