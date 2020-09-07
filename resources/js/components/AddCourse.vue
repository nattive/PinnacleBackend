<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div cclass="row">
        <div class="p-4">
          <h5 class="card-title" id="mediumModalLabel">{{ modalTitle }}</h5>

          <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
          <div class="card form-group">
            <div class="card-body row">
              <div class="col-3">
                <label for="Course" class="form-control-label">Course Title</label>
              </div>
              <div class="col-7">
                <input
                  type="text"
                  id="cource"
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="banner" class="form-control-label">Upload Course Banner</label>
                    <input
                      type="file"
                      id="banner"
                      accept="image/jpeg"
                      @change="onImageChange"
                      class="form-control-file"
                    />
                  </div>
                  <div class="form-group">
                    <label
                      for="course_category"
                      class="form-control-label"
                    >Make Course available for Pinnacle Online members</label>
                    <div class="col-3">
                      <label class="switch switch-3d switch-primary mr-3">
                        <input type="checkbox" class="switch-input" v-model="isPO" checked="true" />
                        <span class="switch-label"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label
                      for="youtube"
                      class="form-control-label"
                    >Introductory video (youtube Link)</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="introVideo"
                      placeholder="input youtube video link e.g RFV4fes1"
                    />
                    <!-- <vue-dropzone
                      ref="myVueDropzone"
                      id="dropzone"
                      :options="dropzoneOptions"
                      @vdropzone-file-added="vfileAdded"
                    ></vue-dropzone>-->
                    <label>
                      File
                      <input type="file" id="video" ref="video" v-on:change="onVideoChange()" />
                    </label>
                    <!-- <input
                      type="file"
                      accept="video/mp4"
                      id="banner"
                      @change="onVideoChange"
                      class="form-control-file"
                    />-->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card card-body">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="border border-info m-2 w-100 p-2">
                  <ul class="nav" v-for="(category, index) in MainCategoriesFromDb" :key="index">
                    <li
                      class="p-2 categoryList"
                      @click="fetchSubCategory(category.id)"
                    >{{category.name}}</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="border border-info m-2 w-100 h-100 p-2">
                  <ul class="nav" v-for="(category, index) in SubCategoriesFromDb" :key="index">
                    <loading :active.sync="SubCategoriesFromDbLoading" :is-full-page="!fullPage"></loading>
                    <li
                      class="p-2 categoryList"
                      @click="setSubCategory(category.id)"
                    >{{category.name}}</li>
                    <li v-if="SubCategoriesFromDb.length <= 0">No Subcategory here</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-7">
                        <label
                          for="course_category"
                          class="form-control-label"
                        >Make Course available for CotF members</label>
                      </div>
                      <div class="col-3">
                        <label class="switch switch-3d switch-primary mr-3">
                          <input
                            type="checkbox"
                            class="switch-input"
                            v-model="isCareer"
                            :checked="isCareer"
                          />
                          <span class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-7">
                        <label
                          for="company"
                          class="form-control-label"
                        >This cource is a free Resource available to all members</label>
                      </div>
                      <div class="col-3">
                        <label class="switch switch-3d switch-primary mr-3">
                          <input
                            type="checkbox"
                            class="switch-input"
                            v-model="isFree"
                            :checked="isPO"
                          />
                          <span class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-3">
                    <label for="company" class="form-control-label">Course Price</label>
                  </div>
                  <div class="col-7">
                    <div class="input-group">
                      <input
                        :disabled="isFree"
                        type="number"
                        id="input2-group1"
                        name="input2-group1"
                        v-model="price"
                        placeholder="Enter Course price, Leave blank or 0 if free"
                        class="form-control"
                      />
                      <div class="input-group-addon">
                        <small>₦</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="form-control-label">Course Ojective</label>
                <wysiwyg v-model="objective" />
              </div>
              <div class="form-group">
                <label for="company" class="form-control-label">Course Description</label>
                <wysiwyg v-model="description" />
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button
              type="button"
              id="close"
              class="au-btn au-btn-icon btn-secondary au-btn--small"
              @click.prevent="hide"
            >Cancel</button>
            <button
              type="button"
              class="au-btn au-btn-icon au-btn--green au-btn--small"
              @click="UploadCourse"
            >
              Proceed to Video Upload
              <span v-if="isLoading" class="fa fa-spin fa-spinner"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style  scoped>
