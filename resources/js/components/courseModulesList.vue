<template>
  <div class="container">
    <div class="main-content">
      <div class="section__content section__content--p30">
        <div class="row">
          <div class="col-md-4">
            <div class="table-responsive table--no-card m-b-30">
              <table class="table table-borderless table-striped table-earning">
                <thead>
                  <tr>
                    <th>Module title</th>
                    <th>Materials in module</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- <loading :active.sync="loading" :is-full-page="!fullPage"></loading> -->
                  <tr
                    v-for="(modules, key) in materials.modules"
                    :key="key"
                    v-on:click="getMaterial(modules.id)"
                  >
                    <td>{{modules.title.substring(0,100)}}...</td>
                    <td>{{modules.course_materials.length}}...</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-7">
            <div class="table-responsive table--no-card m-b-30">
              <table class="table table-borderless table-striped table-earning">
                <thead>
                  <tr>
                    <th>Course Material title</th>
                    <th>Material objective</th>
                    <th>Material prerequisite</th>
                    <th>Total questions</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody  v-if="course_materials !== {}" >
                  <tr v-for="(material, key) in course_materials" :key="key">
                    <td>{{material.title}}</td>
                    <td>{{material.objective.substring(0,50)}}</td>
                    <td>{{material.prerequisite.substring(0,50)}}</td>
                    <td>{{material.course_questions.length}}</td>
                    <td>
                      <a :href="`/courses/add-question/${material.id}`" class="btn btn-flat btn-success"><i class="fa fa-plus"></i><i class="fa fa-question"></i></a>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                    <td colspan="5" class="text-center">Select a Module</td>
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
import Axios from "axios";

export default {
  props: {
    materials: Object
  },
  data() {
    return {
      course_materials: {}
    };
  },
  methods: {
    getMaterial(id) {
      Axios.get(`/courses/modules/show/${id}`)
        .then(res => (this.course_materials = res.data.course_materials))
        .catch(err => console.log(err));

      //   alert(id);
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
