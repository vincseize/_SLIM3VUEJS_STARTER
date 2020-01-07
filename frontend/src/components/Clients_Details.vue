<template>
  <div class="details container">
    <router-link to="/">Back</router-link>
    <h1 class="page-header">{{client.nom}} {{client.email}}
        <span class="pull-right">
            <router-link class="btn btn-primary" v-bind:to="'/edit/'+client.id">Edit</router-link>
            <button class="btn btn-danger" v-on:click="deleteCustomer(client.id)">Delete</button>
            </span>
    </h1>
        <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> {{client.nom}}</li>
            <li class="list-group-item"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {{client.email}}</li>
        </ul>
    <!-- 
        <ul class="list-group">
            <li class="list-group-item"> {{client.address}}</li>
            <li class="list-group-item">{{client.city}}</li>
            <li class="list-group-item">{{client.state}}</li>
        </ul> -->
  </div>
</template>

<script>
export default {
  name: 'clientdetails',
  data () {
    return {
      client: ''
    }
  },
  methods:{
      fetchTable(id){
          this.$http.get(`${api_url}/clients/${id}`)
          .then(function(response){
            this.client = response.body;
          });
      },
      deleteCustomer(id){
          this.$http.delete(`${api_url}/clients/delete/${id}`)
          .then(function(response){
            this.$router.push({path: '/', query: {alert: 'Client Deleted'}});
          });
      }
  },
  created: function(){
      this.fetchTable(this.$route.params.id);
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
