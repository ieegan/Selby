require('./bootstrap')

window.Vue = require('vue');
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

const app = new Vue({
    el: '#app'
});
