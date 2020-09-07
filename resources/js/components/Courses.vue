<template>
  <div class="main-content bg-light">
    <div class="section__content section__content--p30">
      <!-- DATA TABLE -->
      <h3 class="title-5 m-b-35">Your Courses</h3>
      <div class="table-data__tool">
        <div class="table-data__tool-right">
          <a
            type="a"
            :href="'/courses/create'"
            class="au-btn au-btn-icon au-btn--green au-btn--small"
          >
            <i class="zmdi zmdi-plus"></i>Create Courses
          </a>
          <button
            class="au-btn au-btn-icon au-btn--green au-btn--small"
            @click.prevent="fetchCourses"
          >
            <i class="zmdi zmdi-refresh"></i>refresh Courses
          </button>
        </div>
      </div>
      <div class="section__content section__content--p30">
        <div class="table-responsive table--no-card m-b-30">
          <loading :active.sync="fetchingCourse" :is-full-page="false"></loading>

          <table class="table table-borderless table-striped table-earning">
            <thead>
              <tr>
                <th>Course Title</th>
                <th>Enrolled Members</th>
                <th>Modules</th>
                <th>Category</th>
                <th>price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(course, index) in courses.data" :key="index" class="tr-shadow">
                <td>{{course.title}}</td>
                <td>{{course.views}}</td>
                <td>{{course.modules.length}}</td>
                <!-- <td>{{ new Date('2015', course.created_at) }}</td> -->
                <td>
                  <p v-show="course.isCareer">Available for CotF Members</p>
                  <p v-show="course.isPO">Available for Pinnacle online Members</p>
                  <p v-show="course.isFree">Course is free</p>
                </td>
                <td>{{course.price ? `₦${course.price}` : 'Free'}}</td>
                <td>
                  <div class="table-data-feature">
                    <a
                      class="item"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Add modules"
                      :href="'/courses/modules/add/'+course.id"
                    >
                      <i class="zmdi zmdi-plus"></i>
                    </a>
                    <button
                      class="item"
                      :href="'/courses/modules/edit/'+course.id"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Edit and manage course modules"
                    >
                      <i class="fa fa-edit"></i>
                    </button>
                    <br />
                    <button
                      class="item"
                      data-toggle="tooltip"
                      data-placement="Delete course"
                      title="Delete course"
                      @click.prevent="deleteCourse(course.id)"
                    >
                      <i class="zmdi zmdi-delete"></i>
                    </button>

                    <!-- <button
                    class="item"
                    data-toggle="tooltip"
                    data-placement="edit course"
                    title="edit course"
                    @click.prevent="show(course.id)"
                  >
                    <i class="zmdi zmdi-edit"></i>
                    </button>-->

                    <a
                      class="item"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="View all course modules"
                      :href="`/courseModuleList/${course.id}`"
                    >
                      <i class="fa fa-eye"></i>
                    </a>

                    <a
                      class="item"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Edit Course"
                      :href="`/courses/edit/${course.id}`"
                    >
                      <i class="zmdi zmdi-more"></i>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- END DATA TABLE -->
    </div>
    <!-- <modal width="60%" @before-open="beforeOpen" height="auto" scrollable name="add-courses"> -->
    <!-- <div class="modal-dialog modal-lg" role="document"> -->
    <!-- <add-courses :course_id="editCourse_id" :isUpdate="isUpdate"></add-courses> -->
    <!-- </div> -->
    <!-- </modal> -->
  </div>
</template>

<script>
import AddModuleCard from "./AddModuleCard";
import AddCourses from "./AddCourse";
import Loading from "vue-loading-overlay";
import ActivityIndicator from "vue-activity-indicator";
import VueLoadingButton from "vue-loading-button";
import Axios from "axios";
export default {
  data() {
    return {
      courses: {},
      fetchingCourse: false,
      isUpdate: false,
      fetchingeditCourse: false,
      editCourse_id: null,
      editCourse: {},
    };
  },
  computed: {
    tutor_id: function () {
      var user = localStorage.getItem("user");
      return JSON.parse(user).tutor_id;
    },
  },
  components: {
    ActivityIndicator,
  },
  methods: {
    deleteCourse(id) {
      if (
        window.confirm(
          "Do you really want to detee the course? This can't be undone"
        )
      ) {
        this.fetchingCourse = true;
        Axios.get("/course/delete/" + id)
          .then((response) => {
            this.$swal("Deleted!!", response.data, "success");
            this.fetchCourses();
            this.fetchingCourse = false;
          })
          .catch((err) => {
            this.$swal("Oops!!", err.message, "error");
            this.fetchingCourse = false;
          });
      }
    },
    getCourse(id) {
      return new Promise((res, rej) => {
        Axios.get("/courses/" + id)
          .then((response) => {
            return res(response);
          })
          .catch((err) => {
            return rej(err);
          });
      });
    },
    beforeOpen(event) {
      this.editCourse_id = event.params.tutor_id;
      console.log(event.params.tutor_id);
    },
    show(id) {
      if (id === null) {
        this.$modal.show("add-courses", { tutor_id: null });
        this.isUpdate = false;
      } else {
        this.$modal.show("add-courses", { tutor_id: id });
        this.isUpdate = true;
      }
    },
    hide() {
      this.$modal.hide("add-courses");
    },

    fetchCourses() {
      this.fetchingCourse = true;
      Axios.get("/course/tutor/" + this.tutor_id)
        .then((response) => {
          this.courses = response.data;
          this.fetchingCourse = false;
        })
        .catch((err) => {
          this.fetchingCourse = false;
          console.error(err);
        });
    },
  },
  components: {
    Loading,
    AddCourses,
    VueLoadingButton,
  },
  mounted() {
    this.fetchCourses();
  },
};
</script>
