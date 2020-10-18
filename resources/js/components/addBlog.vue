<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div class="p-4">
        <h5 class="card-title" id="mediumModalLabel">Create Blog Category</h5>
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
          <h5 class="card-title" id="mediumModalLabel">Post Blog</h5>

          <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
          <div class="card form-group">
            <div class="card-body row">
              <div class="col-3">
                <label for="Title" class="form-control-label">Title</label>
              </div>
              <div class="col-7">
                <input
                  type="text"
                  id="Title"
                  placeholder="Enter The tile of the cource"
                  maxlength="250"
                  class="form-control"
                  v-model="title"
                />
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="banner" class="form-control-label"
                      >Upload Blog Banner</label
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
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="mediaType" class="form-control-label"
                      >What is the media type of the banner?</label
                    >
                    <select
                      name="select"
                      v-model="mediaType"
                      id="select"
                      class="form-control"
                    >
                      <option value="image">image</option>
                      <option value="Video">Video</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card card-body">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <label for="youtube" class="form-control-label">Tags</label>
                <small class="text-muted">Seperated by commas</small>
                <input
                  type="text"
                  id="cource"
                  placeholder="Enter The tile of the cource"
                  maxlength="250"
                  class="form-control"
                  v-model="tags"
                />
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="border border-info m-2 w-100 p-2">
                  <label for="youtube" class="form-control-label"
                    >Categories</label
                  >
                  <select
                    name="select"
                    id="select"
                    v-model="blog_category_id"
                    class="form-control"
                  >
                    <option value="0">Uncategoriesed</option>
                    <option v-for="(category, index) in blogCategories" :key="index" :value="category.id">{{category.name}}</option>
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
    /***
     * Recive this props only on update
     */
    user: Object,
  },
  data() {
    return {
      isLoading: false,
      blog_category_id: "0",
      tags: "",
      categoryName: "",
      fullPage: true,
      imageUrl: "",
      mediaType: "image",
      title: "",
      body: "",
      blogCategories: {},
      dropzoneOptions: {
        url: "http://pinnacle.test/api/courses/upload-video/" + 1,
        thumbnailWidth: 150,
        maxFilesize: 500,
        autoProcessQueue: true,
        // headers: { "My-Awesome-Header": "header value" }
      },
      objective: "",
    };
  },
  components: {
    vueDropzone: vue2Dropzone,
    VueLoadingButton,
    vue2Dropzone,
    Loading,
  },
  methods: {
    fetchMainCategory() {
      Axios.get("/courses/main_controller/all")
        .then((res) => {
          this.MainCategoriesFromDb = res.data;
          console.log(res);
        })
        .catch((err) => {
          this.$swal("Error", "An error occured, Try Later ", "error");
          this.MainCategoryFectchError = err.message;
          console.log(err);
        });
    },

    vfileAdded(file) {
      // this.fileAdded = true

      this.video = file;
      console.log(file);

      // window.toastr.info('', 'Event : vdropzone-file-added')
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

    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.imageUrl = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    hide() {
      this.$modal.hide("add-courses");
    },
    createCategory() {
      this.isLoading = false;
      axios
        .post("/admin/blog/category", {
          name: this.categoryName,
        })
        .then((response) => {
          this.$swal(
            "Blog Category Created!!",
            response.data.message,
            "success"
          );
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
                JSON.stringify(err.response.data.errors)
            ),
            "error"
          );
          console.log(JSON.stringify(err.response));
        });
    },
    getBlogCategory() {
      this.isLoading = true;
      axios
        .get("/admin/blog/category")
        .then((response) => {
            this.isLoading = false;
          this.blogCategories = response.data;
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
      var url = "/admin/blog";
      // this.isUpdate === true
      //   ? "/edit-course/" + this.course_id
      //   : "/upload-course";

      this.isLoading = true;
      let formData = new FormData();
      if (this.title !== "" && this.body !== "") {
        formData.append("blog_category_id", this.blog_category_id || 0);
        formData.append("tags", this.tags);
        formData.append("imageUrl", this.imageUrl);
        formData.append("mediaType", this.mediaType);
        formData.append("title", this.title);
        formData.append("body", this.body);
        formData.append("admin_id", this.user.id);
        axios
          .post(url, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            this.$swal("Blog Published!!", response.data.message, "success");
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
    this.getBlogCategory();
  },
};
</script>
