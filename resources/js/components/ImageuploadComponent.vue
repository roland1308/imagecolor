<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">File Upload Component</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <input type="file" v-on:change="onImageChange" class="form-control" />
              </div>
              <div class="col-md-3">
                <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
              </div>
              <div class="col-md-3" v-if="image">
                <img :src="image" class="img-responsive" height="70" width="90" />
              </div>
            </div>
          </div>
        </div>
        <div v-if="position">
          <div class="d-flex flex-row flex-wrap">
            <div v-for="(box, idx) in this.colorTable" :key="idx">
              <div
                class="col quadro"
                v-bind:style="{ backgroundColor: 'rgb(' + box[0] + ',' + box[1] + ',' + box[2] + ')'}"
              >{{box[3]}}</div>
            </div>
          </div>
          <p>The most used color in the image is similar to:</p>
          <div
            class="col quadro"
            v-bind:style="{ backgroundColor: 'rgb(' + this.colorFrequency[0] + ',' + this.colorFrequency[1] + ',' + this.colorFrequency[2] + ')'}"
          >{{this.colorFrequency[3]}}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      image: "",
      position: null,
      colorTable: [],
      colorFrequency: []
    };
  },

  methods: {
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    async uploadImage() {
      let response = await axios.post("/image/store", { image: this.image });
      if (response.data.success) {
        alert(response.data.success);
        console.log("RISULTATO 1", response.data.success);
        this.checkImage(response.data.success);
      }
    },
    async checkImage(fileLink) {
      let response = await axios.post("/image/check", { imageLink: fileLink });
      console.log(response.data);
      this.position = response.data.position;
      this.colorTable = JSON.parse(response.data.colorTable);
      this.colorFrequency = this.colorTable[this.position];
    }
  }
};
</script>