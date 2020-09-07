<template>
  <div class="main-content">
    <div class="section__content section__content--p30">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex">
              <h4>Add Quiz to Module</h4>
            </div>
            <div class="card-body">
              <form action>
                <div class="form-group">
                  <loading :active.sync="isLoading" :is-full-page="!fullPage"></loading>
                  <!-- <p for="company" class="lead">Question :</p> -->
                  <p class="alert alert-danger" v-show="successMessage !== ''">{successMessage}</p>
                  <textarea name v-model="question" class="form-control" id cols="30" rows="10"></textarea>
                  <h5 for="company" class="m-2">Options</h5>
                  <div class="container">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="C" class="form-control-label">A</label>
                          <textarea
                            name
                            v-model="optionA"
                            placeholder="input options here"
                            class="form-control"
                            cols="10"
                            rows="3"
                          ></textarea>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="d" class="form-control-label">B</label>
                          <textarea
                            name
                            v-model="optionB"
                            placeholder="input options here"
                            class="form-control"
                            cols="10"
                            rows="3"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="C" class="form-control-label">C</label>
                          <textarea
                            v-model="optionC"
                            placeholder="input options here"
                            class="form-control"
                            cols="10"
                            rows="3"
                          ></textarea>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="D" class="form-control-label">D</label>
                          <textarea
                            v-model="optionD"
                            placeholder="input options here"
                            class="form-control"
                            cols="10"
                            rows="3"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label
                        for="answer"
                        class="form-control-label ml-4 mt-4"
                      >Please Select which is the right answer</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <select
                        name="answer"
                        v-model="answer"
                        id="selectLg"
                        class="form-control-lg form-control"
                      >
                        <option disabled>Please select</option>
                        <option value="A">Option A</option>
                        <option value="B">Option B</option>
                        <option value="C">Option C</option>
                        <option value="D">Option D</option>
                      </select>
                    </div>
                  </div>
                  <button @click.prevent="saveQuestion" class="btn btn-primary mt-4">Save</button>
                  <hr />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import Axios from "axios";
export default {
  props: {
    material: Object
  },
  data() {
    return {
      question: "",
      course_materials_id: "",
      optionA: "",
      optionB: "",
      optionC: "",
      optionD: "",
      A: "",
      B: "",
      C: "",
      D: "",
      isAnswer: "",
      successMessage: "",
      answer: "",
      fullPage: true,
      isLoading: false
    };
  },
  components: {
    Loading
  },
  methods: {
    addQuestion() {
      console.log(this.A);
    },
    saveQuestion() {
      this.isLoading = true;
      Axios.post("/courses/add-question", {
        question: this.question,
        course_materials_id: this.material.id,
        optionA: this.optionA,
        optionB: this.optionB,
        optionC: this.optionC,
        optionD: this.optionD,
        answer: this.answer
      })
        .then(res => {
          this.isLoading = false;
          this.$swal(res.data, "success");

          console.log(res.data);
        })
        .catch(err => console.error(err));
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
