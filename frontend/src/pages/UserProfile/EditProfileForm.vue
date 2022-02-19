<template>
  <card>
    <h4 slot="header" class="card-title">Suggestion and Recommendation</h4>
    <form>
      <div class="row">
        <div class="col-md-3">
          <base-input
            type="number"
            label="Age"
            placeholder="20"
            v-model="age"
          >
          </base-input>
        </div>

        <div class="col-md-3">
          <base-input
            type="number"
            label="Blood Pressure"
            placeholder="0"
            v-model="blood_pressure"
          >
          </base-input>
        </div>
        <div class="col-md-3">
          <base-input
            type="number"
            label="Heart Rate"
            placeholder="0"
            v-model="heart_rate"
          >
          </base-input>
        </div>
        <div class="col-md-3">
          <base-input
            type="number"
            label="Respiration"
            placeholder="0"
            v-model="respiration"
          >
          </base-input>
        </div>
        <div v-if="replied" class="col-md-12">
          Response: {{allow}}
        </div>
        <div v-if="fireError" class="col-md-12">
          {{errorMessage}}
        </div>
      </div>

      <div class="row"></div>
      <div class="text-center">
        <button
          type="submit"
          class="btn btn-primary btn-fill float-right"
          @click.prevent="validatePredictProgram"
        >
          Proceed
        </button>
      </div>
      <div class="clearfix"></div>
    </form>
  </card>
</template>
<script>
import Card from "src/components/Cards/Card.vue";

export default {
  components: {
    Card,
  },
  data() {
    return {
        age: 0,
        blood_pressure: 0,
        heart_rate: 0,
        respiration: 0,
        
        allow: "yes",

        fireError: false,
        fireMessage: "",
        replied: false,
    };
  },
  methods: {
    updateProfile() {
      alert("Your data: " + JSON.stringify(this.user));
    },
    async validatePredictProgram() {
      this.fireError = true;
      this.errorMessage = "Loading...";
      var axios = require("axios");
      var FormData = require("form-data");
      var data = new FormData();
      
      data.append("age", this.age);
      data.append("blood_pressure", this.blood_pressure);
      data.append("heart_rate", this.heart_rate);
      data.append("respiration", this.respiration);


      var config = {
        method: "post",
        url: "http://localhost:5000/get-suggestion",
        headers: {},
        data: data,
      };

      await axios(config)
        .then((response) => {
          this.replied = true;
          this.allow = response.data;
          this.fireError = false;
        })
        .catch((error) => {
          this.replied = true;
          this.fireError = true;
          this.errorMessage =
            "There is an error attempting to predict the population";
        });
    },
  },
};
</script>
<style></style>
