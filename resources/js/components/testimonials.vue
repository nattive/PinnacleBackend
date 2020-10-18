<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Add Testimonials</div>
            <div class="card-body">
              <form action method="post" novalidate="novalidate">
                <loading
                  :active.sync="createMainCategoryLoading"
                  :is-full-page="false"
                ></loading>
                <div class="form-group">
                  <label class="form-control-label">Testifiers name *</label>
                  <input
                    type="text"
                    class="form-control mb-1"
                    aria-required="true"
                    aria-invalid="false"
                    autocomplete="category"
                    placeholder="e.g John Doe"
                    max="250"
                    v-model="userName"
                  />
                </div>
                <div class="form-group">
                  <label class="form-control-label"
                    >Testifier's position/work title</label
                  >
                  <input
                    type="text"
                    class="form-control mb-1"
                    aria-invalid="false"
                    autocomplete="category"
                    placeholder="e.g CEO pinnacle inc"
                    v-model="userTitle"
                  />
                </div>
                <div class="form-group">
                  <label class="form-control-label"
                    >Indicate where the Testimonial should be displayed *</label
                  >
                  <select
                    name="select"
                    v-model="position"
                    id="select"
                    class="form-control"
                  >
                    <option value="Homepage">Homepage</option>
                    <option value="Ulearn">Ulearn Page</option>
                    <option value="CotF">CotF Page</option>
                    <option value="Tutor">Tutor Page</option>
                    <option value="Volunteer">Volunteer Page</option>
                    <option value="Coach">Coach Page</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-control-label">Testimoial *</label>
                  <textarea
                    type="text"
                    class="form-control mb-1"
                    cols="9"
                    placeholder="testimonial body goes here..."
                    v-model="body"
                    maxlength="500"
                  />
                  <small class="text-muted">max length 500</small>
                </div>
                <div>
                  <button
                    type="submit"
                    class="btn btn-lg btn-info btn-block"
                    @click.prevent="createTestimonial"
                  >
                    <span v-if="creatingTestimonial === true" id="payment-button-sending" style="display: none"
                      >Sending…</span
                    >
                    <span v-else id="payment-button-amount">Upload Testimonial</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="top-campaign">
            <h3 class="title-3 m-b-30">All Testimonials</h3>
            <div class="table-responsive">
              <table class="table table-top-campaign">
                  <thead>
                      <td>Name</td>
                      <td>Testimonial Location</td>
                      <td>Testimonial Text</td>
                  </thead>
                <tbody
                  v-for="(testimonial, index) in testimonials"
                  :key="index"
                >
                  <tr>
                    <td>{{ index + 1 }}. {{ testimonial.userName }}</td>
                    <td>{{ testimonial.position }}</td>
                    <td>{{testimonial.body.substring(0,10)}}...</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
  data() {
    return {
      userName: "",
      userTitle: "",
      testimonials: [],
      creatingTestimonial: false,
      position: "",
      body: "",
    };
  },
  components: {
    Loading,
  },
  methods: {
    createTestimonial() {
      this.creatingTestimonial = true;
      if (this.body !== "") {
        Axios.post("/admin/testimonial", {
          userName: this.userName,
          userTitle: this.userTitle,
          position: this.position,
          body: this.body,
        }).then((res) => {
          console.log(res);
          this.$swal(
            "Done",
            "Testimial uploaded succesfully",
            "success"
          );
          this.fetchTestimonials();
        }).catch(err => alert(err.response.data && err.response.data.message))
      } else {
        alert("some required fields are missing");
      }
      this.creatingTestimonial = false;
    },

    fetchTestimonials() {
      Axios.get("/admin/testimonial")
        .then((res) => {
          this.testimonials = res.data;
          console.log(res);
        })
        .catch((err) => {
          this.$swal("Error", "An error occured, Try Later ", "error");
          console.log(err);
        });
    },
  },
  mounted() {
    this.fetchTestimonials();
  },
};
</script>
