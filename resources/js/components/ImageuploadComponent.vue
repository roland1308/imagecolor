<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">File Upload Component</div>
          <button class="btn btn-warning btn-block" v-if="reset" @click="resetData">RESET PAGE</button>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6" v-if="!reset">
                <input type="file" v-on:change="onImageChange" class="form-control" />
              </div>
              <div class="col-md-3">
                <button
                  class="btn btn-success btn-block"
                  v-if="image && !reset"
                  @click="uploadImage"
                >Upload Image</button>
              </div>
              <div class="col-md-3">
                <button
                  class="btn btn-success btn-block"
                  v-if="!image && !reset"
                  @click="browseImage"
                >Browse Images</button>
              </div>
              <div class="col-md-3" v-if="image && !reset">
                <img :src="image" class="img-responsive" height="70" width="90" />
              </div>
            </div>
            <div class="d-flex flex-row flex-wrap" v-if="imageList && !reset">
              <div v-for="(imageDB, idx) in this.imageList" :key="idx">
                <div>
                  <img
                    :src="'/images/' + imageDB.image_name"
                    class="fotine"
                    @click="checkImage('/images/' + imageDB.image_name)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="position">
          <div class="d-flex flex-row flex-wrap">
            <div v-for="(box, idx) in this.colorTable" :key="idx">
              <div
                class="quadro"
                :style="{ backgroundColor: 'rgb(' + box[0] + ',' + box[1] + ',' + box[2] + ')'}"
              >{{box[3]}}</div>
            </div>
          </div>
          <p>The most used color in the image is:</p>
          <div class="d-flex flex-row">
            <div
              class="quadro"
              :style="{ backgroundColor: 'rgb(' + this.askedColor[0] + ',' + this.askedColor[1] + ',' + this.askedColor[2] + ')'}"
            >RESULT</div>
            <div>
              <img :src="originalLink" class="fotine" />
            </div>
          </div>
          <p>And is similar to:</p>
          <div
            class="quadro"
            :style="{ backgroundColor: 'rgb(' + this.colorFrequency[0] + ',' + this.colorFrequency[1] + ',' + this.colorFrequency[2] + ')'}"
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
      colorFrequency: [],
      askedColor: [],
      imageList: [],
      reset: false,
      originalLink: ""
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
        // alert(response.data.success);
        // console.log("RISULTATO 1", response.data.success);
        this.checkImage(response.data.success);
      }
    },

    browseImage() {
      axios.get("/image/read").then(response => {
        this.imageList = response.data.success;
      });
    },

    async checkImage(fileLink) {
      console.log(fileLink);
      this.originalLink = fileLink;
      let response = await axios.post("/image/check", { imageLink: fileLink });
      // console.log(response.data);
      this.position = response.data.position;
      this.colorTable = JSON.parse(response.data.colorTable);
      this.colorFrequency = this.colorTable[this.position];
      this.askedColor = JSON.parse(response.data.mostUsed);
      this.reset = true;
    },

    resetData() {
      this.image = "";
      this.position = null;
      this.colorTable = [];
      this.colorFrequency = [];
      this.askedColor = [];
      this.imageList = [];
      this.reset = false;
      this.originalLink = "";
    }
  }
};
</script>



<style>
.quadro,
.fotine {
  width: 100px;
  height: 100px;
  margin: 10px;
}

.quadro {
  text-align: center;
  padding-top: 40px;
  font-weight: bolder;
  color: black;
  text-shadow: 0 0 15px rgba(255, 255, 255, 0.5),
    0 0 10px rgba(255, 255, 255, 0.5);
}

.fotine {
  border-radius: 5px;
  box-shadow: 5px 5px 15px 5px rgb(122, 117, 117);
}
</style>