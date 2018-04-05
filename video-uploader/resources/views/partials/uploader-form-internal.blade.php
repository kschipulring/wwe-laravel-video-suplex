<input type="text" id="title" name="title" class="form-control" v-model="form.title" :disabled="disabled == 1 ? true : false"
placeholder="your awesome title" autofocus />

<div class="checkbox mb-3">
  <label>
    <input type="checkbox" id="checkbox" v-model="disabled" /> <sub>Attempt to use title from video meta data if one is present</sub>
  </label>
</div>

<div class="mb-3">
  <input name="videofile" type="file" accept="video/mp4" @change="processFile($event)" required />
</div>
<button class="btn btn-lg btn-primary btn-block" type="submit" :disabled="uploaddisabled == 1 ? true : false" v-bind:title="uploadbuttontitle">
Upload</button>