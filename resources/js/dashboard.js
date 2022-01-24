require('./bootstrap')

require('./bulma')

window.Vue = require('vue');

import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

const app = new Vue({
    el: '#app',
    data: {
        options: [],
        selected: null,
        stocks: null
    },
    methods: {
        onSearch(search, loading) {
            if (search.length) {
                loading(true);
                this.search(loading, search, this);
            }
        },
        onChange(event) {
            console.log(event.target.value)
        },
        search: _.debounce((loading, search, vm) => {
            fetch(
                `/search/products?q=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350)
    },
    watch: {
        selected: function() {
            if (this.selected && this.selected.id) {
                axios.get('/stocks/'+this.selected.id).then(response => this.stocks = response.data)
            } else {
                this.stocks == null
            }
        }
    }
})
