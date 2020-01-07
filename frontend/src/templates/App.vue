<template>
    
    <div id="app">
        <nav class="navbar navbar-default">
            <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Vuejs Slim3</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                <li><router-link to="/">Clients</router-link></li>
                <li><router-link to="/about">About</router-link></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <li><router-link to="/add">Add Clients</router-link></li>
                </ul>
            </div><!--/.nav-collapse -->
            </div>
        </nav>
        <router-view></router-view>
    </div>
    
</template>
