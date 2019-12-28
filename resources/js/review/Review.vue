<template>
    <div>
        <success v-if="success"></success>
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-if="!success && !error">
            <div
                :class="[
                    { 'col-md-4': !alreadyReviewed },
                    { 'd-none': alreadyReviewed }
                ]"
                class="mb-2"
            >
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading" class="text-muted">Loading...</div>
                        <div v-if="hasBooking">
                            <p>
                                <strong class="text-muted">Stayed At:</strong>
                                <router-link
                                    style="text-decoration: none"
                                    :to="{
                                        name: 'bookable',
                                        params: {
                                            id: booking.bookable.bookable_id
                                        }
                                    }"
                                    >{{ booking.bookable.title }}</router-link
                                >
                            </p>
                            <p>
                                <strong class="text-muted">From:</strong>
                                {{ booking.from }}
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <strong class="text-muted">To:</strong>
                                {{ booking.to }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                :class="[
                    { 'col-md-8': !alreadyReviewed },
                    { 'col-md-12': alreadyReviewed }
                ]"
            >
                <div class="text-muted" v-if="loading">Loading...</div>
                <div v-else>
                    <h3 class="text-muted" v-if="alreadyReviewed">
                        You've already left a review for this booking.
                    </h3>
                    <div v-else>
                        <div class="form-group">
                            <label class="label-control text-muted">
                                <strong>The Rating Selection:</strong>
                            </label>
                            <star-rating
                                class="fa-2x"
                                @rating="updateRating"
                            ></star-rating>
                        </div>
                        <div class="form-group">
                            <label class="text-muted label-control">
                                <strong>Descripe Your Experience:</strong>
                            </label>
                            <textarea
                                name="content"
                                rows="5"
                                class="form-control"
                                v-model="review.content"
                                :class="[{ 'is-invalid': errorFor('content') }]"
                            ></textarea>
                            <div class="invalid-feedback">
                                <h6>{{ errorFor("content") }}</h6>
                            </div>
                        </div>
                        <button
                            class="btn btn-primary btn-block"
                            @rating="updateRating($event)"
                            @click.prevent="submit"
                            :disabled="sending"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarRating from "../shared/components/StarRating";
import { is404, is422 } from "../utility/error";
export default {
    components: {
        StarRating
    },
    data() {
        return {
            review: {
                id: null,
                rating: 0,
                content: ""
            },
            existingReview: null,
            booking: null,
            loading: false,
            sending: false,
            success: false,
            error: false,
            errors: null
        };
    },
    methods: {
        updateRating(rating) {
            this.review.rating = rating;
        },
        submit() {
            this.errors = null;
            this.sending = true;
            this.success = false;
            axios
                .post("/api/reviews", this.review)
                .then(response => (this.success = 201 === response.status))
                .catch(error => {
                    if (is422(error)) {
                        const errors = error.response.data.errors;
                        if (errors["content"] && _.size(errors) === 1) {
                            this.errors = errors;
                        }
                    }
                })
                .then(() => (this.sending = false));
        },
        errorFor(field) {
            return this.errors != null && this.errors[field]
                ? this.errors[field][0]
                : null;
        }
    },
    async created() {
        this.review.id = this.$route.params.id;
        this.loading = true;
        try {
            this.existingReview = (
                await axios.get(`/api/reviews/${this.review.id}`)
            ).data;
        } catch (error) {
            if (is404(error)) {
                try {
                    this.booking = (
                        await axios.get(
                            `/api/booking-by-review-key/${this.review.id}`
                        )
                    ).data;
                } catch (error) {
                    if (!is404(error)) {
                        this.error = true;
                    }
                }
            } else {
                this.error = true;
            }
        }
        this.loading = false;
    },
    computed: {
        alreadyReviewed() {
            return this.hasReviewed || !this.hasBooking;
        },
        hasReviewed() {
            return this.existingReview !== null;
        },
        hasBooking() {
            return this.booking !== null;
        }
    }
};
</script>
<style scoped>
.is-invalid {
    border-color: red;
    background-image: none;
}
.invalid-feedback {
    color: red;
}
</style>
