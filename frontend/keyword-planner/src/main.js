import Vue from 'vue'
import App from './App.vue'
import Page404 from './404.vue'
import TargetLocations from './TargetLocations.vue'
import FindKeywords from './FindKeywords.vue'

var VueCookie = require('vue-cookie');
// Tell Vue to use the plugin
Vue.use(VueCookie);



const routes = {
    '/': App,
    '/target-locations': TargetLocations,
    '/find-keywords': FindKeywords
}

Vue.mixin({
    created: function () {
        this.$config = {
            api: 'http://kp.dev/api/'
        }
    }
})

new Vue({
    el: '#app',
    data: {
        currentRoute: window.location.pathname
    },
    computed: {
        ViewComponent () {
           var token = this.$cookie.get('PHPSESSID');
            if(this.currentRoute =='/' && token==null){
                return routes[this.currentRoute] || Page404
            }else if(this.currentRoute =='/' && token!==null){
               return location.href = '/target-locations';
            }
             if(this.currentRoute !=='/' && token!==null){
                 return routes[this.currentRoute] || Page404
             }
            return Page404
        }
    },
    render (h) { return h(this.ViewComponent) }
    // render: h => h(this.ViewComponent)
})