.categoryList:hover {
  color: white;
  background: #000066;
}
</style>

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
    course_id: Number,
    isUpdate: Boolean
  },
  data() {
    return {
      title: "",
      banner: "",
      isFree: true,
      SubCategoriesFromDbLoading: false,
      isPO: false,
      isCareer: false,
      isLoading: false,
      price: "",
      introVideo: "",
      video: "",
      sub_category_id: "",
      fullPage: true,
      description: "",
      MainCategoriesFromDb: {},
      SubCategoriesFromDb: {},
      MainCategoryFectchError: "",
      url: null,
      dropzoneOptions: {
        url: "http://pinnacle.test/api/courses/upload-video/" + 1,
        thumbnailWidth: 150,
        maxFilesize: 500,
        autoProcessQueue: true
        // headers: { "My-Awesome-Header": "header value" }
      },
      objective: ""
    };
  },
  components: {
    vueDropzone: vue2Dropzone,
    VueLoadingButton,
    vue2Dropzone,
    Loading
  },
  computed: {
    tutor_id: function() {
      var user = localStorage.getItem("user");
      return JSON.parse(user).tutor_id;
    },

    modalTitle: function() {
      return this.isUpdate === true ? "Edit Course" : "Course Title";
    },
    buttonText: function() {
      return this.isUpdate === true ? "Update Course" : "Create Course";
    }
  },
  methods: {
    setSubCategory(id) {
      this.sub_category_id = id
      console.log(id);
      
    },
    fetchSubCategory(id) {
      this.SubCategoriesFromDbLoading = true;
      Axios.get("/courses/main_controller/show/" + id)
        .then(res => {
          this.SubCategoriesFromDb = res.data.mainCategory;
        })
        .catch(err => console.error(err));
      this.SubCategoriesFromDbLoading = false;
    },
    fetchMainCategory() {
      Axios.get("/courses/main_controller/all")
        .then(res => {
          this.MainCategoriesFromDb = res.data;
          console.log(res);
        })
        .catch(err => {
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
      reader.onload = e => {
        vm.banner = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    hide() {
      this.$modal.hide("add-courses");
    },
    getCourse(id) {
      return new Promise((res, rej) => {
        Axios.get("/courses/" + id)
          .then(response => {
            return res(response);
          })
          .catch(err => {
            return rej(err);
          });
      });
    },
    async checkUpdate() {
      if (this.isUpdate) {
        this.isLoading = true;
        const coursedata = await this.getCourse(this.course_id);
        const course = coursedata.data;
        this.title = course.title;
        this.banner = course.banner;
        this.isFree = course.isFree;
        this.isPO = course.isPO;
        this.isCareer = course.isCareer;
        this.video = course.video;
        this.price = course.price;
        this.fullPage = course.fullPage;
        this.description = course.description;
        this.isLoading = false;
      }
    },
    uploadBanner(e) {
      console.log(e);
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.previewImage = e.target.result;
        this.banner = this.previewImage;
      };
    },
    fetchCourse() {
      this.fetchingCourse = true;
      Axios.get("/course/tutor/" + this.tutor_id)
        .then(response => {
          this.courses = response.data;
          this.fetchingCourse = false;
        })
        .catch(err => {
          this.fetchingCourse = false;
          console.error(err);
        });
    },
    UploadCourse() {
      var url =
        this.isUpdate === true
          ? "/edit-course/" + this.course_id
          : "/upload-course";
      if (!this.tutor_id) {
        this.$swal(
          "You are not a tutor, yet!!!",
          "Please sign up as a tutor to create a course",
          "error"
        );
      } else {
        this.isLoading = true;
        if (
          this.title !== "" &&
          this.banner !== "" &&
          this.description !== ""
        ) {
          let formData = new FormData();
          formData.append("video", this.video);
          formData.append("title", this.title);
          formData.append("banner", this.banner);
          formData.append("isFree", this.isFree);
          formData.append("isPO", this.isPO);
          formData.append("isCareer", this.isCareer);
          formData.append("isLoading", this.isLoading);
          formData.append("price", this.price);
          formData.append("introVideo", this.introVideo);
          formData.append("video", this.video);
          formData.append("fullPage", this.fullPage);
          formData.append("description", this.description);
          formData.append("objective", this.objective);
          formData.append("tutor_id", this.tutor_id);
          formData.append("sub_category_id", this.sub_category_id);
          axios
            .post(url, formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.$swal("Done!!", response.data.message, "success");
              // this.url = this.response.data.video_id;
              this.isLoading = false;
              console.log(response);
            })
            .finally(() => this.fetchCourse())
            .catch(err => {
              this.isLoading = false;
              this.$swal("Oops!!", err.message, "error");
              console.log(JSON.stringify(err));
            });
        } else {
          this.isLoading = false;
          this.$swal(
            "Oops!!",
            "Some importantg details are missing, Ensure you fill the course title, description and upload a banner umage",
            "error"
          );
        }
      }
    }
  },
  mounted() {
    this.title = "";
    this.banner = "";
    this.isFree = true;
    this.isPO = false;
    this.isCareer = false;
    this.price = "";
    this.fullPage = true;
    this.description = "";
    this.checkUpdate();
    this.fetchMainCategory();
  }
};
</script>