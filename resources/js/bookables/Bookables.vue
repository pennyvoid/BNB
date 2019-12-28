<template>
    <div v-if="loading">Loading...</div>
    <div v-else>
        <div
            class="row mb-4"
            v-for="(row, column) in rows"
            :key="'row' + row + column"
        >
            <div
                class="col d-flex align-items-stretch"
                v-for="(bookable, column) in bookablesRow(row)"
                :key="'bookable' + bookable + column"
            >
                <bookables-item-list v-bind="bookable"></bookables-item-list>
            </div>
            <div
                class="col d-flex align-items-stretch"
                v-for="(rest, column) in restBookablesRow(row)"
                :key="'rest' + rest + column"
            ></div>
        </div>
    </div>
</template>

<script>
import BookablesItemList from "./BookablesItemList";
export default {
    components: {
        BookablesItemList
    },
    data() {
        return {
            loading: false,
            column: 3,
            bookables: null
        };
    },
    computed: {
        rows() {
            if (this.bookables == null) {
                return;
            }
            return Math.ceil(this.bookables.length / this.column);
        }
    },
    methods: {
        bookablesRow(row) {
            return this.bookables.slice(
                (row - 1) * this.column,
                row * this.column
            );
        },
        restBookablesRow(row) {
            return this.column - this.bookablesRow(row).length;
        }
    },
    created() {
        this.loading = true;
        axios.get("/api/bookables").then(response => {
            this.bookables = response.data;
            this.loading = false;
        });
    }
};
</script>
