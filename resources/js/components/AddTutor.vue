<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div cclass="row">
        <div class="d-flex justify-content-end">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card-block">
          <loading :active.sync="loading" :is-full-page="false"></loading>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="name" class="form-control-label">Display Name</label>
                <input type="text" class="form-control" v-model="tutorName" />
                <small class="text-muted">This feild is required</small>
              </div>
            </div>
            <div class="col-6">
              <h4 class="lead text-center">Tuttor type</h4>
              <label for>Sign up as tutor for Pinnacle Online E-learning</label>
              <label class="switch switch-3d switch-primary mr-3">
                <input
                  type="checkbox"
                  class="switch-input"
                  v-model="isPO_tutor"
                  :checked="isPO_tutor"
                />
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
              <label for>Sign up as tutor for Creer for the future</label>
              <label class="switch switch-3d switch-primary mr-3">
                <input
                  type="checkbox"
                  class="switch-input"
                  v-model="isCotF_tutor"
                  :checked="isCotF_tutor"
                />
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </label>
            </div>
            <!-- <div class="col-6">
              <a class="btn" @click="toggleShow">Upload Profile Image</a>
              <my-upload
                field="img"
                @crop-success="cropSuccess"
                @crop-upload-success="cropUploadSuccess"
                @crop-upload-fail="cropUploadFail"
                noSquare
                v-model="show"
                :width="300"
                :height="300"
                url="/upload"
                :params="params"
                :headers="headers"
                img-format="png"
                langType ='en'
              ></my-upload>
              <img :src="imgDataUrl" />
            </div>-->
          </div>

          <hr class="my-4" />
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="text-input" class="form-control-label">About You</label>
                <textarea name id class="form-control" cols="30" rows="10" v-model="about"></textarea>
                <small
                  class="form-text text-muted"
                >This information will be displayed and visble in the tutors page</small>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for class="form-group-label">Facebook profile Link</label>
                <input
                  type="text"
                  v-model="facebookAccount"
                  class="form-control"
                  placeholder="e.g facebook.com/pinnacleTutor"
                />
              </div>
              <div class="form-group">
                <label for class="form-group-label">Youtube Channel Link</label>
                <input
                  v-model="youtubeAccount"
                  type="text"
                  class="form-control"
                  placeholder="e.g https://www.youtube.com/channel/UkrnmI005gPotgNzygUIBA"
                />
              </div>
              <div class="form-group">
                <label for class="form-group-label">LinkedIn Profile</label>
                <input
                  type="text"
                  v-model="linkedinAccount"
                  class="form-control"
                  placeholder="e.g https://www.linkedin.com/in/pinnacle-tutor-xxxxxx/"
                />
              </div>
              <div class="form-group">
                <label for class="form-group-label">Twitter handle</label>
                <input
                  type="text"
                  v-model="TwitterAccount"
                  class="form-control"
                  placeholder="e.g @pinnacleTutor"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="button" id="cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" @click.prevent="createTutor">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UploadImage from "vue-upload-image";
import Axios from "axios";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import myUpload from "vue-image-crop-upload";

export default {
  data() {
    return {
      show: false,
      params: {
        token: "123456798",
        name: "avatar"
      },
      headers: {
        smail: "*_~"
      },
      imgDataUrl: "",
      about: "",
      isCotF_tutor: true,
      isPO_tutor: true,
      about: "",
      loading: false,
      facebookAccount: "",
      youtubeAccount: "",
      linkedinAccount: "",
      TwitterAccount: "",
      tutorName: "",
      user: "",
      profileImage: ""
    };
  },
  components: {
    UploadImage,
    Loading,
    "my-upload": myUpload
  },
  methods: {
    getAdmin: function() {
      const user = JSON.parse(localStorage.getItem("user"));
      this.tutorName = user.name;
      this.user = user;
    },
    /****** Admin image upload *******/
    cropSuccess(imgDataUrl, field) {
      console.log("-------- crop success --------");
      this.imgDataUrl = imgDataUrl;
    },
    /**
     * upload success
     *
     * [param] jsonData  server api return data, already json encode
     * [param] field
     */
    cropUploadSuccess(jsonData, field) {
      console.log("-------- upload success --------");
      console.log(jsonData);
      console.log("field: " + field);
    },
    /**
     * upload fail
     *
     * [param] status    server api return error status, like 500
     * [param] field
     */
    cropUploadFail(status, field) {
      console.log("-------- upload fail --------");
      console.log(status);
      console.log("field: " + field);
    },
    toggleShow() {
      this.show = !this.show;
    },
    uploadImageSubmit: function(image) {
      //   image.name || image.file;
      console.log(image);
    },
    uploadTutorProfileImage: function(image) {
      //   image.name || image.file;
      console.log(image);
    },
    /****** Admin image upload end *******/

    openTutorModal() {
      this.$modal.show("add-tutor");
    },
    closeTutorModal() {
      this.$modal.hide("add-tutor");
    },
    createTutor() {
      this.loading = true;
      Axios.post("/tutor/create/" + this.user.id, {
        name: this.tutorName,
        admin_id: this.user.id,
        facebook: this.facebookAccount,
        twitter: this.TwitterAccount,
        youTube: this.youtubeAccount,
        isCotF_tutor: this.isCotF_tutor,
        isPO_tutor: this.isPO_tutor,
        about: this.about,
        linkedIn: this.linkedinAccount,
        image: this.profileImage
      })
        .then(response => {
          this.$swal(
            "Done",
            "Tutor Account Created!! Please wait while the page refreshes",
            "success"
          );
          var mediumModalLabel = document.getElementById("close");
          window.location.href = "/";
          if (mediumModalLabel) {
            mediumModalLabel.click();
          }
          this.loading = false;
        })
        .catch(error => {
          this.$swal("An error occured!!", "error");
          console.error(error);
          this.loading = false;
        });
    }
  },
  mounted() {
    this.getAdmin();
  }
};
</script>
