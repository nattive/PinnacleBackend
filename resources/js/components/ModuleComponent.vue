<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-body">
              <div class="lead">
                Add modules to
                <strong>{{course.title}}</strong>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4>Module Essentials</h4>
              </div>
              <div class="card-body">
                <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>

                <!-- <div class="card-title">
                  <h3 class="text-center title-2">Pay Invoice</h3>
                </div>
                <hr />-->
                <form action method="post" novalidate="novalidate">
                  <div class="form-group">
                    <label for="company" class="form-control-label">Module Title</label>
                    <input
                      type="text"
                      id="title"
                      class="form-control"
                      v-model="title"
                      autocomplete="title"
                      placeholder="Module title"
                      @change="validateInput"
                      @blur="validateInput"
                    />
                    <small class="text-danger" v-text="hasError.title"></small>
                    <small>This feild is required</small>
                  </div>
                  <div class="form-group has-success">
                    <div class="form-group">
                      <label for="company" class="form-control-label">Module Objective</label>
                      <textarea
                        name="textarea-input"
                        id="textarea-input"
                        v-model="objective"
                        rows="9"
                        class="form-control"
                      ></textarea>
                      <small>e.g: at the end of the module, Student should be able to...</small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="company" class="form-control-label">Module prequisite</label>
                    <textarea type="text" id="company" class="form-control" v-model="prerequisite"></textarea>
                    <small>Courses Student should have taken before takinh the course</small>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <strong>Module Media</strong>
              </div>
              <div class="card-body">
                <div class="card-title">
                  <h3 class="text-center title-2">Video Source</h3>
                  <small class="text-danger" v-text="hasError.video"></small>
                </div>
                <hr />
                <!-- <div class="d-flex">
                  <div class="form-group">
                    <label for="youtube" class="form-control-label">YouTube</label>
                    <label class="switch switch-3d switch-primary mr-3">
                      <input
                        type="checkbox"
                        class="switch-input"
                        checked="true"
                        v-model="sourceIsYoutube"
                      />
                      <span class="switch-label"></span>
                      <span class="switch-handle"></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label for="youtube" class="form-control-label">Pinnacle Server</label>
                    <label class="switch switch-3d switch-primary mr-3">
                      <input
                        type="checkbox"
                        class="switch-input"
                        checked="true"
                        v-model="sourceIsServer"
                        @change="validateInput"
                        @blur="validateInput"
                      />
                      <span class="switch-label"></span>
                      <span class="switch-handle"></span>
                    </label>
                  </div>
                </div>-->
                <div class="form-group">
                  <!-- <label for="company" class="form-control-label">Video Link</label>
                  <input
                    type="text"
                    id="youtube"
                    autocomplete="youtube"
                    placeholder="youtube link e.g Iz08OTTjR04"
                    class="form-control"
                    v-model="videoLink"
                  />-->

                  <small>For Video Uploaded on external server like youtube</small>
                </div>
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="file-input" class="form-control-label" ref="video">Upload Video</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <input type="file" id="video" ref="video" v-on:change="handleUpload()" />
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <strong>Module Media</strong>
              </div>
              <div class="card-body">
                <div class="card-title">
                  <h3 class="text-center title-2">Module banner/thumbnail</h3>
                </div>
                <hr />
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="file-input" class="form-control-label">Upload Image</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <input
                      type="file"
                      id="file-input"
                      @change="uploadBanner"
                      name="file-input"
                      class="form-control-file"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <strong>Add Module Header</strong>
              </div>
              <div class="card-body">
                <select v-model="moduleId" class="form-control">
                  <option
                    v-for="( moduleItem, key) in module"
                    :value="moduleItem.id"
                    :key="key"
                  >{{moduleItem.title}}</option>
                </select>
                <add-module :course_id="course.id"></add-module>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Module Text</h4>
                <small class="text-danger" v-text="hasError.text"></small>
              </div>
              <div class="card-body">
                <wysiwyg v-model="text" @change="validateInput" @blur="validateInput" />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="d-flex float-right">
            <button class="btn btn-flat btn-prrimary-outline ml-2">Save</button>
            <button class="btn btn-secondary btn-flat ml-2">Go Back</button>
            <button
              class="btn btn-flat btn-primary ml-2"
              @click.prevent="handleSubmit"
              :disabled="!isErrorIsEmpty"
            >Add Module</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import AddModuleCard from "./AddModuleCard";
