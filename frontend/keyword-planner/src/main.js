import Vue from 'vue'
import App from './App.vue'
import Page404 from './404.vue'
import TargetLocations from './TargetLocations.vue'
import FindKeywords from './FindKeywords.vue'



const routes = {
    '/': App,
    '/target-locations': TargetLocations,
    '/find-keywords': FindKeywords
}

new Vue({
    el: '#app',
    data: {
        currentRoute: window.location.pathname
    },
    computed: {
        ViewComponent () {
            return routes[this.currentRoute] || Page404
        }
    },
    render (h) { return h(this.ViewComponent) }
    // render: h => h(this.ViewComponent)
})
