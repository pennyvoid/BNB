<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            price breakdown
        </h6>
        <div
            v-for="(days, price) in price.breakdown"
            :key="price"
            class="py-2  border-bottom d-flex justify-content-between"
        >
            <span >{{ days }} x ${{ price }}</span>
            <span>${{ days * price }}</span>
        </div>
        <div
            class="pt-2 font-weight-bolder d-flex justify-content-between text-uppercase"
        >
            <span>Total</span>${{ price.total }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        price: Object
    }
};
</script>
