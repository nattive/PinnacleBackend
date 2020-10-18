<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div cclass="row">
        <div class="col-md-12">
          <div class="overview-wrap">
            <h2 class="title-1">overview</h2>

            <button
              v-if="!user.tutor_id"
              @click.prevent="openTutorModal"
              class="au-btn au-btn-icon au-btn--blue float-right"
            >
              <i class="zmdi zmdi-plus"></i>Be a Tutor
            </button>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-lg-6">
            <div class="au-card recent-report">
              <div class="au-card-inner">
                <h3 class="title-2">Upload Sliders</h3>
                <div class="form-group p-4">
                  <input type="text" class="form-control" placeholder="Image Text" />
                </div>
                <div class="border border-info p-4">
                  <label
                    for
                    class="text-muted text-center m-4 mx-auto"
                  >Click or Drag and drop image here to upload</label>
                  <upload-image
                    :disable_upload="true"
                    is="upload-image"
                    :url="'/admin/'"
                    v-on:upload-image-submit="uploadImageSubmit"
                    :max_files="5"
                    :resize_enabled="true"
                    :resize_max_width="640"
                    :button_class="'btn btn-primary'"
                  ></upload-image>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="au-card chart-percent-card">
              <div class="au-card-inner">
                <h3 class="title-2 tm-b-5">Add Service/Product</h3>
                <div class="row no-gutters">
                  <div class="col-xl-6"></div>
                  <div class="col-xl-6">
                    <div class="percent-chart">
                      <canvas id="percent-chart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal width="60%" height="auto" scrollable name="add-tutor">
      <add-tutor></add-tutor>
    </modal>
  </div>
</template>

<script>
import UploadImage from "vue-upload-image";
import Axios from "axios";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import myUpload from "vue-image-crop-upload";
import AddTutor from './AddTutor'
export default {
  props: {
    user: Object
  },
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
      profileImage: ""
    };
  },
  components: {
    UploadImage,
    Loading,
    "my-upload": myUpload,
    AddTutor
  },
  methods: {

    uploadImageSubmit: function(image) {
      //   image.name || image.file;
      console.log(image);
    },

    openTutorModal() {
      this.$modal.show("add-tutor");
    },
    closeTutorModal() {
      this.$modal.hide("add-tutor");
    },
    createTutor() {
      this.loading = true;
      Axios.post("/tutor/create/" + this.user.id)
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
    },
    saveUser() {
      localStorage.removeItem("user");
      localStorage.setItem("user", JSON.stringify(this.user));
    }
  },
  mounted() {
    console.log("Component mounted.");
    this.saveUser();
  }
};
</script>
