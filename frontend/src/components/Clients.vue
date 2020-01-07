<template>
  <div class="customers container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Manage Clients</h1>
    <input class="form-control" placeholder="Enter Nom" v-model="filterInput">
    <br />
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Email</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="client in filterBy(clients, filterInput)">
            <td>{{client.id}}</td>
            <td>{{client.nom}}</td>
            <td>{{client.email}}</td>
            <td><router-link class="btn btn-default" v-bind:to="'/client/'+client.id">View</router-link></td>
          </tr>
        </tbody>
    </table>
  </div>
</template>

<script>
  import Alert from './Alert';
  export default {
    name: 'clients',
    data () {
      return {
        clients: [],
        alert:'',
        filterInput:''
      }
    },
    methods: {
      fetchTable(){
        this.$http.get(`${api_url}/clients`)
          .then(function(response){
            this.clients = response.body;
          });
      },
      filterBy(list, value){
        value = value.charAt(0).toUpperCase() + value.slice(1);
        return list.filter(function(client){
          return client.nom.toUpperCase().indexOf(value) > -1;
        });
      }
    },
    created: function(){
      if(this.$route.query.alert){
        this.alert = this.$route.query.alert;
      }
      this.fetchTable();
    },
    updated: function(){
      this.fetchTable();
    },
    components: {
      Alert
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
