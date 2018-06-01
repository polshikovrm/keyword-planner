import Vue from 'vue'
import App from './App.vue'
import Page404 from './404.vue'
import TargetLocations from './TargetLocations.vue'
import FindKeywords from './FindKeywords.vue'
import RoiCalculator from './RoiCalculator.vue'
import UserManagement from './UserManagement.vue'

var VueCookie = require('vue-cookie');
// Tell Vue to use the plugin
Vue.use(VueCookie);



const routes = {
    '/demand-tool/': App,
    '/demand-tool/target-locations': TargetLocations,
    '/demand-tool/find-keywords': FindKeywords,
    '/demand-tool/roi-calculator': RoiCalculator,
    '/demand-tool/user-management': UserManagement
}

Vue.mixin({
    created: function () {
        if(window.location.hostname == 'localhost' || window.location.hostname.indexOf('dev') !== -1){
            this.$config = {
                api: 'http://kp.localhost/api/'
            }
        }else{
            this.$config = {
                api: 'https://api.keyword-planner.clientflo.com/'
            }
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
            if(this.currentRoute =='/demand-tool/' && token==null){
                return routes[this.currentRoute] || Page404
            }else if(this.currentRoute =='/demand-tool/' && token!==null){
                window.location.href = '/demand-tool/target-locations';
                return;
            }
             if(this.currentRoute !=='/demand-tool/' && token!==null){
                 return routes[this.currentRoute] || Page404
             }
            return Page404
        }
    },
    render (h) { return h(this.ViewComponent) }
    // render: h => h(this.ViewComponent)
})

