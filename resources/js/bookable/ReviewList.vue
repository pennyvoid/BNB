<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder pt-4 d-none d-md-block">Review List</h6>
    <div class="border-bottom d-none d-md-block" v-for="(review, index) in reviews" :key="index">
      <div class="row pb-4 pt-2">
        <div class="col-md-6">Ali Kazemi</div>
        <div class="col-md-6 d-flex justify-content-end text-uppercase">
          <star-rating :ratings="review.rating" class="fa-lg" :disable="true"></star-rating>
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-md-12">{{ review.created_at | fromNow }}</div>
      </div>
      <div class="row pb-4">
        <div class="col-md-12">{{ review.content }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import StarRating from "../shared/components/StarRating";
export default {
  components: {
    StarRating
  },
  props: {
    bookableId: [String, Number]
  },
  data() {
    return {
      reviews: null,
      loading: false
    };
  },
  created() {
    this.loading = true;
    axios
      .get(`/api/bookables/${this.bookableId}/review`)
      .then(response => (this.reviews = response.data))
      .then(() => (this.loading = false));
  }
};
</script>
