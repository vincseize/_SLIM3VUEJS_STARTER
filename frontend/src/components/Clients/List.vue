<template>
  <div class="customers container">
    <h1 class="page-header">Manage Clients</h1>
    <Alert v-if="alert" :message="alert" />
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
          <tr v-for="client in filterBy(clients, filterInput)" :key="client.id">
            <td>{{client.id}}</td>
            <td>{{client.nom}}</td>
            <td>{{client.email}}</td>
            <td><router-link class="btn btn-default" :to="'/client/'+client.id">View</router-link></td>
          </tr>
        </tbody>
    </table>
  </div>
</template>

<script>
import Alert from '../Alert';

export default {
    name: 'clients',
    components: {
        Alert
    },
    data() {
        return {
            clients: [],
            alert: '',
            filterInput: ''
        };
    },
    created() {
        if (this.$route.query.alert){
            this.alert = this.$route.query.alert;
        }

        this.fetchTable();
    },
    updated() {
        this.fetchTable();
    },
    methods: {
        fetchTable() {
            this.$http.get(`${api_url}/clients`).then(
                (response) => {
                    this.clients = response.body;
                }
            );
        },

        filterBy(list, value) {
            const _value = value.charAt(0).toUpperCase() + value.slice(1);

            return list.filter((client) => (
                client.nom.toUpperCase().indexOf(_value) > -1
            ));
        }
    }
}
</script>
