<template>
  <div>
    <form>
      <div class="form-group">
        <label for="checkimg">Please choose the file to check</label>
        <input type="file" @change="sendimg" />
      </div>
      <button v-on:click="clrimage" class="btn btn-primary">Clear</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      linktoimg: ""
    };
  },

  methods: {
    sendimg(event) {
      event.preventDefault();
      console.log(event.target.files[0]);
    },

    fetchColor() {
      fetch("api/chkcolor")
        .then(res => res.json())
        .then(res => {
          console.log(res.data);
        });
    }
  }
};
</script>