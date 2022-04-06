import Vue from 'vue'
import App from './App'

Vue.mixin({ methods: { t, n } })

export default new Vue({
	el: '#app',
	render: h => h(App),
})
