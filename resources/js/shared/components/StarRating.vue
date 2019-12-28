<template>
  <div v-if="starRatings" class="d-flex">
    <li
      class="fa fa-star"
      v-for="rating in starRatings"
      :key="rating + 'rating'"
      :value="fullStar = rating"
      @click="star(rating)"
    ></li>
    <li
      class="fa fa-star-o"
      v-for="outline in rest"
      :key="outline + 'outline'"
      @click="restStar(outline)"
    ></li>
  </div>
  <div v-else>
    <li class="fa fa-star-o" v-for="number in 5" :key="number + 'number'" @click="star(number) "></li>
  </div>
</template>

<script>
export default {
  props: {
    ratings: {
      default: null,
      type: Number
    },
    disable: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      starRatings: this.ratings,
      fullStar: null
    };
  },
  computed: {
    rest() {
      return 5 - this.starRatings;
    }
  },
  methods: {
    star(value) {
      if (this.disable == false) {
        this.starRatings = value;
        this.$emit("rating", this.starRatings);
      }
    },
    restStar(restValue) {
      if (this.disable == false) {
        this.starRatings = this.fullStar + restValue;
        this.$emit("rating", this.starRatings);
      }
    }
  }
};
</script>