import "vue-loading-overlay/dist/vue-loading.css";
import Axios from "axios";
export default {
  props: {
    course: Object
  },
  data() {
    return {
      questionArray: [],
      question: {},
      module: {},
      title: "",
      moduleId: "",
      no_question: 2,
      question_active: true,
      fullPage: true,
      text: "",
      quiz: "",
      isLoading: false,
      objective: "",
      description: "",
      prerequisite: "",
      sourceIsYoutube: "",
      sourceIsServer: "",
      videoLink: "",
      media: "",
      video: "",
      images: "",
      hasError: {}
    };
  },
  computed: {
    isErrorIsEmpty() {
      this.validateInput();
      for (var key in this.hasError) {
        if (this.hasError.hasOwnProperty(key)) {
          return false;
        }
      }
      return true;
    }
  },
  components: {
    Loading
  },
  methods: {
    fetchmodule() {
      Axios.get("/courses/nodules/get/" + this.course.id)
        .then(data => (this.module =  data.data.module))
        .catch(err => console.log(err));
    },
    addQuestionToArray() {
      if (this.question !== {}) {
        this.questionArray.push(Object.assign({}, this.question));
        this.question = {};
        this.$swal("Done!!", "Question added to module", "success");
      } else {
        this.$swal("Error!!", "Either question or option is empty", "error");
      }
    },
    validateInput() {
      if (this.title === "" || this.title.length <= 2) {
        this.hasError.title = " Title field cannot be empty";
      } else {
        delete this.hasError.title;
      }
      if (this.text === "" || this.text.length <= 50) {
        this.hasError.text =
          " Module have to contain a well explained text of at least 50 characters long";
      } else {
        delete this.hasError.text;
      }
      if (this.video === "") {
        this.hasError.video = "Upload a video or paste the youtube link";
      } else {
        delete this.hasError.video;
      }
    },
    handleUpload() {
      this.video = this.$refs.video.files[0];
      console.log(this.video);
    },
    fetchModuleTitle() {},
    handleSubmit() {
      this.validateInput();
      if (this.isErrorIsEmpty) {
        this.isLoading = true;
        let formData = new FormData();
        formData.append("course_module_id", this.moduleId);
        formData.append("title", this.title);
        formData.append("text", this.text);
        for (let index = 0; index < this.questionArray.length; index++) {
          const element = JSON.stringify(this.questionArray[index]);
          console.log(element);

          formData.append("quiz[]", element);
        }
        formData.append("objective", this.objective);
        formData.append("prerequisite", this.prerequisite);
        formData.append("sourceIsYoutube", this.sourceIsYoutube);
        formData.append("sourceIsServer", this.sourceIsServer);
        formData.append("videoLink", this.videoLink);
        formData.append("media", this.media);
        formData.append("video", this.video);
        formData.append("images", this.images);
        console.log(formData);

        Axios.post("/course/add-module", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
          .then(res => {
            console.log(res);
            this.isLoading = false;
            this.$swal("Done!!", res.data.message, "success");
          })
          .catch(err => {
            console.log(err);
            this.$swal("Error Occured", "Some error occoured", "error");
          });
      } else {
        this.isLoading = false;

        this.$swal(
          "Missing Required fields!!",
          "Some required fields are missing, Ensure the title fields, Main module text are filld and you upload a video or paste the video youtube link",
          "error"
        );
      }
    },
    uploadBanner(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.images = e.target.result;
        console.log(this.images);
        //  = image;
      };
    }
  },
  mounted() {
    this.fetchmodule();
  }
};
</script>
