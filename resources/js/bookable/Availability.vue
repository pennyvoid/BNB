<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            check availability
            <transition>
                <span class="text-uppercase text-success" v-if="available"
                    >(available)</span
                >
                <span class="text-uppercase text-danger" v-if="notAvailable"
                    >(not available)</span
                >
            </transition>
        </h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input
                    type="text"
                    name="from"
                    class="form-control form-control-sm"
                    placeholder="Start Date"
                    v-model="from"
                    @keyup.enter="check"
                    :class="[{ 'is-invalid': errorFor('from') }]"
                />
                <div class="invalid-feedback">{{ errorFor("from") }}</div>
            </div>
            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input
                    type="text"
                    name="to"
                    class="form-control form-control-sm"
                    placeholder="End Date"
                    v-model="to"
                    @keyup.enter="check"
                    :class="[{ 'is-invalid': errorFor('to') }]"
                />
                <div class="invalid-feedback">{{ errorFor("to") }}</div>
            </div>
        </div>
        <button
            class="btn btn-secondary btn-block"
            @click="check"
            :disabled="loading"
        >
            <span v-if="!loading">Check</span>
            <span v-if="loading"
                ><i class="fa fa-spinner fa-spin fa-fw"></i> Checking</span
            >
        </button>
    </div>
</template>
<script>
import { is422 } from "../utility/error";
import { mapActions } from "vuex";
export default {
    props: {
        bookableId: [String, Number]
    },
    data() {
        return {
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            status: null,
            errors: null,
            loading: false
        };
    },
    beforeCreate() {
        this.$store.dispatch("loadStoredState");
    },
    methods: {
        async check() {
            this.loading = true;
            this.errors = null;
            this.$store.dispatch("setLastSearch", {
                from: this.from,
                to: this.to
            });
            try {
                this.status = (
                    await axios.get(
                        `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
                    )
                ).status;
                this.$emit("availability", this.available);
            } catch (error) {
                if (is422(error)) {
                    this.errors = error.response.data.errors;
                }
                this.status = error.response.status;
                this.$emit("availability", this.available);
            }

            this.loading = false;
        },
        errorFor(field) {
            return this.hasErrors && this.errors[field]
                ? this.errors[field][0]
                : null;
        }
    },
    computed: {
        hasErrors() {
            return 422 === this.status && this.errors !== null;
        },
        available() {
            return 200 === this.status;
        },
        notAvailable() {
            return 404 === this.status;
        }
    }
};
</script>

<style scoped>
label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: gray;
}
.is-invalid {
    border-color: red;
    background-image: none;
}
.invalid-feedback {
    color: red;
}
</style>
