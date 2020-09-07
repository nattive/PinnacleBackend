<template>
  <div>
    <button class="btn btn-primary btn-flat" @click="open()">
      <small>Add Module Title</small>
    </button>
    <sweet-modal modal-theme="light" overlay-theme="dark" ref="module">
      <div class="form-group">
          <p>Add module Group Title</p>
        <input type="text" class="form-control" v-model="module" />
      </div>
      <button class="btn btn-primary btn-flat" @click.prevent="saveModule">Save Module Title</button>
    </sweet-modal>
  </div>
</template>

<script>
import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import Axios from "axios";

export default {
  props: {
    course_id: Number
  },
  data() {
    return {
      module: ""
    };
  },
  methods: {
    open() {
      this.$refs.module.open();
    },
    saveModule() {
      if (this.module !== "") {
        Axios.post("/courses/nodules/store", {
          title: this.module,
          course_id: this.course_id
        })
          .then(res => {
            this.$swal("Success", res.data, "success");
          })
          .catch(err => {
            console.log(err);
          });
      } else {
        this.$swal("Error", "Input Module Title", "error");
      }
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
  components: {
    SweetModal,
    SweetModalTab
  }
};
</script>
