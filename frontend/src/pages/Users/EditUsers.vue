<template>
  <card>
    <h4 slot="header" class="card-title">Add / Edit Users</h4>
    <form>
      <div class="row">

        <div class="col-md-3">
          <base-input
            type="text"
            label="First Name"
            v-model="firstName"
          >
          </base-input>
        </div>

        <div class="col-md-3">
          <base-input
            type="text"
            label="Last Name"
            v-model="lastName"
          >
          </base-input>
        </div>

        <div class="col-md-3">
          <base-input
            type="date"
            label="Birthday"
            v-model="birthday"
          >
          </base-input>
        </div>      

        <div class="col-md-3">
          <base-input
            type="email"
            label="Email Address"
            v-model="email"
          >
          </base-input>
        </div>

        <div class="col-md-3">
          <base-input
            type="text"
            label="Address"
            v-model="address"
          >
          </base-input>
        </div>

        <div class="col-md-3">
          <base-input
            type="password"
            label="password"
            v-model="password"
          >
          </base-input>
        </div>        







        <div v-if="replied" class="col-md-12">
          Allow Ride Feedback: {{allow}}<br>
          Please Follow these Recommendations: {{suggestions}}
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
        >
          Save Information
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
        firstName: "",
        lastName: "",
        birthday: "",
        email: "",
        address: "",
        
        allow: "yes",
        suggestions: "",

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
      data.append("blood_pressure_systolic", this.blood_pressure);
      data.append("blood_pressure_diastolic", this.blood_pressure);
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
          console.log(response.data);
          this.allow = response.data.allow;
          this.suggestions = response.data.suggestions;
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
