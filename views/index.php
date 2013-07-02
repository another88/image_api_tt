<div>
    <form name="upload"  method="POST" ENCTYPE="multipart/form-data">
    <fieldset>
        <legend>Image upload API</legend>
        <label>Add image</label>
            <input type="file" name="image">
        </label>
        <button name="upload" class="btn">Upload</button>
    </fieldset>
    </form>
    <p class="text-error"><?php echo $model->message; ?></p>
</div>