<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div class="p-4">
        <h5 class="card-title" id="mediumModalLabel">
          Create Content Category
        </h5>
        <div class="card form-group">
          <div class="card-body row">
            <div class="col-2">
              <label for="Title" class="form-control-label"
                >Category Name</label
              >
            </div>
            <div class="col-7">
              <input
                type="text"
                id="Title"
                placeholder="Enter category name"
                maxlength="250"
                class="form-control"
                v-model="categoryName"
              />
            </div>
            <div class="col-md-3">
              <button
                :disabled="categoryName === '' || !categoryName"
                @click.prevent="createCategory"
                class="btn btn-flat btn-success"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
      <div cclass="row">
        <div class="p-4">
          <h5 class="card-title" id="mediumModalLabel">
            Upload Free resoource/Content
          </h5>

          <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
          <div class="card form-group">
            <div class="card-body row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="mediaType" class="form-control-label"
                    >Short summary of the content</label
                  >
                  <input
                    type="text"
                    id="Title"
                    placeholder="Enter The tile of this content"
                    maxlength="250"
                    class="form-control"
                    v-model="subtitle"
                  />
                  <small class="text-muted">250 words</small>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <label for="Title" class="form-control-label">Title</label>
                <input
                  type="text"
                  id="Title"
                  placeholder="Enter the title of this content"
                  maxlength="250"
                  class="form-control"
                  v-model="title"
                />
              </div>
            </div>
          </div>
          <div class="card">
            <h5 class="card-title p-4" id="mediumModalLabel">
              Attach Downloadable file
              <small class="text-muted">You can add more files later</small>
            </h5>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input
                      type="file"
                      id="file"
                      @change="onFileChange"
                      class="form-control-file"
                    />
                  </div>
                  <div class="file-group">
                    <label for="filename" class="form-control-label"
                      >File Name</label
                    ><input
                      type="text"
                      v-model="filename"
                      name="filename"
                      id="filename"
                      class="form-control"
                      max="250"
                    />
                  </div>
                  <div class="form-group">
                    <label for="youtube" class="form-control-label"
                      >Media Type</label
                    >
                    <select
                      name="filetype"
                      id="filetype"
                      v-model="mediaType"
                      class="form-control"
                    >
                      <option value="Image">Image</option>
                      <option value="Video">Video</option>
                      <option value="Document">Pdf/Doc Document</option>
                      <option value="Document">Others</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="youtube" class="form-control-label"
                    >Short Caption for media</label
                  >
                  <textarea
                    name="mediaCaption"
                    id="mediaCaption"
                    class="form-control"
                    v-model="mediaCaption"
                    cols="10"
                    rows="5"
                    maxlength="250"
                  ></textarea>
                  <small :class=" captionLength <= 0 ? 'text-danger' : captionLength < 50 ? 'text-warning' : 'text-muted' " v-text="captionLength"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="banner" class="form-control-label"
                      >Upload Content Banner</label
                    >
                    <input
                      type="file"
                      id="banner"
                      accept="image/jpeg"
                      @change="onImageChange"
                      class="form-control-file"
                    />
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="youtube" class="form-control-label"
                    >Categories</label
                  >
                  <select
                    name="select"
                    id="select"
                    v-model="resource_category_id"
                    class="form-control"
                  >
                    <option value="0">Uncategoriesed</option>
                    <option
                      v-for="(category, index) in categories"
                      :key="index"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label class="form-control-label">Body</label>
                <wysiwyg v-model="body" />
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button
              type="button"
              id="close"
              class="au-btn au-btn-icon btn-secondary au-btn--small"
              @click.prevent="hide"
            >
              Cancel
            </button>
            <button
              type="button"
              class="au-btn au-btn-icon au-btn--green au-btn--small"
              @click="UploadPost"
            >
              Upload Post
              <span v-if="isLoading" class="fa fa-spin fa-spinner"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import VueLoadingButton from "vue-loading-button";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import vue2Dropzone from "vue2-dropzone";
import axios from "axios";
import Axios from "axios";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
  props: {
    user: Object,
  },
  data() {
    return {
      isLoading: false,
      title: "",
      subtitle: "",
      banner: "",
      fullPage: true,
      resource_category_id: "",
      body: "",
      categoryName: "",
      filename: "",
      mediaType: "Image",
      mediaCaption: "",
      file: "",
      categories: [],
      errors: {},
      error: null,
    };
  },
  computed: {
      captionLength() {
    return 250 - this.mediaCaption.length
}
  },
  components: {
    vueDropzone: vue2Dropzone,
    VueLoadingButton,
    vue2Dropzone,
    Loading,
  },
  methods: {
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createFile(files[0]);
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },

    onVideoChange() {
      this.video = this.$refs.video.files[0];
      console.log(this.video);
    },

    createFile(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.file = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.banner = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    hide() {
      this.$modal.hide("add-courses");
    },
    createCategory() {
      this.isLoading = false;
      axios
        .post("/admin/freeResource/category", {
          name: this.categoryName,
        })
        .then((response) => {
          this.$swal(
            "Category Created Successfully!!",
            response.data.message,
            "success"
          );
          this.isLoading = false;
          console.log(response);
          this.getResourceCategory();
        })
        .catch((err) => {
          this.isLoading = false;
          this.$swal(
            "Oops!!",
            JSON.stringify(
              (err.response &&
                err.response.data &&
                err.response.data.message) ||
                JSON.stringify(err.response.data.errors)
            ),
            "error"
          );
          console.log(JSON.stringify(err.response));
        });
    },
    getResourceCategory() {
      this.isLoading = true;
      axios
        .get("/admin/freeResource/category")
        .then((response) => {
          this.isLoading = false;
          this.categories = response.data;
          console.log(response);
        })
        .catch((err) => {
          this.isLoading = false;
          this.$swal(
            "Oops!!",
            JSON.stringify(
              (err.response &&
                err.response.data &&
                JSON.stringify(err.response.data.errors)) ||
                err.response.data.message
            ),
            "error"
          );
          console.log(JSON.stringify(err.response));
        });
    },
    uploadBanner(e) {
      console.log(e);
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.imageUrl = e.target.result;
      };
    },
    UploadPost() {
      var url = "/admin/freeResource";
      // this.isUpdate === true
      //   ? "/edit-course/" + this.course_id
      //   : "/upload-course";

      this.isLoading = true;
      let formData = new FormData();
      if (this.title !== "" && this.body !== "") {
        formData.append("title", this.title);
        formData.append("subtitle", this.subtitle);
        formData.append("banner", this.banner);
        formData.append("resource_category_id", this.resource_category_id);
        formData.append("body", this.body);
        formData.append("filename", this.filename);
        formData.append("mediaType", this.mediaType);
        formData.append("mediaCaption", this.mediaCaption);
        formData.append("file", this.file);
        formData.append("admin_id", this.user.id);
        axios
          .post(url, formData, { headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            this.$swal("Content created!!", response.data.message, "success");
            // this.url = this.response.data.video_id;
            this.isLoading = false;
            console.log(response);
          })
          .catch((err) => {
            this.isLoading = false;
            this.$swal(
              "Oops!!",
              JSON.stringify(
                (err.response &&
                  err.response.data &&
                  err.response.data.message) ||
                  err.response.data.errors
              ),
              "error"
            );
            console.log(JSON.stringify(err.response));
          });
      } else {
        this.isLoading = false;
        this.$swal(
          "Oops!!",
          "Some importantg details are missing, Ensure you fill the course title, description and upload a banner umage",
          "error"
        );
      }
    },
  },
  mounted() {
    this.getResourceCategory();
  },
};
</script>
