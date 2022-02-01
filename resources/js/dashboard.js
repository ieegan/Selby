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
        stocks: null,
        codeNumber: null,
    },
    methods: {
        onSearch(search, loading) {
            if (search.length) {
                loading(true);
                this.search(loading, search, this);
            }
        },
        onPSearch(search, loading) {
            if (search.length) {
                loading(true);
                this.psearch(loading, search, this);
            }
        },
        search: _.debounce((loading, search, vm) => {
            fetch(
                `/search/products?q=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350),
        psearch: _.debounce((loading, search, vm) => {
            fetch(
                `/search/products?s=1&q=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350)
    },
    watch: {
        selected: function () {
            if (this.selected && this.selected.id) {
                axios.get('/stocks/' + this.selected.id).then(response => this.stocks = response.data)
            } else {
                this.stocks == null
            }
        },
        codeNumber: function () {
            // Card number without dash (-)
            if (this.codeNumber) {
                var x = this.codeNumber.replace(/\D/g, '').match(/(\d{0,3})(\d{0,4})(\d{0,2})/);
                this.codeNumber = this.codeNumber.length <= 3 ? x[1] : (this.codeNumber.length <= 7 ? x[1] + '-' + x[2] : x[1] + '-' + x[2] + '-' + x[3]);
            } else {
                return null
            }
        }
    }
})
