<template>
  <div>
    <nav class="nav bg-white border-bottom navbar-light">
      <router-link :to="{name:'bookables'}" class="navbar-brand mr-auto ml-2">BNB</router-link>
      <router-link class="btn nav-button" :to="{name: 'basket'}">
        Basket
        <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
      </router-link>
    </nav>
    <div class="container mt-4 mb-4 pr-4 pl-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  data() {
    return {
      lastSearch: this.$store.state.lastSearch
    };
  },
  computed: {
    ...mapState({
      lastSearchComputed: "lastSearch"
    }),
    ...mapGetters({
      itemsInBasket: "itemsInBasket"
    })
  }
};
</script>
