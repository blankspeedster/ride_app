<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <edit-profile-form>
          </edit-profile-form>
        </div>
        <div class="col-md-4">
          <!-- <user-card>
          </user-card> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import EditProfileForm from './Users/EditUsers.vue'
//   import UserCard from './Users/UserCard.vue'

  export default {
    components: {
      EditProfileForm,
    //   UserCard
    }
  }

</script>
<style>

</style>
