<template>
  <div class="add container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Add Client</h1>
    <form v-on:submit="add">
        <div class="well">
            <h4>Client Info</h4>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" placeholder="Nom" v-model="client.nom">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Email" v-model="client.email">
            </div>
        </div>
        <!-- <div class="well">
            <h4>Client Contact</h4>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Email" v-model="client.email">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" placeholder="Phone" v-model="client.phone">
            </div>
        </div> -->

        <!-- <div class="well">
            <h4>Client Location</h4>
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Address" v-model="client.address">
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" class="form-control" placeholder="City" v-model="client.city">
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" class="form-control" placeholder="State" v-model="client.state">
            </div>
        </div> -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
    import Alert from './Alert'
    export default {
    name: 'add',
    data () {
        return {
        client: {},
        alert:''
        }
    },
    methods: {
        add(e){
            if(!this.client.nom){
                // if(!this.client.nom || !this.client.email){
                this.alert = 'Please fill in all required fields';
            } else {
                let newClient = {
                    nom: this.client.nom,
                    email: this.client.email
                }
                this.$http.post(`${api_url}/clients/add`, newClient)
                    .then(function(response){
                        this.$router.push({path: '/', query: {alert: 'Client Added'}});
                    });

                e.preventDefault();
            }
            e.preventDefault();
        }
    },
    components: {
        Alert
    }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
