import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import About from "../views/About.vue";
import Home from "../views/Home.vue";
import Contact from "../views/Contact.vue";
// import Distributed from "../views/Distributed.vue";

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes:  [
		{
			path: "/",
			name: "Home",
			component: Home
		},
	
		{
			path: "/pages/empresa",
			name: "About",
			component: About
		},		
		{
			path: "/pages/contacto",
			name: "Contact",
			component: Contact
		},
		// {
		// 	path: "/pages/distributed",
		// 	name: "distributed",
		// 	component: Distributed
		// }
	]
})

export default router