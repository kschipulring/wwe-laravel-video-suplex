<?php  use App\Http\Helpers; ?>

<input type="text" id="title" name="title" class="form-control" v-model="form.title" :disabled="disabled == 1 ? true : false"
placeholder="your awesome title" autofocus />

<div class="checkbox mb-3">
  <label>
    <input type="checkbox" id="checkbox" v-model="disabled" name="use_meta_title" /> <sub>Attempt to use title from video meta data if one is present</sub>
  </label>
</div>

<div class="mb-3">
  <label for="videofile">Maximum file size: <?php echo Helpers::getMaxFileUploadSize() / 1048576; ?>MB</label>
  <input name="videofile" type="file" max-size="<?php echo Helpers::getMaxFileUploadSize(); ?>" accept="video/mp4" @change="processFile($event)" required />
</div>
<button class="btn btn-lg btn-danger btn-block" type="submit" :disabled="uploaddisabled == 1 ? true : false" v-bind:title="uploadbuttontitle">
Upload</button>