require("./bootstrap");
import VueRouter from "vue-router";
import Vuex from "vuex";
import Index from "./Index";
import router from "./routes";
import moment from "moment";
import FatalError from "./components/FatalError";
import Success from "./components/Success";
import storeDefintion from "./store";
window.Vue = require("vue");
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.filter("fromNow", value => moment(value).fromNow());
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
const store = new Vuex.Store(storeDefintion);
const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        Index
    },
    beforeCreate() {
        this.$store.dispatch("loadStoredState");
    }
});
