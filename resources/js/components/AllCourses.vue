<template>
  <div class="container">
    <div class="main-content">
      <div class="section__content section__content--p30">
        <div class="table-responsive table--no-card m-b-30">
          <table class="table table-borderless table-striped table-earning">
            <thead>
              <tr>
                <th>date</th>
                <th>Course ID</th>
                <th>Course Title</th>
                <th>Modules</th>
                <th>Approval Status</th>
                <th>Fee</th>
                <th>Update Approval Status</th>
              </tr>
            </thead>
            <tbody>
              <loading :active.sync="loading" :is-full-page="!fullPage"></loading>
              <tr v-for="(course, index) in courses" :key="index">
                <td>{{ new Date( course.created_at)}}</td>
                <td>100398</td>
                <td>{{ course.title}}</td>
                <td class="text-right">{{course.modules.length}}</td>
                <td
                  class="text-right"
                >{{course.isApproved === 'true' ? 'Approved' : 'Not Approved'}}</td>
                <td class="text-right">{{ course.price || 'Free'}}</td>
                <select
                  name
                  id
                  class="form-control p-2"
                  v-model="isApproved"
                  @change="approveCourse(course.id)"
                >
                  <option value="true" class="p-2">Approve</option>
                  <option value="false" class="p-2">Disapprove</option>
                </select>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Axios from "axios";

export default {
  props: {
    user: Object
  },
  data() {
    return {
      courses: {},
      isApproved: "",
      fullPage: true,
      loading: false
    };
  },
  components: {
    Loading
  },
  methods: {
    approveCourse(id) {
      Axios.post("/courses/approve/" + id, {
        isApproved: this.isApproved,
        ApprovedBy: this.user.name
      })
        .then(res => {
        //   this.$swal("Updated", res.data, "success");
          this.fetchCourses();

          console.log(res);
        })
        .catch(err => {
          console.log(err);
          this.$swal("Error", "An error occured, Try Later ", "error");
        });
    },
    fetchCourses() {
      this.loading = true;
      Axios.get("admin/courses/index")
        .then(res => {
          this.courses = res.data.data;
          console.log(res);
          this.loading = false;
        })
        .catch(err => {
          this.loading = false;
          this.$swal("Error", "An error occured, Try Later ", "error");
          this.MainCategoryFectchError = err.message;
          console.log(err);
        });
    }
  },
  mounted() {
    this.fetchCourses();
  }
};
</script>
