<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Create Main Category</div>
            <div class="card-body">
              <form action method="post" novalidate="novalidate">
                <loading :active.sync="createMainCategoryLoading" :is-full-page="false"></loading>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control mb-1"
                    aria-required="true"
                    aria-invalid="false"
                    autocomplete="category"
                    placeholder="Input Main Category"
                    v-model="inputMainCategory"
                  />
                  <div>
                    <button
                      type="submit"
                      :disabled="inputMainCategory === ''"
                      @click.prevent="createMainCategory"
                      class="btn btn-lg btn-info btn-block"
                    >
                      <span
                        id="payment-button-amount"
                        v-show="!createMainCategoryLoading"
                      >Add Main Category</span>
                    </button>
                  </div>
                </div>
                <hr class="my-4" />
                <div class="row form-group">
                  <div class="form-label m-2">Create Sub Category</div>
                  <select
                    name="select"
                    id="select"
                    class="form-control m-3"
                    v-model="maincategoryId"
                  >
                    <option
                      class="p-2"
                      v-for="(category, index) in MainCategoriesFromDb"
                      :key="index"
                      :value="category.id"
                    >{{category.name}}</option>
                  </select>
                </div>
              </form>
              <div class="form-group mt-3">
                <!-- v-model="mainCategory" -->
                <input
                  type="text"
                  class="form-control"
                  aria-required="true"
                  aria-invalid="false"
                  placeholder="Input Sub-category Name"
                  v-model="subCategoryName"
                />
              </div>
              <div>
                <button
                  type="submit"
                  class="btn btn-lg btn-info btn-block"
                  @click.prevent="createSubCategory"
                >
                  <span id="payment-button-amount">Add Sub Category</span>
                  <span id="payment-button-sending" style="display:none;">Sending…</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="top-campaign">
            <h3 class="title-3 m-b-30">All Main Categories</h3>
            <div class="table-responsive">
              <table class="table table-top-campaign">
                <tbody v-for="(category, index) in MainCategoriesFromDb" :key="index">
                  <tr>
                    <td>{{index + 1}}. {{category.name}}</td>
                    <td>$70,261.65</td>
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
      mainCategory: "",
      inputMainCategory: "",
      createMainCategoryLoading: false,
      MainCategoriesFromDb: {},
      MainCategoryFectchError: "",
      maincategoryId: "",
      subCategoryName: ""
    };
  },
  components: {
    Loading
  },
  methods: {
    createMainCategory() {
      this.createMainCategoryLoading = true;
      if (this.inputMainCategory !== "") {
        Axios.post("/courses/main_controller/store", {
          name: this.inputMainCategory
        }).then(res => {
          console.log(res);
          this.$swal(
            "Done",
            "Tutor Account Created!! Please wait while the page refreshes",
            "success"
          );
          this.fetchMainCategory();
        });
      } else {
        alert("error");
      }
      this.createMainCategoryLoading = false;
    },
    createSubCategory() {
      if (this.maincategoryId !== "" && this.subCategoryName) {
        Axios.post("/courses/sub_controller/store", {
          main_category_id: this.maincategoryId,
          name: this.subCategoryName
        }).then(res => {
          this.$swal("Done", "Added Sub category to Main Category", 'success');
        });
      } else {
        this.$swal("Error", "Please Choose main category", "error");
      }
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
    }
  },
  mounted() {
    this.fetchMainCategory();
  }
};
</script>
