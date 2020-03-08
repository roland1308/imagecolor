<template>
  <div>
    <form>
      <div class="form-group">
        <label for="checkimg">Please choose the file to check</label>
        <input type="file" @change="imagePreview" />
      </div>
      <button class="btn btn-primary">Clear</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      linktoimg: "",
      color: ""
    };
  },

  methods: {
    imagePreview(event) {
      console.log(event.target.files[0]);
      let formData = new FormData();
      formData.append("image", event.target.files[0]);
      console.log(formData);

      axios
        .post("/formsubmit", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log(response, "success");
        })
        .catch(e => {
          console.log(e);
        });
    }
  }
};
</script>