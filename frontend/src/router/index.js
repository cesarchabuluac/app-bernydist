import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import About from "../views/About.vue";
import Home from "../views/Home.vue";
import Contact from "../views/Contact.vue";
import Careers from "../views/Careers.vue";

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
			path: "/careers",
			name: "Careers",
			component: Careers
		},
		{
			path: "/pages/contacto",
			name: "Contact",
			component: Contact
		}
	]
})

export default router