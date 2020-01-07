<template>
  <div class="edit container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Edit Client</h1>
    <form v-on:submit="updateClient">
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
<!--
        <div class="well">
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
        fetchTable(id){
            
            this.$http.get(`${api_url}/clients/${id}`)
            .then(function(response){
                this.client = response.body;
            });
        },
        updateClient(e){
            if(!this.client.nom){
                this.alert = 'Please fill in all required fields';
            } else {
                let updClient = {
                    nom: this.client.nom,
                    email: this.client.email
                }
                this.$http.put(`${api_url}/clients/update/${this.$route.params.id}`, updClient)
                    .then(function(response){
                        this.$router.push({path: '/', query: {alert: 'Client Updated'}});
                    });

                e.preventDefault();
            }
            e.preventDefault();
        }
    },
    created: function(){
        this.fetchTable(this.$route.params.id);
    },
    components:{
        Alert
    }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
