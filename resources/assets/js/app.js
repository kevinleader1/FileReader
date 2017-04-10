
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
import VueRouter from 'vue-router' ;

// On initialise le routeur
Vue.use(VueRouter) ;

// On initialise vueRessource pour effectuer des requetes ajax
var VueResource = require('vue-resource');

// On initialise VueResource
Vue.use(VueResource);

// On créer un routeur en mode history, on lie le composant fileReader
const router = new VueRouter({
    mode : 'history' ,
    routes : [{
        path : '/' ,
        composent : Vue.component('fileReader', require('./components/fileReader.vue'))
    }]
}) ;


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app' ,
    router ,
    methods : {
       goRoute : function($step){
           // Unique fonction global pour lorsque l'on clique sur le bouton précédent
           router.go($step) ;
       }
    }
});
